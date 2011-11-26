<?php
/**
 * MapperHelper.php
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
 * Base helper for form mappers.  Extend this, don't use it on its own.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage View_Helper
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_View_Helper_MapperHelper extends Zend_View_Helper_Abstract
{
    /**
     * @var ZendSF_Model_Mapper_Abstract
     */
    protected $_model;

    /**
     * @var string
     */
    protected $_modelClass;

    /**
     * @var Zend_Db_Table_Row_Abstract
     */
    protected $_row;

    /**
     * @var array
     */
    protected $_data = array();

    /**
     * Gets the database mapper.
     *
     * @return Zend_Model_Mapper_Abstract
     */
    public function getModel()
    {
        if (null === $this->_model) {
            $this->setModel($this->_modelClass);
        }
        return $this->_model;
    }

    /**
     * Sets the database mapper.
     *
     * @param string $model
     * @return ZendSF_View_Helper_MapperHelper
     */
    protected function setModel($model)
    {
        $this->_model = new $model();
        return $this;
    }

    /**
     * Gets the column value from the database.
     *
     * @param string $col
     * @return mixed
     */
    public function get($col)
    {
        return isset($this->_data[$col]) ? $this->_data[$col] : null;
    }

    /**
     * Sets data from the database row to return later.
     *
     * @param array $data
     * @return ZendSF_View_Helper_MapperHelper
     */
    protected function set(array $data)
    {
        $dataTemp = $this->_data;
        $this->_data = array_merge($dataTemp, $data);
        return $this;
    }

    /**
     * Gets parent row by rule definition.
     *
     * @param string $rule
     * @return ZendSF_View_Helepr_MapperHelper
     */
    public function getParentRow($rule)
    {
        if ($this->_row) {
            $referenceMap = $this->_row->getTable()->info('referenceMap');
            $row = $this->_row->findParentRow($referenceMap[$rule]['refTableClass'], $rule);
            $this->set($row->toArray());
        }
        return $this;
    }
}
