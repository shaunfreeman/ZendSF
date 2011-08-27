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
 * along with ZendSF.  If not, see <http ://www.gnu.org/licenses/>.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage View_Helper_Widget
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of Uthando_View_Helper_Widget_Abstract
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage View_Helper_Widget
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_View_Helper_Widget_Abstract extends Zend_View_Helper_Abstract
{
     /**
     *
     * @var mixed
     */
    protected $_widget = null;

    /**
     *
     * @var ZendSF_Model_Mapper_Widget
     */
    protected $_DbTable;

    /**
     * Parent class must contain this method.
     * Used to initise the widget
     */
    abstract public function widget();

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

    /**
     * Inflect the name using the inflector filter.
     * Changes camelCaseWord to Camel_Case_Word
     *
     * @param string $name The name to inflect
     * @return string The inflected string
     */
    protected function _getInflected($name)
    {
        $inflector = new Zend_Filter_Inflector(':class');
        $inflector->setRules(array(
            ':class'  => array('Word_CamelCaseToUnderscore')
        ));
        return ucfirst($inflector->filter(array('class' => $name)));
    }
}
