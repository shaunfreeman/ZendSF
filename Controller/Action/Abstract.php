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
 * Description of Uthando_Controller_Action_Abstract
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
     *
     * @var object Zend_Controller_Action_Helper_FlashMessenger
     */
    protected $_flashMessenger;

    /**
     * Constructor extensions
     *
     * @access public
     * @return none
     */
    public function init()
    {
        $this->view->admin = $this->_request->getParam('isAdmin');

        //$container = Zend_Registry::get('template')->getNavigation('main_menu');
        //$this->view->navigation($container);

        $this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
        $this->view->messages = $this->_flashMessenger->getMessages();

        $this->_log = Zend_Registry::get('log');
    }

    /**
     * Set a Form
     *
     * @param string $name
     * @param array $action
     * @param string $route
     * @param string $method
     * @return none
     */
    protected function setForm($name, $action, $route = 'default', $method = 'post')
    {
        $formName = $name . 'Form';
        $class = join('_', array(
                $this->_getNamespace(),
                'Form',
                $this->_getInflected($name)
        ));

        $urlHelper = $this->_helper->getHelper('url');

        $this->view->$formName = new $class($this->_model);

        $this->view->$formName->setAction($urlHelper->url($action, $route));
        $this->view->$formName->setMethod($method);
    }

    /**
     * Get a Form
     *
     * @param string $name
     * @return Zend_Form
     */
    protected function getForm($name)
    {
        $formName = $name . 'Form';

        if (!isset($this->view->$formName)) {
            return null;
        }

        return $this->view->$formName;
    }

    /**
     * Classes are named spaced using their module name
     * this returns that module name or the first class name segment.
     *
     * @return string This class namespace
     */
    private function _getNamespace()
    {
        $ns = explode('_', get_class($this->_model));
        return $ns[0];
    }

    /**
     * Inflect the name using the inflector filter
     *
     * Changes camelCaseWord to Camel_Case_Word
     *
     * @param string $name The name to inflect
     * @return string The inflected string
     */
    private function _getInflected($name)
    {
        $inflector = new Zend_Filter_Inflector(':class');
        $inflector->setRules(array(
            ':class'  => array('Word_CamelCaseToUnderscore')
        ));
        return ucfirst($inflector->filter(array('class' => $name)));
    }
}
?>
