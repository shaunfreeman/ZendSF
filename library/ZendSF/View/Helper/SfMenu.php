<?php
/**
 * SfMenu.php
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
 * @subpackage View_Helper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * This class can add a 'span' tag to the 'a' tag when specified in the config file
 * using a 'span' element and setting it to 1. If no 'span' element is set or it is set
 * to 0 then the 'span' element is not generated unless a href is not specified.
 * example:
 *
 * <code>
 * <?xml version="1.0" encoding="UTF-8"?>
 * <nav>
 *  <topMenu>
 *   <home>
 *    <label>Home</label>
 *    <span>1</span>
 *    <module>core</module>
 *    <controller>index</controller>
 *    <action>index</action>
 *   </home>
 *  </topMenu>
 * </nav>
 * </code>
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage View_Helper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_View_Helper_SfMenu extends Zend_View_Helper_Navigation_Menu
{
    /**
     *
     * @param sring $container
     * @return ZendSF_View_Helper_SfMenu
     */
    public function sfMenu($container = null)
    {
        if (is_string($container) &&
                Zend_Registry::isRegistered('siteMenu' . ucfirst($container))) {
            /* @var $container Zend_Navigation */
            $container = Zend_Registry::get('siteMenu' . ucfirst($container));
        }

        if ($container instanceof Zend_Navigation_Container) {
            $this->setContainer($container);
        }
        return $this;
    }

    /**
     *
     * @param Zend_Navigation_Page $page
     * @return string
     */
    public function htmlify(Zend_Navigation_Page $page )
    {
        // get label and title for translating
        $label = $page->getLabel();
        $title = $page->getTitle();

        // translate label and title?
        if ($this->getUseTranslator() && $t = $this->getTranslator()) {
            if (is_string($label) && !empty($label)) {
                $label = $t->translate($label);
            }
            if (is_string($title) && !empty($title)) {
                $title = $t->translate($title);
            }
        }

        // get attribs for element
        $attribs = array(
            'id'     => $page->getId(),
            'title'  => $title,
            'class'  => $page->getClass()
        );

        $properties = $page->getCustomProperties();

        // does page have a href?
        if ($href = $page->getHref()) {
            $element = 'a';
            $attribs['href'] = $href;
            $attribs['target'] = $page->getTarget();
        } else {
            $element = 'span';
        }

        // add a span link?
        if (isset($properties['span']) && $properties['span'] == 1) {
            $spanStart = '<span>';
            $spanEnd = '</span>';
        } else {
            $spanStart = '';
            $spanEnd = '';
        }

        // does page have subpages?
        if ($page->count()) {
            $sub_indicator = '&raquo;';
        } else {
            $sub_indicator = '';
        }

        return '<' . $element . $this->_htmlAttribs($attribs) . '>'
             . $spanStart
             . $this->view->escape($label)
             . $sub_indicator
             . $spanEnd
             . '</' . $element . '>';
    }
}

?>
