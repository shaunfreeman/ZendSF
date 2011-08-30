<?php
/**
 * Widget.php
 *
 * Copyright (c) 2011 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 * This file is part of Uthando-CMS.
 *
 * Uthando-CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Uthando-CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Uthando-CMS.  If not, see <http ://www.gnu.org/licenses/>.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_Mapper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of ZendSF_Model_Mapper_Widget
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_Mapper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Model_Mapper_Widget extends ZendSF_Model_Mapper_Acl_Abstract
{
    /**
     * @var string the DbTable class name
     */
    protected $_dbTableClass = 'ZendSF_Model_DbTable_Widget';

    /**
     * @var sting the model class name
     */
    protected $_modelClass = 'ZendSF_Model_Widget';

    /**
     * Gets a widget by its name
     *
     * @param string $widget
     * @return ZendSF_Model_Widget
     */
    public function getWidgetByName($widget)
    {
        $select = $this->getDbTable()
            ->select()
            ->where('name = ?', $widget)
            ->where('enabled = 1');

        return $this->fetchRow($select);
    }

    /**
     * Gets a group of widgets by their group name
     *
     * @param string $group
     * @param bool $raw
     * @return ZendSF_Model_Widget
     */
    public function getWidgetsByGroup($group, $raw = false)
    {
        $widgetGroupTable = new ZendSF_Model_Mapper_WidgetGroup();
        $group = $widgetGroupTable->getWidgetGroup($group, $raw);

        $widgets = $group->findDependentRowset(
            'ZendSF_Model_DbTable_Widget',
            'Group'
        );

        $entries = array();

        foreach ($widgets as $row) {
			if ($row->enabled) {
            	$entries[] = new ZendSF_Model_Widget($row);
			}
        }

        return $entries;
    }

    /**
     * Saves a widget to the database
     */
    public function save()
    {
        if (!$this->checkAcl('save')) {
            throw new ZendSF_Acl_Exception('saving widgets is not allowed.');
        }
    }

    /**
     * Deletes an widget by its id
     *
     * @param int $id
     */
    public function delete($id)
    {
        if (!$this->checkAcl('delete')) {
            throw new ZendSF_Acl_Exception('deleting widgets is not allowed.');
        }

        $where = $this->getDbTable()
            ->getAdapter()
            ->quoteInto('widgetId = ?', $id);

        return parent::delete($where);
    }

    /**
     * Injector for the acl
     *
     * We add all the access rule for this resource here
     *
     * @param Zend_Acl $acl
     * @return ZendSF_Model_Mapper_Widget
     */
    public function setAcl($acl) {
        parent::setAcl($acl);

        $this->_acl
            ->allow('admin', $this);

        return $this;
    }
}
