<?php
/**
 * SSL.php
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
 * @package
 * @subpackage
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of SSL
 *
 * @category   ZendSF
 * @package
 * @subpackage
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Controller_Plugin_SSL extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // Force SSL Only use it production environment
        if ( APPLICATION_ENV == 'production' ) {
            //get the config settings for SSL
            $options = Zend_Registry::get('config');

            $secure_modules = explode(',',$options->ssl->modules->require_ssl);
            $secure_controllers = explode(',',$options->ssl->controllers->require_ssl);

            $front = Zend_Controller_Front::getInstance();
            $request = $front->getRequest();
            $module = $request->getModuleName();
            $controller = $request->getControllerName();
            
            if ($secure_modules[0] == 'all' || in_array(strtolower($module), $secure_modules)
                    || in_array(strtolower($controller), $secure_controllers)) {
                if (!isset($_SERVER['HTTPS']) && !$_SERVER['HTTPS']) {
                    $url = 'https://' . $_SERVER['HTTP_HOST'] . $request->getRequestUri();

                    $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
                    $redirector->gotoUrl($url);
                }
            }
        }
    }
}
