<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Access\Utils\Utils;
use Access\Form;
use Access\Model;
use Access\Entity;
use Access\DataTable\DataTable;
use Access\DataTable\Filter\HtmlInputFilter\AbstractFilter;
use Access\DataTable\Filter\HtmlInputFilter\TextFilter;
use Access\DataTable\Element\HtmlElement\AImgElement;
use Access\DataTable\Element\DbElement\Element;
use Zend\View\Model\JsonModel;

class AdminUserController extends AbstractActionController
{

    /**
     * @var DataTable
     */
    private $dataTable;

    public function listAction()
    {
        $this->configDataTable();
        $javascript = $this->dataTable->renderJqueryDataTable('adminuser', 'datatable', 'datatable', 'btnFilter',
            'btnClear');
        /** @var $headScript \Zend\View\Helper\HeadScript */
        $headScript = $this->getServiceLocator()->get('viewmanager')->getRenderer()->plugin('headScript');
        $headScript->appendScript($javascript);

        return array();
    }

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
                $modelUser = $this->serviceLocator->get('Access\Model\User');

                $userWithSameEmail = $modelUser->findByEmail($entityUser->getEmail());
                if (empty($userWithSameEmail)) {
                    $modelUser->save($entityUser);

                    $modelUserRole = $this->serviceLocator->get('Access\Model\UserRole');
                    $entityUserRole = new Entity\UserRole();
                    $entityUserRole->setRole($this->getRoleForCommonUsers());
                    $entityUserRole->setUser($entityUser);
                    $modelUserRole->save($entityUserRole);

                    $this->messenger()->addMessage(
                        "Conta criada com sucesso!",
                        "success"
                    );
                    $form = new Form\CreateAccount();

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

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute(
                'application/default',
                array(
                    'controller' => 'admin',
                    'action' => 'index',
                )
            );
        }

        $modelUser = $this->getServiceLocator()->get('Access\Model\User');
        $user = $modelUser->find($id);
        $form = new Form\CreateAccount();
        $form->bind($user);

        if($this->getRequest()->isPost()) {
            $form->setData($_POST);
            if($form->isValid()) {
                try {
                    $modelUser->save($user);
                    $this->messenger()->addMessage(
                        "Conta alterada com sucesso!",
                        "success"
                    );
                } catch(\Exception $ex) {
                    $this->messenger()->addMessage(
                        $ex->getMessage(),
                        "error"
                    );
                }

            }
        }

        return array('form' => $form);
    }

    public function blockAction()
    {
        return array();
    }

    public function getRoleForCommonUsers()
    {
        return $this->serviceLocator->get('Access\Model\Role')->find('3');
    }

    public function datatableAction()
    {
        $this->configDataTable();
        $this->dataTable->updateParams($this->getRequest()->getPost());

        $modeluser = $this->getServiceLocator()->get('Access\Model\User');
        return new JsonModel($this->dataTable->getOutput($modeluser));
    }

    public function configDataTable()
    {
        if (empty($this->dataTable)) {
            $this->dataTable = new DataTable();
            $this->dataTable->createNColumns(5);

            //------------------Buttons and CheckBox--------------------

            if ($this->access()->isAllowed("ADMINUSER", "EDIT")) {
                $this->dataTable->insertElement(
                    4,
                    new AImgElement(
                        "href = '/adminuser/edit/:id' class = 'btnEdit' title='Edit'",
                        array(':id' => 'id'),
                        "src = '/images/icons/icon-edit.png' alt = 'Edit'"
                    )
                );
            }

            if ($this->access()->isAllowed("ADMINUSER", "BLOCK")) {
                $this->dataTable->insertElement(
                    4,
                    new AImgElement(
                        "href = '/adminuser/block/:id' class = 'btnBlock' title='Block'",
                        array(':id' => 'id'),
                        "src = '/images/icons/icon-lock.png' alt = 'Block'",
                        array(),
                        array(
                            'dbColumn' => 'active',
                            'value' => true
                        )
                    )
                );
            }

            if ($this->access()->isAllowed("ADMINUSER", "UNBLOCK")) {
                $this->dataTable->insertElement(
                    4,
                    new AImgElement(
                        "href = '/adminuser/unblock/:id' class = 'btnUnblock' title='Unblock'",
                        array(':id' => 'id'),
                        "src = '/images/icons/icon-unlock.png' alt = 'Unblock'",
                        array(),
                        array(
                            'dbColumn' => 'active',
                            'value' => false
                        )
                    )
                );
            }

            //------------------Columns--------------------

            $this->dataTable->insertElement(0, new Element('account', 'fullname'));
            $this->dataTable->insertElement(1, new Element('account', 'email'));
            $this->dataTable->insertElement(
                2,
                new Element(
                    'account',
                    'created_at',
                    '',
                    function ($result) {
                        $result = Utils::dateToBr($result);
                        return $result;
                    }
                )
            );
            $this->dataTable->insertElement(3, $activeColumn = new Element('account', 'active'));
                $activeColumn->setConvertBooleanValue();

            $this->dataTable->columnEnableSorting(array(0,1,2,3));

            //------------------Filters--------------------

            $this->dataTable->setFilter(
                new TextFilter(
                    'user_fullname',
                    'fullname',
                    'account',
                    'fullname',
                    AbstractFilter::STRING
                )
            );
        }
    }
}
