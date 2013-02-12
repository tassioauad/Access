<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Access;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
                    'Access\Service\AclService' => function ($sm) {
                        return new Service\AclService($sm);
                    },
                    /* Models */
                    'Access\Model\User' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        $model = new Model\User($entityManager);
                        return $model;
                    },
                    'Access\Model\UserRole' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        $model = new Model\UserRole($entityManager);
                        return $model;
                    },
                    'Access\Model\Role' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        $model = new Model\Role($entityManager);
                        return $model;
                    },
                    'Access\Model\Resource' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        $model = new Model\Resource($entityManager);
                        return $model;
                    },
                    'Access\Model\Privillege' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        $model = new Model\Privillege($entityManager);
                        return $model;
                    },
                    'Access\Model\Allow' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        $model = new Model\Allow($entityManager);
                        return $model;
                    },
                    'Access\Auth\Auth' => function ($sm) {
                        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                        $auth = new Auth\Authentication($entityManager);
                        return $auth;
                    },
    			),
    	);
    }
}
