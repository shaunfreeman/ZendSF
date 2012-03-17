<?php
/**
 * Mobile.php
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
 * @subpackage Controller_Plugin
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Changes the layout for mobile devices.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Controller_Plugin
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Controller_Plugin_Mobile extends Zend_Controller_Plugin_Abstract
{
    /**
     * Changes the layout to the mobile layout
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $frontController = Zend_Controller_Front::getInstance();
        $bootstrap = $frontController->getParam('bootstrap');

        if (!$bootstrap->hasResource('useragent')) {
            throw new Zend_Controller_Exception('The mobile plugin can only be loaded when the UserAgent is bootstrapped');
        }


        $userAgent = $bootstrap->getResource('useragent');
        $device = $userAgent->getDevice();

        if ($device->getBrowserType() == 'mobile') {
            if ($frontController->getParam('mobileLayout') === 1) {
                $suffix = $bootstrap->getResource('layout')->getViewSuffix();
                $bootstrap->getResource('layout')->setViewSuffix('mobile.', $suffix);
                Zend_Layout::getMvcInstance()->setLayout('mobile');
            }

            if ($frontController->getParam('mobileViews') == "1") {
                Zend_Controller_Action_HelperBroker::getStaticHelper('MobileContext')->enable();
            }
        }

    }
}
