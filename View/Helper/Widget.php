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
 * along with ZendSF.  If not, see <http ://www.gnu.org/licenses/>.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage View_Helper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of ZendSF_View_Helper_Widget
 * Constructs and outputs widgets
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage View_Helper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_View_Helper_Widget extends ZendSF_View_Helper_Widget_Abstract
{
    /**
     * Constructer can take two arguments, name of widget and widget group name.
     *
     * @param string $name Widget name
     * @param bool $group Group name
     * @return ZendSF_View_Helper_Widget
     */
    public function widget($name = null, $group = false)
    {
        $this->_DbTable = new ZendSF_Model_Mapper_Widget();

        if (is_string($name) && $group === false) {
            return $this->getWidgetByName($name);
        } elseif (is_string($name) && $group === true) {
            return $this->getWidgetsByGroup($name);
        } else {
            return $this;
        }
    }

    /**
     * Method to get a single widget from the database.
     *
     * @param string $name name of widget
     * @return ZendSF_View_Helper_Widget
     */
    public function getWidgetByName($name)
    {
        $widget = $this->_DbTable->getWidgetByName($name);

        if ($widget instanceof ZendSF_Model_Abstract) {
            $widgetClass = $this->_getInflected($widget->widget);
            $this->_widget = new $widgetClass($widget);
        } else {
            $this->_widget = '';
        }

        return $this;
    }

    /**
     * Method to get all widgets from a group in the database.
     *
     * @param string $group name of group
     * @return Zend_View_Helper_Widget
     */
    public function getWidgetsByGroup($group)
    {
        $this->_widget = array();
        $widgets = $this->_DbTable->getWidgetsByGroup($group, true);

        foreach ($widgets as $widget) {
           $widgetClass = $this->_getInflected($widget->widget);
           $this->_widget[] = new $widgetClass($widget);
        }

        return $this;
    }
}
