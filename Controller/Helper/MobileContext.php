<?php
/**
 * MobileContext.php
 *
 * Copyright (c) 2012 Shaun Freeman <shaun@shaunfreeman.co.uk>.
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
 * @subpackage Controller
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Controller Class MobileContext.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Controller
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

class ZendSF_Controller_Helper_MobileContext extends Zend_Controller_Action_Helper_ContextSwitch
{
    /**
     * Flag to enable layout based on WURFL detection
     * @var bool
     */
    protected $_enabled = false;

    /**
     * Controller property to utilize for context switching
     * @var string
     */
    protected $_contextKey = 'mobileable';

    /**
     * Whether or not to disable layouts when switching contexts
     * @var boolean
     */
    protected $_disableLayout = false;

    /**
     * Constructor
     *
     * Add HTML context
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->addContext('html', array('suffix' => 'mobile'));
    }

    /**
     * Enable the mobile contexts
     *
     * @return void
     */
    public function enable ()
    {
        $this->_enabled = true;
    }

     /**
     * Add one or more contexts to an action
     *
     * The context is by default set to 'html' so no additional context is required for mobile
     *
     * @param  string       $action
     * @return Zend_Controller_Action_Helper_ContextSwitch|void Provides a fluent interface
     */
    public function addActionContext($action, $context = 'html')
    {
        return parent::addActionContext($action, $context);
    }

    /**
     * Initialize AJAX context switching
     *
     * Checks for XHR requests; if detected, attempts to perform context switch.
     *
     * @param  string $format
     * @return void
     */
    public function initContext($format = 'html')
    {
        $this->_currentContext = null;

        if (false === $this->_enabled) {
            return;
        }

        return parent::initContext($format);
    }
}

