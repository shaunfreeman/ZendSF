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
     * @var array Form instances
     */
    protected $_forms = array();

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
            throw new ZendSF_Model_Exception('Invalid table data gateway provided');
        }

        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Gets the database table object.
     *
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable($this->_dbTableClass);
        }

        return $this->_dbTable;
    }

    /**
     * Finds a single record by it's id.
     *
     * @param int $id
     * @return ZendSF_Model_Abstract
     */
    public function find($id)
    {
        $result = $this->getDbTable()->find($id);

        if (0 == count($result)) {
            return;
        }

        $row = $result->current();
        return new $this->_modelClass($row);
    }

    /**
     * Fetches all entries in table or from a select object.
     *
     * @param object $select dbTable select object
     * @return array ZendSF_Model_Abstract
     */
    public function fetchAll($select = null)
    {
        $resultSet = $this->getDbTable()->fetchAll($select);
        $entries = array();

        foreach ($resultSet as $row) {
            $entries[] = new $this->_modelClass($row);
        }

        return $entries;
    }

    /**
     * Fetches one row from database.
     *
     * @param object $select dbTable select object
     * @param bool $raw Weather to retrun the model class or Zend_Db_Table_Abstract
     * @return ZendSF_Model_DbTable_Abstract|Zend_Db_Table_Row_Abstract|null
     */
    public function fetchRow($select, $raw = false)
    {
        $row = $this->getDbTable()->fetchRow($select);

        if (0 == count($row)) {
            return;
        }

        return ($raw) ? $row : new $this->_modelClass($row);
    }

    /**
     * Saves a row to database
     *
     * @param ZendSF_Model_Abstract $model
     * @return mixed
     */
    public function save(ZendSF_Model_Abstract $model)
    {
        $primary = $this->getDbTable()->info('primary');

        $data = $model->toArray();

        if (null === ($id = $model->$primary)) {
            unset($data[$pimary]);
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array($primary . ' = ?' => $id));
        }
    }

    /**
     * Deletes records from database.
     *
     * @param string $where clause for record deletion
     * @return int number of rows deleted
     */
    public function delete($where)
    {
        return $this->getDbTable()->delete($where);
    }

    /**
     * Gets a Form
     *
     * @param string $name
     * @return Zend_Form
     */
    public function getForm($name)
    {
        if (!isset($this->_forms[$name])) {
            $class = join('_', array(
                    $this->_getNamespace(),
                    'Form',
                    $this->_getInflected($name)
            ));
            $this->_forms[$name] = new $class();
        }
	    return $this->_forms[$name];
    }

    /**
     * Classes are named spaced using their module name
     * this returns that module name or the first class name segment.
     *
     * @return string This class namespace
     */
    private function _getNamespace()
    {
        $ns = explode('_', get_class($this));
        return $ns[0];
    }

    /**
     * Inflect the name using the inflector filter
     *
     * Changes camelCaseWord to Camel_Case_Word
     *
     * @param string $name The name to inflect
     * @return string The inflected string
     */
    private function _getInflected($name)
    {
        $inflector = new Zend_Filter_Inflector(':class');
        $inflector->setRules(array(
            ':class'  => array('Word_CamelCaseToUnderscore')
        ));
        return ucfirst($inflector->filter(array('class' => $name)));
    }
}
?>
