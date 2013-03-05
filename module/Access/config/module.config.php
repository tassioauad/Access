<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Access;

return array(
    'router' => array(
        'routes' => array(
            'access-index' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'access-login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/auth/login',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Auth',
                        'action'     => 'login',
                    ),
                ),
            ),
            'access-logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/auth/logout',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Auth',
                        'action'     => 'logout',
                    ),
                ),
            ),
            'access-denied' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/denied',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Denied',
                        'action'     => 'index',
                    ),
                ),
            ),
            'access-create_account' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/account/create',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Account',
                        'action'     => 'create',
                    ),
                ),
            ),
            'access-account-perfil' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/account/perfil',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Account',
                        'action'     => 'perfil',
                    ),
                ),
            ),
            'access-account-edit' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/account/edit',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Account',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'access-accountpassword-edit' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/account/editpassword',
                    'defaults' => array(
                        'controller' => 'Access\Controller\Account',
                        'action'     => 'editpassword',
                    ),
                ),
            ),
        ),
    ),

    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'access' => 'Access\Controller\Plugin\AccessPlugin',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Access\Controller\Auth' => 'Access\Controller\AuthController',
            'Access\Controller\Denied' => 'Access\Controller\DeniedController',
            'Access\Controller\Index' => 'Access\Controller\IndexController',
            'Access\Controller\Account' => 'Access\Controller\AccountController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'access/index/index' => __DIR__ . '/../view/access/index/index.phtml',
            'access/breadcrumbs' => __DIR__ . '/../view/layout/breadcrumbs.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),

    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),

    'navigation' => array(
        'default' => array(
            array(
                'label'      => 'Home',
                'route'      => 'access-index',
                'controller' => 'index',
                'action'     => 'index',
                'visible'    => true,
            ),
            array(
                'label'      => 'Sign In',
                'route'      => 'access-login',
                'controller' => 'auth',
                'action'     => 'login',
                'resource'   => 'AUTH',
                'privilege'  => 'LOGIN',
                'visible'    => true,
            ),
            array(
                'label'      => 'Create Account',
                'route'      => 'access-create_account',
                'controller' => 'account',
                'action'     => 'create',
                'resource'   => 'ACCOUNT',
                'privilege'  => 'CREATE',
                'visible'    => true,
            ),
            array(
                'label'      => 'My Account',
                'route'      => 'access-account-perfil',
                'controller' => 'account',
                'action'     => 'perfil',
                'resource'   => 'ACCOUNT',
                'privilege'  => 'PERFIL',
                'visible'    => true,
                'pages' => array(
                    array(
                        'label'      => 'Edit My Account',
                        'route'      => 'access-account-edit',
                        'controller' => 'account',
                        'action'     => 'edit',
                        'resource'   => 'ACCOUNT',
                        'privilege'  => 'EDIT',
                        'visible'    => false,
                    ),
                    array(
                        'label'      => 'Change Password',
                        'route'      => 'access-accountpassword-edit',
                        'controller' => 'account',
                        'action'     => 'editpassword',
                        'resource'   => 'ACCOUNT',
                        'privilege'  => 'EDITPASSWORD',
                        'visible'    => false,
                    ),
                )
            ),
            array(
                'label'      => 'Log out',
                'route'      => 'access-logout',
                'controller' => 'auth',
                'action'     => 'logout',
                'resource'   => 'AUTH',
                'privilege'  => 'LOGOUT',
                'visible'    => true,
            ),
        ),
    ),
);
