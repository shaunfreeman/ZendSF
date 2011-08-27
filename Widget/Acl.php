<?php
/**
 * Acl.php
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
 * @category ZendSF
 * @package ZendSF
 * @subpackage Widget
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of Acl
 *
 * @category ZendSF
 * @package ZendSF
 * @subpackage Widget
 * @author Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
abstract class ZendSF_Widget_Acl extends ZendSF_Widget_Abstract
{
    protected $_acl;
    protected $_identity;

    protected function getAcl()
    {
        if (!$this->_acl instanceof ZendSF_Acl_Abstarct) {
            //$this->_acl = new Uthando_Acl_Uthando();
        }

        return $this->_acl;
    }

    protected function getIdentity()
    {
        if (!$this->_identity instanceof Zend_Auth) {
            $this->_identity = Zend_Auth::getInstance();
        }

        return $this->_identity;
    }

    protected function getRole()
    {
        if (!$this->_identity instanceof Zend_Auth) {
            $this->getIdentity();
        }

        return ($this->_identity->hasIdentity()) ? $this->_identity->getIdentity()->role : 'guest';
    }
}
?>
