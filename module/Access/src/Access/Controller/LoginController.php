<?php

namespace Access\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \Zend\View\Helper\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $this->access()->login('auadtassio', md5('q1w2e3r4'));
        /*$result = $this->access()->isAllowed('LOGIN', 'ACESSAR');
        if (!$result) {
            print_r('denied');exit;
        }*/
        //$this->access()->logout();

    }
}
