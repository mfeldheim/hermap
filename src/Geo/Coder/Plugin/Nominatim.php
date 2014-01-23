<?php
namespace Geo\Coder\Plugin;

use Geo\Coder\Exception;
use Geo\Coder\PluginInterface;
use Geo\Coder;
use Guzzle\Http\Client;

class Nominatim implements PluginInterface
{
    private $_config = array();
    private $_result = false;

    private $_params = array(
        'accept-language' => 'en',
        'format' => 'json',
        'q' => null,
        'limit' => 1,
        'addressdetails' => 1
    );

    public function __construct($config) {
        $this->_config = $config;

        if ( !array_key_exists( 'requestURI', $this->_config ) ) {
            throw new Exception( 'Nominatim plugin requires a requestURI config parameter' );
        }

        if ( array_key_exists( 'i118n', $config ) ) {
            $this->_params['accept-language'] = $config['i118n'];
        }
    }

    public function getId()
    {
        return $this->_result ? intval( $this->_result['osm_id'] ) : false;
    }

    public function getPlaceId()
    {
        return $this->_result ? intval( $this->_result['place_id'] ) : false;
    }

    public function getLat()
    {
        return $this->_result ? round( $this->_result['lat'], 8 ) : false;
    }

    public function getLon()
    {
        return $this->_result ? round( $this->_result['lon'], 8 ) : false;
    }

    public function getBoundingBox()
    {
        return $this->_result ? array(
            'north' => round( $this->_result['boundingbox'][0], 8 ),
            'south' => round( $this->_result['boundingbox'][1], 8 ),
            'east' => round( $this->_result['boundingbox'][2], 8 ),
            'west' => round( $this->_result['boundingbox'][3], 8 )
        ) : false;
    }

    /**
     * @todo: implement geo types
     * @return bool
     */
    public function getType()
    {
        if ( !$this->_result ) {
            return false;
        }

        return false;
    }

    /**
     * @todo implement geo classes
     */
    public function getClass()
    {
        if ( !$this->_result ) {
            return false;
        }

        return false;
    }

    /**
     * @todo implement precision
     * @return int
     */
    public function getPrecision()
    {
        if ( !$this->_result or !array_key_exists( 'house_number', $this->_result['address'] )) {
            return Coder::PRECISION_NONE;
        }
        return Coder::PRECISION_HIGH;
    }

    public function getHouse()
    {
        if ( !$this->_result or !array_key_exists( 'house_number', $this->_result['address'] )) {
            return false;
        }
        return $this->_result['address']['house_number'];
    }

    public function getRoad()
    {
        if ( !$this->_result or !array_key_exists( 'road', $this->_result['address'] )) {
            return false;
        }
        return $this->_result['address']['road'];
    }

    public function getSuburb()
    {
        if ( !$this->_result or !array_key_exists( 'suburb', $this->_result['address'] )) {
            return false;
        }
        return $this->_result['address']['suburb'];
    }

    public function getCityDistrict()
    {
        if ( !$this->_result or !array_key_exists( 'city_district', $this->_result['address'] )) {
            return false;
        }

        return preg_replace( '/.*[\d]+ /', '', $this->_result['address']['city_district'] );
    }

    public function getHamlet()
    {
        if ( !$this->_result or !array_key_exists( 'hamlet', $this->_result['address'] )) {
            return false;
        }

        return $this->_result['address']['hamlet'];
    }

    public function getCounty()
    {
        if ( !$this->_result or !array_key_exists( 'county', $this->_result['address'] )) {
            return false;
        }

        return $this->_result['address']['county'];
    }

    public function getStateDistrict()
    {
        if ( !$this->_result or !array_key_exists( 'state_district', $this->_result['address'] )) {
            return false;
        }

        return $this->_result['address']['state_district'];
    }

    public function getState()
    {
        if ( !$this->_result or !array_key_exists( 'state', $this->_result['address'] )) {
            return false;
        }

        return $this->_result['address']['state'];
    }

    public function getZip()
    {
        if ( !$this->_result or !array_key_exists( 'postcode', $this->_result['address'] )) {
            return false;
        }

        return $this->_result['address']['postcode'];
    }

    public function getCountry()
    {
        if ( !$this->_result or !array_key_exists( 'country', $this->_result['address'] )) {
            return false;
        }

        return $this->_result['address']['country'];
    }

    public function getCountryCode()
    {
        if ( !$this->_result or !array_key_exists( 'country_code', $this->_result['address'] )) {
            return false;
        }
        return strtoupper( $this->_result['address']['country_code'] );
    }

    public function getContinent()
    {
        if ( !$this->_result or !array_key_exists( 'continent', $this->_result['address'] )) {
            return false;
        }

        return $this->_result['address']['continent'];
    }

    public function getTimezone()
    {
        return false;
    }

    public function getAreaCode()
    {
        return false;
    }

    public function getAirport()
    {
        return false;
    }

    /**
     * @param $address
     * @return bool
     */
    public function fetchCoords($address)
    {
        if ( null === trim( $address ) ) {
            return false;
        }

        $client = new Client();
        $request = $client->createRequest( 'GET',  $this->_config['requestURI'] );

        $this->_params['q'] = trim( $address );
        foreach( $this->_params as $key => $param ) {
            $request->getQuery()->set( $key, $param );
        }

        $response = $request->send();

        if ( $response->getStatusCode() !== 200 ) {
            return false;
        }

        $result = $response->json();

        if ( !is_array( $result ) || !sizeof( $result ) ) {
            return false;
        }
        $this->_result = $result[0];
        return true;
    }
}