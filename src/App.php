<?php
namespace App\Api;


use App\Api\Core\Configuration;
use App\Api\Core\Listener;
use App\Api\Core\Request;
use App\Api\Core\RequestInterface;
use App\Api\Core\Response;
use App\Api\Core\Router;
use App\Api\Core\YamlConfigLoader;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;

class App
{
    public function __construct()
    {
    }

    public function runWithConfig()
    {

        $cache = $this->loadConfig();
        $res = unserialize(file_get_contents($cache->getPath()));
        $router = Router::getInstance();
        foreach ($res['routes'] as $controllerName=>$route){
            $router->addAllowableRequest(new Request($route['pattern'],$route['method'],$controllerName,$route['public']));
        }
        $this->init($router);

    }

    public function runWithOutConfig()
    {

        $route = Router::getInstance();
        $route->addAllowableRequest(new Request('/api/items/',RequestInterface::METHOD_GET,'showAll',false));
        $route->addAllowableRequest(new Request('/api/item/{id}',RequestInterface::METHOD_GET,'show',false));
        $route->addAllowableRequest(new Request('/api/item_count',RequestInterface::METHOD_GET,'itemsCount',true));
        $route->addAllowableRequest(new Request('/api/auth',RequestInterface::METHOD_POST,'auth',true));
        $this->init($route);

    }

    protected function init(Router $router)
    {
        $logger = new Logger('APP');
        $logger->pushHandler(new StreamHandler('var/log/app.log', Logger::WARNING));
        //Benchmark::begin();
        $controller = Controller::getInstance();
          try{
            $app = new Listener($router,$controller,$_SERVER,$_GET,$_POST,$logger);
        }catch ( \RuntimeException $e){
            Response::getInstance()->renderJson(['msg'=>$e->getMessage()]);
        }

    }

    /**
     * @return ConfigCache
     * @throws \Exception
     */
    public function loadConfig(): ConfigCache
    {
        $cachePath = __DIR__ . '/../var/cache/config.php';
        $cache     = new ConfigCache($cachePath, false);

        if (!$cache->isFresh()) {
            $locator        = new FileLocator(__DIR__ . '/config/');
            $configFilePath = $locator->locate('config.yml');
            $loader         = new YamlConfigLoader($locator);
            $configValues   = $loader->load($locator->locate('config.yml'));
            $processor      = new Processor();
            $configuration  = new Configuration();
            $resource       = new FileResource($configFilePath);

            try {
                $processedConfiguration = $processor->processConfiguration(
                    $configuration,
                    $configValues
                );

                $cache->write(serialize($processedConfiguration), array($resource));
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }

        return $cache;
    }

}