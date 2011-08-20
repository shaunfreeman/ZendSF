<?php
/**
 * DojoLayer.php
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
 * @subpackage Controller_Plugin
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */

/**
 * Description of DojoLayer
 *
 * @category   ZendSF
 * @package    ZendSF
 * @subpackage Controller_Plugin
 * @copyright  Copyright (c) 2011 Shaun Freeman. (http://www.shaunfreeman.co.uk)
 * @license    http://www.gnu.org/licenses GNU General Public License
 * @author     Shaun Freeman <shaun@shaunfreeman.co.uk>
 */
class ZendSF_Controller_Plugin_DojoLayer extends Zend_Controller_Plugin_Abstract
{
    public $layerScript;
    public $buildProfile;
    protected $_build;

    public function dispatchLoopShutdown()
    {
        $this->layerScript = APPLICATION_PATH . '/../public/js/main.js';
        $this->buildProfile = APPLICATION_PATH . '/../public/js/custom.profile.js';
        if (!file_exists($this->layerScript)) {
            $this->generateDojoLayer();
        }

        if (!file_exists($this->buildProfile)) {
            $this->generateBuildProfile();
        }
    }

    public function getBuild()
    {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );
        $viewRenderer->initView();
        if (null === $this->_build) {
            $this->_build = new Zend_Dojo_BuildLayer(array(
                'view'      => $viewRenderer->view,
                'layerName' => 'custom.main',
            ));
        }
        return $this->_build;
    }

    public function generateDojoLayer()
    {
        $build = $this->getBuild();
        $layerContents = $build->generateLayerScript();
        if (!file_exists(dirname($this->layerScript))) {
            mkdir(dirname($this->layerScript));
        }
        file_put_contents($this->layerScript, $layerContents);
    }

    public function generateBuildProfile()
    {
        $profile = $this->getBuild()->generateBuildProfile();
        file_put_contents($this->buildProfile, $profile);
    }
}
