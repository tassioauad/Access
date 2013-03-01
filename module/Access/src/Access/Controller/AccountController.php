<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Helper\ViewModel;
use Access\Form;
use Access\Model;
use Access\Entity;

class AccountController extends AbstractActionController
{
    public function createAction()
    {
        /** @var $headStyle \Zend\View\Helper\HeadLink */
        $headStyle = $this->getServiceLocator()->get('viewmanager')->getRenderer()->plugin('headLink');
        $headStyle->appendStylesheet('/css/validator_messages.css');

        $form = new Form\CreateAccount();
        $entityUser = new Entity\User();

        if($this->getRequest()->isPost()) {
            $form->bind($entityUser);
            $form->setData($_POST);
            if ($form->isValid()) {
                $entityUser->setPassword(md5($entityUser->getPassword())); //TODO : AQUI
                $entityUser->setActive(true);
                $modelUser = $this->serviceLocator->get('Access\Model\User');

                $userWithSameEmail = $modelUser->findByEmail($entityUser->getEmail());
                if (empty($userWithSameEmail)) {
                    $modelUser->insert($entityUser);

                    $modelUserRole = $this->serviceLocator->get('Access\Model\UserRole');
                    $entityUserRole = new Entity\UserRole();
                    $entityUserRole->setRole($this->getRoleForCommonUsers());
                    $entityUserRole->setUser($entityUser);
                    $modelUserRole->save($entityUserRole);

                    $this->messenger()->addMessage(
                        "Conta criada com sucesso!",
                        "success",
                        2
                    );

                    $this->redirect()->toRoute('access-login');
                } else {
                    $this->messenger()->addMessage(
                        "E-mail já utilizado por outro usuário",
                        "error"
                    );
                }
            }
        }

        return array(
            'form' => $form
        );
    }

    public function perfilAction()
    {
        return array(
            'user' => $this->access()->getUser()
        );
    }

    public function editAction()
    {
        /** @var $headStyle \Zend\View\Helper\HeadLink */
        $headStyle = $this->getServiceLocator()->get('viewmanager')->getRenderer()->plugin('headLink');
        $headStyle->appendStylesheet('/css/validator_messages.css');

        $userLogged = $this->access()->getUser();

        $form = new Form\EditAccount();
        $form->bind($userLogged);
        if ($this->getRequest()->isPost()) {
            $form->setData($_POST);
            if ($form->isValid()) {
                $modelUser = $this->serviceLocator->get('Access\Model\User');
                $modelUser->save($userLogged);

                $this->messenger()->addMessage(
                    "Conta alterada com sucesso!",
                    "success",
                    2
                );

                $this->redirect()->toRoute('access-account-perfil');
            }
        }

        return array(
            'form' => $form
        );
    }

    public function editpasswordAction()
    {
        /** @var $headStyle \Zend\View\Helper\HeadLink */
        $headStyle = $this->getServiceLocator()->get('viewmanager')->getRenderer()->plugin('headLink');
        $headStyle->appendStylesheet('/css/validator_messages.css');

        $userLogged = $this->access()->getUser();

        $form = new Form\EditAccountPassword();
        $form->bind(new Entity\User());
        if ($this->getRequest()->isPost()) {
            $form->setData($_POST);
            if ($form->isValid()) {

                if ($userLogged->getPassword() != md5($_POST['editaccountpassword_fieldset']['oldpassword'])) { //TODO : AQUI
                    $this->messenger()->addMessage(
                        "Senha antiga não confere.",
                        "error"
                    );
                } else {
                    $userLogged->setPassword(md5($_POST['editaccountpassword_fieldset']['password'])); //TODO : AQUI
                    $modelUser = $this->serviceLocator->get('Access\Model\User');
                    $modelUser->save($userLogged);

                    $this->messenger()->addMessage(
                        "Senha alterada com sucesso!",
                        "success",
                        2
                    );

                    $this->redirect()->toRoute('access-account-perfil');
                }
            }
        }

        return array(
            'form' => $form
        );
    }

    public function getRoleForCommonUsers()
    {
        return $this->serviceLocator->get('Access\Model\Role')->find('3');
    }

}
