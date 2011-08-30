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
 * @subpackage Model_Mapper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of ZendSF_Model_Mapper_Widget_Group
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_Mapper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Model_Mapper_WidgetGroup extends ZendSF_Model_Mapper_Acl_Abstract
{
    /**
     * @var string the DbTable class name
     */
    protected $_dbTableClass = 'ZendSF_Model_DbTable_WidgetGroup';

    /**
     * @var sting the model class name
     */
    protected $_modelClass = 'ZendSF_Model_WidgetGroup';

    /**
     * Gets the widget group by its id
     *
     * @param string $group
     * @param bool $raw
     * @return type
     */
    public function getWidgetGroup($group, $raw = false)
    {
        $select = $this->getDbTable()
            ->select()
            ->where('widgetGroup = ?', $group);

        return $this->fetchRow($select, $raw);
    }

    /**
     * Saves a widget group to the database
     */
    public function save()
    {
        if (!$this->checkAcl('save')) {
            throw new ZendSF_Acl_Exception('saving widget groups is not allowed.');
        }
    }

    /**
     * Deletes a widget group by its id
     *
     * @param int $id
     */
    public function delete($id)
    {
        if (!$this->checkAcl('delete')) {
            throw new ZendSF_Acl_Exception('deleting widget groups is not allowed.');
        }

        $where = $this->getDbTable()
            ->getAdapter()
            ->quoteInto('widgetGroupId = ?', $id);

        return parent::delete($where);
    }

    /**
     * Injector for the acl
     *
     * We add all the access rule for this resource here
     *
     * @param Zend_Acl $acl
     * @return ZendSF_Model_Mapper_Widget_Group
     */
    public function setAcl($acl) {
        parent::setAcl($acl);

        $this->_acl
            ->allow('admin', $this);

        return $this;
    }
}