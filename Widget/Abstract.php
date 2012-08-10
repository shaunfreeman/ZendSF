<?php
/**
 * Abstract.php
 *
 * Copyright (c) 2011 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 * This file is part of ZendSF.
 *
 * Uthando-CMS is free software: you can redistribute it and/or modify
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
 * @subpackage Widget
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of ZendSF_Widget_Abstract
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Widget
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_Widget_Abstract
{
    /**
     * Zend_View instance.
     *
     * @var Zend_View
     */
    protected $_view;

    /**
     * Widget template.
     *
     * @var $_viewTemplate
     */
    protected $_viewTemplate;

    /**
     * Contructor for widget class.
     *
     * @param object|array $widget
     * @return none
     */
    public function __construct($widget)
    {
        $this->_view = new Zend_View();

        $this->_view->addHelperPath('ZendSF/View/Helper', 'ZendSF_View_Helper');

        $this->_view->setScriptPath(realpath(dirname(__FILE__) . '/views'));

        $this->_view->addScriptPath(
            realpath(APPLICATION_PATH
            . '/../public/templates/widgets')
        );

        if (is_array($widget)) {
            $widget = ZendSF_Utility_Array::arrayToObject($widget);
        }

        if (isset($widget->params['view_template'])) {
            $this->_viewTemplate = $widget->params['view_template'];
        }

        $this->_view->assign('widget', (object) $widget);
        $this->setParams();

        $this->init();
    }

    /**
     * This method is overridden by parent class for an extra construction method
     *
     * @param none
     * @return none
     */
    protected function init() {}

    /**
     * Sets the params of the widget.
     * Takes an ini string as the argument.
     *
     * @param string $params ini string.
     * @return none
     */
    public function setParams($params = null)
    {
        $params = ($params) ? $params : $this->_view->widget->params;
        $this->_view->assign('params', (array) $params);
    }

    /**
     * Renders the widget into an string of Html code.
     *
     * @param none
     * @return string html
     */
    public function render()
    {
        return $this->_view->render($this->_viewTemplate);
    }
}
