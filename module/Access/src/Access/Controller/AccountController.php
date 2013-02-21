<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \Zend\View\Helper\ViewModel;
use Access\Form;
use Access\Model;
use Access\Entity;

class AccountController extends AbstractActionController
{
    public function createAction()
    {
        $form = new Form\CreateAccount();
        $entityUser = new Entity\User();

        if($this->getRequest()->isPost()) {
            $form->bind($entityUser);
            $form->setData($_POST);
            if ($form->isValid()) {
                $entityUser->setIsActive(true);
                $entityUser->setPassword(md5($entityUser->getPassword()));
                $modelUser = $this->serviceLocator->get('Access\Model\User');
                $modelUser->insert($entityUser);
            }
        }

        return array(
            'form' => $form
        );
    }

    public function manageAction()
    {

    }
}
