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
 * @category ZendSF
 * @package ZendSF
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of ZendSF_Model_Widget
 *
 * @category ZendSF
 * @package ZendSF
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Model_Widget extends ZendSF_Model_Abstract
{
    /**
     * @var int
     */
    protected $_widgetId;
    
    /**
     * @var int
     */
    protected $_widgetGroupId;
    
    /**
     * @var string 
     */
    protected $_name;
    
    /**
     * @var string 
     */
    protected $_widget;
    
    /**
     * @var int 
     */
    protected $_sortOrder;
    
    /**
     * @var bool
     */
    protected $_showTitle;
    
    /**
     * @var array
     */
    protected $_params;
    
    /**
     * @var string 
     */
    protected $_html;
    
    /**
     * @var bool
     */
    protected $_enabled;
    
    /**
     * @var string
     */
    protected $_primary = 'widgetId';

    /**
     * Overrides parent method.
     * 
     * @return string
     */
    public function getId()
    {
        return $this->_widgetId;
    }

    /**
     * Gets widget id
     * 
     * @return string
     */
    public function getWidgetId()
    {
        return $this->_widgetId;
    }

    /**
     * Sets widget id
     * 
     * @param int $id
     * @return ZendSF_Model_Widget 
     */
    public function setWidgetId($id)
    {
        $this->_widgetId = (int) $id;
        return $this;
    }

    /**
     * Gets widget group id
     * 
     * @return int 
     */
    public function getWidgetGroupId()
    {
        return $this->_widgetGroupId;
    }

    /**
     * Sets widget group id
     * 
     * @param int $id
     * @return ZendSF_Model_Widget 
     */
    public function setWidgetGroupId($id)
    {
        $this->_widgetGroupId = (int) $id;
        return $this;
    }

    /**
     * Gets widget name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets widget name
     * 
     * @param string $name
     * @return ZendSF_Model_Widget 
     */
    public function setName($name)
    {
        $this->_name = (string) $name;
        return $this;
    }

    /**
     * Gets widget class name
     * 
     * @return string 
     */
    public function getWidget()
    {
        return $this->_widget;
    }

    /**
     * Set widget class name
     * 
     * @param string $widget
     * @return ZendSF_Model_Widget 
     */
    public function setWidget($widget)
    {
        $this->_widget = (string) $widget;
        return $this;
    }

    /**
     * Gets the sort order of widget, used in groups
     * 
     * @return int
     */
    public function getSortOrder()
    {
        return $this->_sortOrder;
    }

    /**
     * Sets the sort order of widget, used in groups
     * 
     * @param int $sortOrder
     * @return ZendSF_Model_Widget 
     */
    public function setSortOrder($sortOrder)
    {
        $this->_sortOrder = (int) $sortOrder;
        return $this;
    }

    /**
     * Gets the show title flag
     * 
     * @return bool 
     */
    public function getShowTitle()
    {
        return $this->_showTitle;
    }

    /**
     * Sets the show title flag
     * 
     * @param bool $showTitle
     * @return ZendSF_Model_Widget 
     */
    public function setShowTitle($showTitle)
    {
        $this->_showTitle = (bool) $showTitle;
        return $this;
    }

    /**
     * Gets the widget params
     * 
     * @return array
     */
    public function getParams()
    {
        return $this->_params;
    }

    /**
     * Sets the widget params from an ini string and 
     * converts it into an array
     * 
     * @param string $params
     * @return ZendSF_Model_Widget 
     */
    public function setParams($params)
    {
        if (is_string($params)) {
           $this->_params = parse_ini_string($params); 
        } else {
            throw new ZendSF_Model_Exception(
                '$params must be a string in: '
                . __CLASS__ . ':'
                . __METHOD__
            );
        }
        
        return $this;
    }

    /**
     * Gets the widget html content
     * 
     * @return sting 
     */
    public function getHtml()
    {
        return $this->_html;
    }

    /**
     * Sets the widget html content
     * 
     * @param string $html
     * @return ZendSF_Model_Widget 
     */
    public function setHtml($html)
    {
        $this->_html = (string) $html;
        return $this;
    }

    /**
     * Gets the widget enabled flag
     * 
     * @return bool
     */
    public function getEnabled()
    {
        return $this->_enabled;
    }

    /**
     * Sets the widget enabled flag
     * 
     * @param bool $enabled
     * @return ZendSF_Model_Widget 
     */
    public function setEnabled($enabled)
    {
        $this->_enabled = (bool) $enabled;
        return $this;
    }
}
