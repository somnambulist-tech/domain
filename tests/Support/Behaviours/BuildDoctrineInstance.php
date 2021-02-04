<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support\Behaviours;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Tools\SchemaTool;
use Exception;
use PDOException;
use Somnambulist\Components\Domain\Doctrine\TypeBootstrapper;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\AbstractUser;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\Customer;
use Somnambulist\Components\Domain\Tests\Support\Stubs\Models\Order;

/**
 * Trait BuildDoctrineInstance
 *
 * @package    Somnambulist\Components\Domain\Tests\Support\Behaviours
 * @subpackage Somnambulist\Components\Domain\Tests\Support\Behaviours\BuildDoctrineInstance
 */
trait BuildDoctrineInstance
{

    /**
     * @var EntityManager
     */
    protected $em;

    protected function setUp(): void
    {
        $conn = [
            'driver'   => $GLOBALS['DOCTRINE_DRIVER'],
            'memory'   => $GLOBALS['DOCTRINE_MEMORY'],
            'dbname'   => $GLOBALS['DOCTRINE_DATABASE'],
            'user'     => $GLOBALS['DOCTRINE_USER'],
            'password' => $GLOBALS['DOCTRINE_PASSWORD'],
            'host'     => $GLOBALS['DOCTRINE_HOST'],
        ];

        $driver = new XmlDriver([
            __DIR__ . '/../Stubs/config/xml',
            __DIR__ . '/../../../config/xml/doctrine',
        ]);
        $config = new Configuration();
        $config->setMetadataCacheImpl(new ArrayCache());
        $config->setQueryCacheImpl(new ArrayCache());
        $config->setProxyDir(sys_get_temp_dir());
        $config->setProxyNamespace('Somnambulist\Components\Domain\Tests\Doctrine\Proxies');
        $config->setMetadataDriverImpl($driver);

        TypeBootstrapper::registerEnumerations();
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);

        $em = EntityManager::create($conn, $config);

        $schemaTool = new SchemaTool($em);

        try {
            $schemaTool->createSchema([
                $em->getClassMetadata(Order::class),
                $em->getClassMetadata(AbstractUser::class),
                $em->getClassMetadata(Customer::class),
            ]);
        } catch (Exception $e) {
            if (
                $GLOBALS['DOCTRINE_DRIVER'] != 'pdo_mysql' ||
                !($e instanceof PDOException && str_contains($e->getMessage(), 'Base table or view already exists'))
            ) {
                throw $e;
            }
        }

        $this->em = $em;
    }

    protected function tearDown(): void
    {
        $this->em = null;
    }
}
