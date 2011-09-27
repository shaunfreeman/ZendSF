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
 * ZendSF is distributed in the hope that it will be useful,
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
    /**
     * @var ZendSF_Model_Mapper_Abstract
     */
    protected $_model;

    /**
     * @var Zend_Log
     */
    protected $_log;

    /**
     * Sets the default date format for Zend_Date
     *
     * @var string
     */
    protected $_dateFormat = null;

    /**
     * Constructor extensions.
     * Put the navigation acl code in the bootstrap file.
     */
    public function init()
    {
        $this->_log = Zend_Registry::get('log');

        $this->view->admin = $this->_request->getParam('isAdmin');

        $this->view->request = $this->_request->getParams();

    }

    public function getForm($formName)
    {
        $formName = $formName . 'Form';

        if (isset($this->view->$formName)) {
            return $this->view->$formName;
        }

        throw new ZendSF_Exception('Form ' . $formName . ' is not set.');
    }

    /**
     * Sets a form to use via view
     *
     * @param string $formName
     * @param array $action
     * @param string $route
     * @param string $method
     * @return ZendSF_Controller_Action_Abstract
     */
    public function setForm($formName, $action, $reset = false, $route = 'default', $method = 'post')
    {
        $urlHelper = $this->_helper->getHelper('url');

        $formViewName = $formName . 'Form';

        $this->view->$formViewName = $this->_model->getForm($formName);

        $this->view->$formViewName->setAction($urlHelper->url($action, $route, $reset));

        $this->view->$formViewName->setMethod($method);

        return $this;
    }

    public function __call($methodName, $args)
    {
       $this->_log->info(__METHOD__);
       throw new ZendSF_Exception_404('Page not found');
    }

    /**
     * returns an array of database objects in Json format to use with Dojo.
     *
     * @param array $dataObj
     * @param string $id
     * @return Zend_Dojo_Data
     */
    public function getDataStore($dataObj, $id)
    {
        $items = array();

        foreach ($dataObj as $row) {
            $items[] = $row->toArray($this->_dateFormat);
        }

        return new Zend_Dojo_Data($id, $items);;
    }
}
