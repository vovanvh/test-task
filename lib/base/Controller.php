<?php

namespace base;

use helpers\Request;

/**
 * Class Controller
 * @package base
 */
class Controller
{
    use Request;

    /**
     * Root app path
     * @var string
     */
    public $rootPath;

    /**
     * Current controller id
     * @var string
     */
    public $id;

    /**
     * Rendered view content
     * @var string
     */
    protected $_viewContent;

    /**
     * @var string
     */
    protected $_flashMessage = '';

    /**
     * Get layout absolute path
     * @return string
     */
    protected function _getLayout()
    {
        return $this->rootPath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'layout.php';
    }

    /**
     * Get view absolute path
     * @param string $view View name
     * @return string
     */
    protected function _getView($view)
    {
        return $this->rootPath . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $this->id
            . DIRECTORY_SEPARATOR . $view . '.php';
    }

    /**
     * Render view method
     * @param string $view View name
     * @param array $params View params
     */
    protected function _render($view, $params)
    {
        extract($params);
        ob_start();
        include $this->_getView($view);
        $this->_viewContent = ob_get_clean();
        $this->_renderLayout();
    }

    /**
     * Render layout method
     */
    protected function _renderLayout()
    {
        include $this->_getLayout();
    }

    protected function getIsAdmin()
    {
        return isset($_SESSION['admin']) && $_SESSION['admin'];
    }

    protected function setFlash($message)
    {
        $_SESSION['message'] = $this->_flashMessage = $message;
    }

    protected function getFlash()
    {
        $message = '';
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
        }
        return $message;
    }
}
