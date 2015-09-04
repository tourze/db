<?php

namespace tourze\Db;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use tourze\Base\Base;
use tourze\Base\Config;
use tourze\Base\Helper\Arr;

/**
 * 数据库连接类，基于doctrine/dbal来实现
 *
 * @package tourze\Db
 */
class Db
{

    /**
     * @var string 默认读取的配置文件
     */
    public static $configFile = 'database';

    /**
     * @const  int  SELECT查询
     */
    const SELECT = 1;

    /**
     * @const  int  INSERT查询
     */
    const INSERT = 2;

    /**
     * @const  int  UPDATE查询
     */
    const UPDATE = 3;

    /**
     * @const  int  DELETE查询
     */
    const DELETE = 4;

    /**
     * @var  string  默认实例名
     */
    public static $default = 'default';

    /**
     * @var array 一个存放所有实例的数组
     */
    public static $instances = [];

    /**
     * @var array  额外的数据库字段格式支持
     */
    public static $mappingType = [
        'pdo_mysql' => [
            'enum'      => 'string',
            'set'       => 'string',
            'varbinary' => 'string',
        ],
    ];

    /**
     * @var array 一些默认设置
     */
    public static $defaultConfig = [
        'pdo_mysql' => [
            'wrapperClass'  => 'Facile\DoctrineMySQLComeBack\Doctrine\DBAL\Connection',
            'driverClass'   => 'Facile\DoctrineMySQLComeBack\Doctrine\DBAL\Driver\PDOMySql\Driver',
            'driverOptions' => [
                'x_reconnect_attempts' => 3
            ]
        ],
    ];

    /**
     * 单例模式，获取一个指定的实例
     *
     *     // 加载默认实例
     *     $db = Database::instance();
     *
     *     // 指定实例名称和配置
     *     $db = Database::instance('custom', $config);
     *
     * @param  string $name   实例名
     * @param  array  $config 配置参数
     * @return Connection
     */
    public static function instance($name = null, array $config = null)
    {
        if (null === $name)
        {
            $name = Db::$default;
        }

        if ( ! isset(Db::$instances[$name]))
        {
            // 读取配置
            if (null === $config)
            {
                $config = (array) Config::load(self::$configFile)->get($name);
                Base::getLog()->debug(__METHOD__ . ' get default config', [
                    'name' => $name,
                ]);
            }

            // 合并默认配置
            if (isset(self::$defaultConfig[Arr::get($config, 'driver')]))
            {
                $config = Arr::merge(self::$defaultConfig[Arr::get($config, 'driver')], $config);
                Base::getLog()->debug(__METHOD__ . ' merge config', [
                    'name' => $name
                ]);
            }

            $conn = DriverManager::getConnection($config);
            Base::getLog()->debug(__METHOD__ . ' create dbal connection', [
                'name' => $name
            ]);

            // 额外注册字段类型
            if (isset(self::$mappingType[Arr::get($config, 'driver')]))
            {
                $platform = $conn->getDatabasePlatform();
                foreach (self::$mappingType[Arr::get($config, 'driver')] as $dbType => $doctrineType)
                {
                    if ( ! $platform->hasDoctrineTypeMappingFor($dbType))
                    {
                        Base::getLog()->debug(__METHOD__ . ' add dbal mapping type', [
                            'raw'  => $dbType,
                            'dbal' => $doctrineType,
                        ]);
                        $platform->registerDoctrineTypeMapping($dbType, $doctrineType);
                    }
                }
            }

            Db::$instances[$name] = $conn;
            Base::getLog()->debug(__METHOD__ . ' save db instance', [
                'name' => $name
            ]);
        }

        return Db::$instances[$name];
    }
}
