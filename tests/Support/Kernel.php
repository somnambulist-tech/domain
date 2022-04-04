<?php declare(strict_types=1);

namespace Somnambulist\Components\Domain\Tests\Support;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use function dirname;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        return dirname(__DIR__).'/../var/cache/'.$this->environment;
    }

    public function getLogDir(): string
    {
        return dirname(__DIR__).'/../var/log';
    }

    public function getProjectDir(): string
    {
        return dirname(__DIR__);
    }
    public function registerBundles(): iterable
    {
        $contents = require dirname(__DIR__).'/Support/Stubs/config/bundles.php';
        foreach ($contents as $class => $envs) {
            if ($envs[$this->environment] ?? $envs['all'] ?? false) {
                yield new $class();
            }
        }
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('Stubs/config/{packages}/*.yaml');
        $container->import('Stubs/config/{packages}/'.$this->environment.'/*.yaml');
        $container->import('Stubs/config/{services}.yaml');
        $container->import('Stubs/config/{services}_'.$this->environment.'.yaml');
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('Stubs/config/{routes}/'.$this->environment.'/*.yaml');
        $routes->import('Stubs/config/{routes}/*.yaml');
        $routes->import('Stubs/config/{routes}.yaml');
    }
}
