<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Access\Form;
use Access\Entity;

class AuthController extends AbstractActionController
{
    public function loginAction()
    {
        $form = new Form\Login();

        if($this->getRequest()->isPost()) {
            $form->setData($_POST);
            if ($form->isValid()) {
                $isLogged = $this->access()->login(
                    $_POST['login_fieldset']['email'],
                    md5($_POST['login_fieldset']['password'])
                );

                if($isLogged) {
                    $this->redirect()->toRoute('access-index');
                }

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
