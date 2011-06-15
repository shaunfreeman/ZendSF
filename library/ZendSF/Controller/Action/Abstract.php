<?php
/**
 * Abstract.php
 *
 * Copyright (c) 2011 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 * This file is part of ZendSF.
 *
 * ZendSF is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Uthando-CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ZendSF.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Controller_Action
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Base Controller action class
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Controller_Action
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_Controller_Action_Abstract extends Zend_Controller_Action
{
    protected $_authService;
    protected $_model;
    protected $_forms;
    protected $_log;

    /**
     * @var object Zend_Controller_Action_Helper_FlashMessenger
     */
    protected $_flashMessenger;

    /**
     * Constructor extensions
     */
    public function init()
    {
        $this->_log = Zend_Registry::get('log');

        $this->view->admin = $this->_request->getParam('isAdmin');
        $this->view->request = $this->_request->getParams();

        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->view->messages = $this->_flashMessenger->getMessages();
    }

    /**
     * Sets a Form
     *
     * @param string $name
     * @param array  $action
     * @param string $route
     * @param string $method
     */
    protected function setForm($name, $action, $route = 'default', $method = 'post')
    {
        $urlHelper = $this->_helper->getHelper('url');

        $this->view->$formName = new $class($this->_modelClass);

        $this->view->$formName->setAction($urlHelper->url($action, $route));
        $this->view->$formName->setMethod($method);
    }
}
?>
