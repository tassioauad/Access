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
                $entityUser->setActive(true);
                $entityUser->setPassword(md5($entityUser->getPassword()));
                $modelUser = $this->serviceLocator->get('Access\Model\User');

                $userWithSameEmail = $modelUser->findByEmail($entityUser->getEmail());
                if (empty($userWithSameEmail)) {
                    $modelUser->insert($entityUser);

                    $modelUserRole = $this->serviceLocator->get('Access\Model\UserRole');
                    $entityUserRole = new Entity\UserRole();
                    $entityUserRole->setRole($this->getRoleForCommonUsers());
                    $entityUserRole->setUser($entityUser);
                    $modelUserRole->insert($entityUserRole);

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

    public function manageAction()
    {

    }

    public function getRoleForCommonUsers()
    {
        return $this->serviceLocator->get('Access\Model\Role')->find('3');
    }

}
