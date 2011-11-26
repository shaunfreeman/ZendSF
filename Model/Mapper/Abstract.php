<?php
/**
 * Abstract.php
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
     * @var string the DbTable class name
     */
    protected $_dbTableClass;

    /**
     * @var sting the model class name
     */
    protected $_modelClass;

    /**
     * @var array the model namespace split into an array
     */
    protected $_namespace;

    /**
     * @var ZendSF_Model_Mapper_Cache_Abstract
     */
    protected $_cache;

    /**
     * @var arrar cache options
     */
    protected $_cacheOptions;

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
     * @return ZendSF_Model_Abstract|Zend_Db_Table_Row_Abstract|null
     */
    public function find($id, $raw = false)
    {
        $result = $this->getDbTable()->find($id);

        if (0 == count($result)) {
            return;
        }

        $resultSet = $result->current();

        if (!$raw) {
            $model = new $this->_modelClass($resultSet);
            $model->setCols($this->getDbTable()->info('cols'));
            $resultSet = $model;
        }

        return $resultSet;
    }

    /**
     * Fetches all entries in table or from a select object.
     *
     * @param object $select dbTable select object
     * @return array ZendSF_Model_Abstract|Zend_Db_Table_Row_Abstract|null
     */
    public function fetchAll($select = null, $raw = false)
    {
        $resultSet = $this->getDbTable()->fetchAll($select);
        $cols = $this->getDbTable()->info('cols');

        if (!$raw) {
            $rows = array();

            foreach ($resultSet as $row) {
                $model = new $this->_modelClass($row);
                $model->setCols($cols);
                $rows[] = $model;
            }

            $resultSet = $rows;
            unset($rows);
        }

        return $resultSet;
    }

    /**
     * Fetches one row from database.
     *
     * @param object $select dbTable select object
     * @param bool $raw Weather to retrun the model class or Zend_Db_Table_Abstract
     * @return ZendSF_Model_Abstract|Zend_Db_Table_Row_Abstract|null
     */
    public function fetchRow($select, $raw = false)
    {
        $resultSet = $this->getDbTable()->fetchRow($select);

        if (0 == count($resultSet)) {
            return;
        }

        if (!$raw) {
            $model = new $this->_modelClass($resultSet);
            $model->setCols($this->getDbTable()->info('cols'));
            $resultSet = $model;
        }

        return $resultSet;
    }

    /**
     * Saves a row to database
     *
     * @param ZendSF_Model_Abstract $model
     * @return mixed
     */
    public function save($model)
    {
        $primary = current($this->getDbTable()->info('primary'));
        $cols = $this->getDbTable()->info('cols');

        $data = $model->toArray();

        // We don't want the primary key in our query.
        unset($data[$primary]);

        // Just get the values we need to update the database.
        foreach ($data as $key => $value) {
            if (!in_array($key, $cols)) {
                unset($data[$key]);
            } elseif ($value === null) {
                unset($data[$key]);
            }
        }

        if (null === ($id = $model->getId())) {
            return $this->getDbTable()->insert($data);
        } else {
            return $this->getDbTable()->update($data, array(
                $primary . ' = ?' => $id
            ));
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
     * Paginates the Db result.
     *
     * @param Zend_Db_Table_Select $select
     * @param int $paged
     * @param int $numDisplay
     * @return Zend_Paginator
     */
    protected function _paginate($select, $paged, $numDisplay = 25)
    {
        $adapter = new ZendSF_Paginator_Adapter_DbTableSelect($select);

        $primary = current($this->getDbTable()->info('primary'));
        $fromParts = $select->getPart('from');

        // this needs chanings. find another way to get main table.
        $mainTable = strtolower(end(explode('_', $this->_dbTableClass)));

        unset($fromParts[$mainTable]);

        $count = clone $select;
        $count->reset(Zend_Db_Select::COLUMNS);
        $count->reset(Zend_Db_Select::FROM);

        $count->from(
            $mainTable,
            new Zend_Db_Expr(
                'COUNT(' . $primary . ') AS `zend_paginator_row_count`'
            )
        );

        if (count($fromParts) > 0) {
            foreach($fromParts as $part) {
                $count->join(
                    $part['tableName'],
                    $part['joinCondition'],
                    null
                );
            }
        }

        $adapter->setRowCount($count);
        $adapter->modelClass = $this->_modelClass;

        $paginator = new Zend_Paginator($adapter);

        $paginator->setItemCountPerPage((int) $numDisplay)
            ->setCurrentPageNumber((int) $paged);

        return $paginator;
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
            $this->_forms[$name] = new $class(array('model' => $this));
        }
	    return $this->_forms[$name];
    }

    /**
     * Set the cache to use.
     *
     * @param ZendSF_Model_Mapper_Cache_Abstract $cache
     */
    public function setCache(ZendSF_Model_Mapper_Cache_Abstract $cache)
    {
        $this->_cache = $cache;
    }

    /**
     * Set the options
     *
     * @param array $options
     */
    public function setCacheOptions(array $options)
    {
        $this->_cacheOptions = $options;
    }

    /**
     * Get the cache options
     *
     * @return array
     */
    public function getCacheOptions()
    {
        if (empty($this->_cacheOptions)) {
           $cacheOptions = Zend_Registry::get('config')
                ->cache
                ->modelMapper;

            $this->_cacheOptions = array(
                'frontend'          => $cacheOptions->frontend->type,
                'backend'           => $cacheOptions->backend->type,
                'frontendOptions'   => $cacheOptions->frontendOptions->toArray(),
                'backendOptions'    => $cacheOptions->backendOptions->toArray()
            );
        }

        return $this->_cacheOptions;
    }

    /**
     * Query the cache
     *
     * @param type $tagged The tag to save data to
     * @return ZendSF_Model_Mapper_Cache_Abstract
     */
    public function getCached($tagged = null)
    {
        if (null === $this->_cache) {
            $this->_cache = new ZendSF_Model_Mapper_Cache(
                $this,
                $this->getCacheOptions()
            );
        }

        $this->_cache->setTagged($tagged);

        return $this->_cache;
    }
    /**
     * Classes are named spaced using their module name
     * this returns that module name or the first class name segment.
     *
     * @return string This class namespace
     */
    protected function _getNamespace()
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
    protected function _getInflected($name)
    {
        $inflector = new Zend_Filter_Inflector(':class');
        $inflector->setRules(array(
            ':class'  => array('Word_CamelCaseToUnderscore')
        ));
        return ucfirst($inflector->filter(array('class' => $name)));
    }
}
