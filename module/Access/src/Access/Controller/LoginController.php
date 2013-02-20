<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \Zend\View\Helper\ViewModel;
use Zend\Session\Container as Session;
use Access\Form;
use Access\Entity;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $form = new Form\Login;

        if($this->getRequest()->isPost()) {
            $form->setData($_POST);
            if ($form->isValid()) {
                $this->access()->login($_POST['login_fieldset']['username'], md5($_POST['login_fieldset']['password']));
            }
        }

        return array(
            'form' => $form
        );

    }

    public function logoutAction()
    {
        $this->access()->logout();

        return array();
    }
}
