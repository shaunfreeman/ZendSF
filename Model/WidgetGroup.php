<?php
/**
 * Group.php
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
 * along with ZendSF.  If not, see <http ://www.gnu.org/licenses/>.
 *
 * @category ZendSF
 * @package ZendSF
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of ZendSF_Model_WidgetGroup
 *
 * @category ZendSF
 * @package ZendSF
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Model_WidgetGroup extends ZendSF_Model_Abstract
{
    /**
     * @var int
     */
    protected $_widgetGroupId;

    /**
     * @var string
     */
    protected $_widgetGroup;

    /**
     * @var string
     */
    protected $_primary = 'widgetGroupId';

    /**
     * Overrides parent method
     *
     * @return int
     */
    public function getId()
    {
        return $this->_widgetGroupId;
    }

    /**
     * Gets the widget group id
     *
     * @return int
     */
    public function getWidgetGroupId()
    {
        return $_widgetGroupId;
    }

    /**
     * Sets the widget group id
     *
     * @param int $id
     * @return ZendSF_Model_Widget_Group
     */
    public function setWidgetGroupId($id)
    {
        $this->_widgetGroupId = (int) $id;
        return $this;
    }

    /**
     * Gets the widget group name
     *
     * @return string
     */
    public function getWidgetGroup()
    {
        return $this->_widgetGroup;
    }

    /**
     * Sets the widget group name
     *
     * @param string $group
     * @return ZendSF_Model_Widget_Group
     */
    public function setWidgetGroup($group)
    {
        $this->_widgetGroup = (string) $group;
        return $this;
    }
}
