<?php
/**
 * Html.php
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
 * @subpackage Widget
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of Html
 *
 * @category ZendSF
 * @package ZendSF
 * @subpackage Widget
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Widget_Html extends Uthando_Widget_Acl
{
    protected function  init() {
        $this->_view->html = $this->_view->widget->html;
    }
}
?>
