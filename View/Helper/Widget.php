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
 * Constructs and outputs widgets
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage View_Helper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_View_Helper_Widget extends Zend_View_Helper_Abstract
{
    /**
     * @var mixed
     */
    protected $_widget = null;

    /**
     * @var ZendSF_Model_Widget
     */
    protected $_model;

    /**
     * Constructor can take two arguments, name of widget/widget group name and
     * whether this is a group or nor defaults to false.
     *
     * @param string $name Widget|Widget group name
     * @param bool $group true|false
     * @return ZendSF_View_Helper_Widget
     */
    public function widget($name = null, $group = false)
    {
        $this->_model = new ZendSF_Model_Widget();

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
        $widget = $this->_model->getWidgetByName($name);

        if ($widget instanceof ZendSF_Model_DbTable_Row_Widget) {
            $widgetClass = $widget->widget;
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
        $widgets = $this->_model->getWidgetsByGroup($group, true);

        foreach ($widgets as $widget) {
           $widgetClass = $widget->widget;
           $this->_widget[] = new $widgetClass($widget);
        }

        return $this;
    }

    /**
     * Magic method to output widget to a string.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->render();
        } catch (Exception $e) {
            $msg = get_class($e) . ': ' . $e->getMessage();
            trigger_error($msg, E_USER_ERROR);
            return '';
        }
    }

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function render()
    {
        if ($this->_widget instanceof ZendSF_Widget_Abstract) {
            return $this->_widget->render();
        } elseif (is_array($this->_widget)) {
            $widgetGroup = '';

            foreach ($this->_widget as $widget) {
                $widgetGroup .= $widget->render();
            }

            return $widgetGroup;
        } else {
            return '';
        }
    }
}
