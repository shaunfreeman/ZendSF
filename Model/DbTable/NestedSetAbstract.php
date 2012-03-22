<?php
/**
 * NestedSetAbstract.php
 *
 * Copyright (c) 2012 Shaun Freeman <shaun@shaunfreeman.co.uk>.
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
 * @package
 * @subpackage Model_DbTable
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Database adapter class for the NestedSetAbstract table.
 *
 * @category   ZendSF
 * @package
 * @subpackage Model_DbTable
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Model_DbTable_NestedSetAbstract extends ZendSF_Model_DbTable_Abstract
{
    /**
     * @var string database table
     */
    protected $_name = '';

    /**
     * @var string primary key
     */
    protected $_primary = '';

    /**
     * @var string row class.
     */
    protected $_rowClass = '';

    /**
     * @var array Reference map for parent tables
     */
    protected $_referenceMap = array();

    public function getCategoryById($id)
    {
        return $this->find($id)->current();
    }

    public function getAll()
    {
        $select = $this->select()
            ->from(array('child' => $this->_name))
            ->joinCross(array('parent' => $this->_name), null)
            ->columns(array('depth' => '(COUNT(parent.'.$this->_primary.') - 1)'))
            ->where('child.lft BETWEEN parent.lft AND parent.rgt')
            ->group('child.'.$this->_primary)
            ->order('child.lft');

        return $this->fetchAll($select);
    }

    public function getPathwayByChildId($id)
    {
        $select = $this->select(false)
            ->from(array('child' => $this->_name), null)
            ->joinCross(array('parent' => $this->_name), array('*'))
            ->where('child.lft BETWEEN parent.lft AND parent.rgt')
            ->where('child.'.$this->_primary.' = ?', $id)
            ->order('parent.lft');

        return $this->fetchAll($select);
    }

    public function getDecendentsByParentId($parentId, $immediate=true)
    {
        $subTree = $this->select()
            ->from(array('child' => $this->_name))
            ->joinCross(array('parent' => $this->_name), null)
            ->columns(array('depth' => '(COUNT(parent.'.$this->_primary.') - 1)'))
            ->where('child.lft BETWEEN parent.lft AND parent.rgt')
            ->where('child.'.$this->_primary.' = ?', $parentId)
            ->group('child.'.$this->_primary)
            ->order('child.lft');

        $select = $this->select()
            ->from(array('child' => $this->_name))
            ->joinCross(array('parent' => $this->_name), null)
            ->joinCross(array('subParent' => $this->_name), null)
            ->joinCross(array('subTree' => new Zend_Db_Expr('('.$subTree.')')), null)
            ->columns(array('depth' => '(COUNT(parent.'.$this->_primary.') - (subTree.depth + 1))'))
            ->where('child.lft BETWEEN parent.lft AND parent.rgt')
            ->where('child.lft BETWEEN subParent.lft AND subParent.rgt')
            ->where('subParent.'.$this->_primary.' = subTree.'.$this->_primary)
            ->group('child.'.$this->_primary)
            ->order('child.lft');

        if (true === $immediate) {
            $select->having('depth = 1');
        }

        return $this->fetchAll($select);
    }
}
