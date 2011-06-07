<?php
/**
 * MapperAbstract.php
 *
 * Copyright (c) 2010 Shaun Freeman <shaun@shaunfreeman.co.uk>.
 *
 * This file is part of ZendSF.
 *
 * ZendSF is free software: you can redistribute it and/or modify
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
 * along with ZendSF.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_Mapper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Provides some common db functionality that is shared
 * across our db-based resources.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model_Mapper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_Model_Mapper_Abstract
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     * @var string DbTable class name
     */
    protected $_dbTableClass;

    /**
     * @var sting model class name
     */
    protected $_modelClass;

    /**
     * Sets the database table object.
     *
     * @param string $dbTable
     * @return ZendSF_Model_Mapper_Abstract
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }

        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }

        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Gets the database table object.
     *
     * @param none
     * @return object $_dbTable
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable($this->_dbTableClass);
        }

        return $this->_dbTable;
    }

    /**
     * Deletes records from database.
     *
     * @param string $where
     * @return Zend_Db_Table_Abstrac
     */
    protected function _delete($where)
    {
        return $this->getDbTable()->delete($where);
    }

    /**
     * Finds a single record by it's id.
     *
     * @param int $id
     * @return mixed
     */
    public function find($id) {
        $result = $this->getDbTable()->find($id);

        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        return $this->_setVars($row, new $this->_modelClass());
    }

    /**
     * Fetches all entries in table or from a select object.
     *
     * @param object $select dbTable select object
     * @return array $entries
     */
    public function fetchAll($select = null) {
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();

        foreach ($resultSet as $row) {
            $entries[] = $this->_setVars($row, new $this->_modelClass());
        }

        return $entries;
    }

    /**
     * Fetches one row from database.
     *
     * @param object $select dbTable select object
     * @param bool $raw Weather to retrun the model class or Zend_Db_Table_Abstract
     * @return mixed
     */
    public function fetchRow($select, $raw = false)
    {
        $row = $this->getDbTable()->fetchRow($select);

        if (0 == count($row)) {
            return;
        }

        return ($raw) ? $row : $this->_setVars($row, new $this->_modelClass());
    }
}
?>
