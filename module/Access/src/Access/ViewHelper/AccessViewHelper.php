<?php

namespace Access\ViewHelper;

use Zend\View\Helper\HelperInterface;
use Zend\View\Renderer\RendererInterface as Renderer;
use Access\Acl\Service\Service;
class AccessViewHelper extends Service  implements HelperInterface
{

    /**
     * __invoke
     *
     * @access public
     * @return HelperInterface
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * View object
     *
     * @var Renderer
     */
    protected $view = null;

    /**
     * Set the View object
     *
     * @param  Renderer $view
     * @return AccessViewHelper
     */
    public function setView(Renderer $view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * Get the view object
     *
     * @return null|Renderer
     */
    public function getView()
    {
        return $this->view;
    }

    public function getUser()
    {
        $userId = $this->getAcl()->getUserId();
        $userModel = $this->serviceManager->getServiceLocator()->get('Access\Model\User');
        return $userModel->find($userId);
    }
}
