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
use Zend\Permissions\Acl\Role\GenericRole;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        date_default_timezone_set('America/Sao_Paulo');

        /**
         * @var $aclService Acl\Service\Service
         */
        $aclService = $e->getApplication()->getServiceManager()->get('Access\Acl\Service');
        $acl = $aclService->getAcl();
        \Zend\View\Helper\Navigation::setDefaultAcl($acl);
        $role = new GenericRole($acl->getUserId());
        \Zend\View\Helper\Navigation::setDefaultRole($role);

        $guard = $e->getApplication()->getServiceManager()->get('Access\Acl\Guard');
        $guard->dispatch($e);

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
                    'Access\Acl\Service' => function ($sm) {
                        return new Acl\Service\Service($sm);
                    },
                    'Access\Acl\Guard' => function ($sm) {
                        $aclService = $sm->get('Access\Acl\Service');
                        return new Acl\Guard\Guard($aclService);
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

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'access' => function ($sm) {
                    $viewHelper = new ViewHelper\AccessViewHelper($sm);
                    return $viewHelper;
                },
            ),
        );

    }
}
