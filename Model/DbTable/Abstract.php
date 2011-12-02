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
 * along with ZendSF.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_DbTable
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Abstract database adapter class.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_DbTable
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_Model_DbTable_Abstract extends Zend_Db_Table_Abstract
{
    /**
     * Save a row to the database
     *
     * @param array $data The data to insert/update
     * @param Zend_DB_Table_Row $row Optional The row to use
     * @return mixed The primary key
     */
    public function saveRow($data, $row = null)
    {
        if (null === $row) {
            $row = $this->createRow();
        }

        $columns = $this->info('cols');
        foreach ($columns as $column) {
            if (array_key_exists($column, $data)) {
                $row->$column = $data[$column];
            }
        }

        return $row->save();
    }

    /**
     * Delete a row in the database.
     *
     * @param int $id Primary key of the row to be deleted
     * @return int The number of rows deleted
     */
    public function deleteRow($id)
    {
        if (!is_numeric($id)) {
            throw new ZendSF_Model_Exception('Could not delete row in ' . __CLASS__);
        }

        $row = $this->find($id)->current();
        return $row->delete();
    }

    /**
     * must be overridden by child class.
     *
     * @param mixed $search
     */
    public function numRows($search)
    {
        return false;
    }

    /**
     * Adds limit and offset to query.
     *
     * @param Zend_Db_Table_Select
     * @param int $count
     * @param int $offset
     * @return Zend_Db_Table_Select
     */
    public function getLimit(Zend_Db_Table_Select $select, $count, $offset)
    {
        if ($count === null) {
            return $select;
        }

        return $select->limit($count, $offset);
    }

    /**
     * Adds an order by to query.
     *
     * @param Zend_Db_Table_Select
     * @param string $sort
     * @return Zend_Db_Table_Select
     */
    public function getSortOrder(Zend_Db_Table_Select $select, $sort)
    {
        if ($sort === '') {
            return $select;
        }

        if(strchr($sort,'-')) {
            $sort = substr($sort, 1, strlen($sort));
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }

        return $select->order($sort . ' ' . $order);
    }
}
