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
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>k
 */

/**
 * Base model class that all our models will inherit from.
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Model
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public Licenset
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_Model_Abstract
{
    /**
     * @var array Class methods
     */
    protected $_classMethods;

    /**
     * Constructor
     *
     * @param array|Zend_Config|null $options
     */
    public function __construct($options = null)
    {
        $this->_classMethods = get_class_methods($this);

        if ($options instanceof Zend_Config) {
            $options = $options->toArray();
        }

        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * Sets the property in this class.
     *
     * @param string $name
     * @param mixed $value
     */
    public function  __set($name, $value) {
       $method = 'set' . ucfirst($name);

        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new ZendSF_Exception('Invalid ' . $name . ' property');
        }

        $this->$method($value);
    }

    /**
     * Gets the property in this class.
     *
     * @param string $name
     * @return mixed
     */
    public function  __get($name) {
        $method = 'get' . ucfirst($name);

        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new ZendSF_Exception('Invalid ' . $name . ' property');
        }

        return $this->$method();
    }

    /**
     * Sets the options for this class.
     *
     * @param array $options
     * @return ZendSF_Model_Abstract
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $this->_classMethods)) {
                $this->$method($value);
            }
        }

        return $this;
    }

    /**
     * Turns class values into an array.
     *
     * @return array
     */
    public function toArray()
    {
        $array = array();

        foreach ($this->_classMethods as $method) {
            if (substr($method, 0, 3) == 'get') {
                $array[lcfirst(substr($method,3))] = $this->$method();
            }
        }

        return $array;
    }
}
?>
