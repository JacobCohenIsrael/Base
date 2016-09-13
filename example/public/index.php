<?php
use JCI\Base\Config\ArrayConfig;
use JCI\Base\ServiceManager\ServiceManager;
use JCI\Base\Event\EventDispatcher;
use JCI\Base\Http\ControllerResolver;
use JCI\Base\Http\Listener\RoutingListener;
use JCI\Base\Http\HttpApplication;
use JCI\Base\Http\Request;
use JCI\Base\Http\Listener\ActionListener;

date_default_timezone_set('UTC');
define('JCI_PROJECT_PATH' ,   realpath(__DIR__ . '/../'));
define('JCI_VIEWS_PATH'   ,    realpath(JCI_PROJECT_PATH . '/app/Example/views'));
require JCI_PROJECT_PATH . '/vendor/autoload.php';

$configuration      = new ArrayConfig(include JCI_PROJECT_PATH . '/app/Example/config/config.php');
if (file_exists(JCI_PROJECT_PATH . '/app/Example/config/dev.php')) {
    $configuration->merge(new ArrayConfig(include JCI_PROJECT_PATH . '/app/Example/config/dev.php'));
} 
$serviceManager     = new ServiceManager($configuration->get('servicemanager'));
$eventDispatcer     = new EventDispatcher();
$controllerResolver = new ControllerResolver();

$serviceManager->setAppConfiguration($configuration);
$serviceManager->set('EventDispatcher',     $eventDispatcer);
$serviceManager->set('ControllerResolver',  $controllerResolver);

$eventDispatcer->addSubscribers([
    new RoutingListener($configuration->get('routes')),
    new ActionListener(),
]);

$application = new HttpApplication($serviceManager);
echo $application->run(Request::create());
