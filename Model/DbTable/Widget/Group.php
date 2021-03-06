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
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_DbTable
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of ZendSF_Model_DbTable_Widget_Group
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_DbTable
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Model_DbTable_Widget_Group extends ZendSF_Model_DbTable_Abstract
{
    protected $_name = 'widgetGroup';
    protected $_primary = 'widgetGroupId';
    protected $_rowClass = 'ZendSF_Model_DbTable_Row_Widget_Group';

    protected $_dependentTables = array('ZendSF_Model_DbTable_Widget');

    public function getWidgetGroupById($id)
    {
        return $this->find($id)->current();
    }

    public function getWidgetGroupByName($name)
    {
        $select = $this->select()->where('widgetGroup = ?', $name);
        return $this->fetchRow($select);
    }
}

