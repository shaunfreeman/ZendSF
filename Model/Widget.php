<?php
/**
 * Widget.php
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
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Widget Model.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Model_Widget extends ZendSF_Model_Acl_Abstract
{
    public function getWidgetById($id)
    {
        $id = (int) $id;
        return $this->getDbTable('widget')->getWidgetById($id);
    }

    public function getWidgetGroupById($id)
    {
        $id = (int) $id;
        return $this->getDbTable('widgetGroup')->getWidgetGroupById($id);
    }

    public function getWidgetByName($name)
    {
        $name = (string) $name;
        return $this->getDbTable('widget')->getWidgetByName($name);
    }

    public function getWidgetsByGroup($name)
    {
        $name = (string) $name;
        $group = $this->getDbTable('widgetGroup')->getWidgetGroupByName($name);
        return $group->getWidgets();
    }

    public function setAcl(Zend_Acl $acl)
    {
        parent::setAcl($acl);

        $this->_acl->allow('admin', $this);

        return $this;
    }
}