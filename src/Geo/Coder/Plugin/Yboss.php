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

namespace Geo\Coder\Plugin;

use Geo\Coder\PluginInterface;
use Geo\Coder;
use Guzzle\Http\Client;
use Guzzle\Plugin\Oauth\OauthPlugin;

class Yboss implements PluginInterface
{
    const Y_BOSS_URL = 'http://yboss.yahooapis.com/geo/placefinder';

    private $_result;
    private $_config;
    private $_params	= array (
        'appid'	=> null,
        'q' => null,
        'locale' => 'en_US',
        'flags'	=> 'JSRTGQ',
        'gflags' => 'L'
    );

    public function __construct( $config )
    {
        $this->_config = $config;

        if ( false === array_key_exists( 'appid', $this->_config ) ) {
            throw new Zend_Exception( 'Y!Boss Plugin requires the config key "appid"' );
        }

        if ( false === array_key_exists( 'consumerKey', $this->_config ) ) {
            throw new Zend_Exception( 'Y!Boss Plugin requires the config key "consumerKey"' );
        }

        if ( false === array_key_exists( 'consumerSecret', $this->_config ) ) {
            throw new Zend_Exception( 'Y!Boss Plugin requires the config key "consumerSecret"' );
        }

        $this->_params['appid'] = $this->_config['appid'];

        if ( array_key_exists( 'locale', $this->_config ) ) {
            $this->_params['locale'] = $this->_config['locale'];
        }

        if ( array_key_exists( 'flags', $this->_config ) ) {
            $this->_params['flags'] = $this->_config['flags'];
        }

        if ( array_key_exists( 'gflags', $this->_config ) ) {
            $this->_params['gflags'] = $this->_config['gflags'];
        }
    }

    public function __destruct()
    {

    }

    public function getId()
    {
        return $this->_result ? $this->_result['woeid'] : false;
    }

    public function getPlaceId()
    {
        return $this->_result ? $this->_result['woeid'] : false;
    }

    public function getLat()
    {
        return $this->_result ? round( $this->_result['latitude'], 8 ) : false;
    }

    public function getLon()
    {
        return $this->_result ? round( $this->_result['longitude'], 8 ) : false;
    }

    public function getBoundingBox()
    {
        return false;
    }

    /**
     * @todo implement type constants
     * @return bool
     */
    public function getType()
    {
        return $this->_result ? $this->_result['unittype'] : false;
    }

    public function getClass()
    {
        return $this->_result ? $this->_result['woetype'] : false;
    }

    public function getPrecision()
    {
        if ( !$this->_result ) {
            return Coder::PRECISION_NONE;
        }
        $precision = round( $this->_result['quality'] / 10 );

        if ( $precision > 8 ) {
            return Coder::PRECISION_HIGH;
        }
        if ( $precision > 5 ) {
            return Coder::PRECISION_MEDIUM;
        }
        if ( $precision > 2 ) {
            return Coder::PRECISION_LOW;
        }
        return Coder::PRECISION_NONE;
    }

    public function getHouse()
    {
        return $this->_result ? $this->_result['house'] : false;
    }

    public function getRoad()
    {
        return $this->_result ? $this->_result['street'] : false;
    }

    public function getSuburb()
    {
        return false;
    }

    public function getCityDistrict()
    {
        return false;
    }

    public function getHamlet()
    {
        return false;
    }

    public function getCounty()
    {
        return $this->_result ? $this->_result['level2'] : false;
    }

    public function getStateDistrict()
    {
        return false;
    }

    public function getState()
    {
        return $this->_result ? $this->_result['level1'] : false;
    }

    public function getZip()
    {
        return $this->_result ? $this->_result['postal'] : false;
    }

    public function getCountry()
    {
        return $this->_result ? $this->_result['level0'] : false;
    }

    public function getCountryCode()
    {
        return $this->_result ? $this->_result['level0code'] : false;
    }

    public function getContinent()
    {
        return false;
    }

    public function getTimezone()
    {
        return $this->_result ? $this->_result['timezone'] : false;
    }

    public function getAreaCode()
    {
        return $this->_result ? $this->_result['areacode'] : false;
    }

    public function getAirport()
    {
        return $this->_result ? $this->_result['airport'] : false;
    }

    /**
     * @param $address
     * @return mixed
     */
    public function fetchCoords($address)
    {
        if ( null === trim( $address ) ) {
            return false;
        }

        $client = new Client();
        $oauth = new OauthPlugin(array(
            'consumer_key'  => $this->_config['consumerKey'],
            'consumer_secret' => $this->_config['consumerSecret']
        ));

        $client->addSubscriber( $oauth );

        $request = $client->createRequest( 'GET', self::Y_BOSS_URL );

        $this->_params['q'] = trim( $address );
        foreach( $this->_params as $key => $param ) {
            $request->getQuery()->set( $key, $param );
        }

        $response = $request->send();
        if ( $response->getStatusCode() !== 200 ) {
            return false;
        }

        $result = $response->json();

        if ( !is_array( $result )
            || !sizeof( $result )
            || !array_key_exists( 'bossresponse', $result )
            || $result['bossresponse']['responsecode'] != 200
            || !array_key_exists( 'placefinder', $result['bossresponse'] )
            || !array_key_exists( 'results', $result['bossresponse']['placefinder'] )
            || empty( $result['bossresponse']['placefinder']['results'] )
        ) {
            return false;
        }

        $this->_result = $result['bossresponse']['placefinder']['results'][0];

        return true;
    }
}