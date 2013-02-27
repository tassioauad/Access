<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Access\Form;
use Access\Entity;

class AuthController extends AbstractActionController
{
    public function loginAction()
    {
        /** @var $headStyle \Zend\View\Helper\HeadLink */
        $headStyle = $this->getServiceLocator()->get('viewmanager')->getRenderer()->plugin('headLink');
        $headStyle->appendStylesheet('/css/validator_messages.css');

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
                } else {
                    $this->messenger()->addMessage(
                        "E-mail e/ou senha inválido(s).",
                        "error"
                    );
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

        $this->messenger()->addMessage(
            "Logout efetuado com sucesso!",
            "success",
            2
        );

        return array();
    }
}
