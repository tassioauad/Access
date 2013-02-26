<?php

namespace Messenger;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\ModuleRouteListener;

class Module
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'messenger' => function ($sm) {
                    $viewHelper = new Helper\MessengerHelper();
                    return $viewHelper;
                },
            ),
        );

    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}