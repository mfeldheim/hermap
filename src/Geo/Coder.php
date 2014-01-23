<?php
/*
 *  Copyright 2014 Michel Feldheim
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing,
 *  software distributed under the License is distributed
 *  on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND,
 *  either express or implied. See the License for the specific
 *  language governing permissions and limitations under the License.
 */

namespace Geo;

use Geo\Coder\Exception;
use Geo\Coder\PluginInterface;

class Coder
{
    const PRECISION_MANUAL  = 20;
    const PRECISION_HIGH    = 8;
    const PRECISION_MEDIUM  = 5;
    const PRECISION_LOW     = 1;
    const PRECISION_NONE    = 0;

    protected $_config;
    protected $_plugins = array();

    public function __construct( $plugins, $config = null )
    {
        if ( !is_array( $plugins ) ) {
            $plugins = array( $plugins );
        }

        foreach ( $plugins as $plugin ) {
            $this->registerPlugin( $plugin );
        }
    }

    public function __destruct() {}

    public function registerPlugin( PluginInterface $plugin )
    {
        $this->_plugins[] = $plugin;
    }

    public function fetchCoords( $address, $minPrecision )
    {
        if ( !sizeof( $this->_plugins ) ) {
            throw new Exception( 'No plugins registered' );
        }

        /**
         * @var $plugin PluginInterface
         */
        foreach ( $this->_plugins as $plugin ) {
            $plugin->fetchCoords( $address );
            if ( $plugin->getPrecision() >= $minPrecision ) {
                return $plugin;
            }
        }
    }
}
