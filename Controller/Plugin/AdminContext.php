<?php
/**
 * AdminContext.php
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
 * Changes the layout for the admin features.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Controller_Plugin
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Controller_Plugin_AdminContext extends Zend_Controller_Plugin_Abstract
{
    /**
     * Changes the layout to the admin layout
     *
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        if ($request->getParam('isAdmin')) {

            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout('admin/layout');

            if (file_exists(APPLICATION_PATH . '/configs/adminMenu.xml')) {
                $menu = new Zend_Config_Xml(
                    APPLICATION_PATH . '/configs/adminMenu.xml',
                    'nav'
                );

                $module = $request->getModuleName();
                $aclModel = ucfirst($module) . '_Model_Acl_' . ucfirst($module);

                $auth = Zend_Auth::getInstance();
                $acl = new $aclModel();
                $role = ($auth->hasIdentity()) ? $auth->getIdentity()->role : 'guest';

                $view = Zend_Controller_Front::getInstance()
                    ->getParam('bootstrap')
                    ->getResource('view');

                $view->navigation(new Zend_Navigation($menu))
                    ->setAcl($acl)
                    ->setRole($role);
            }
        }
    }
}
