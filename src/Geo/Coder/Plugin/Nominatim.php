<?php
namespace Geo\Coder\Plugin;

use Geo\Coder\Exception;
use Geo\Coder\PluginInterface;
use Guzzle\Http\Client;

class Nominatim implements PluginInterface
{
    private $_config = array();

    public function __construct($config) {
        $this->_config = $config;

        if ( !array_key_exists( 'requestURI', $this->_config ) ) {
            throw new Exception( 'Nominatim plugin requires a requestURI config parameter' );
        }
    }

    public function getId()
    {
        // TODO: Implement getId() method.
    }

    public function getPlaceId()
    {
        // TODO: Implement getPlaceId() method.
    }

    public function getLat()
    {
        // TODO: Implement getLat() method.
    }

    public function getLon()
    {
        // TODO: Implement getLon() method.
    }

    public function getBoundingBox()
    {
        // TODO: Implement getBoundingBox() method.
    }

    public function getType()
    {
        // TODO: Implement getType() method.
    }

    public function getClass()
    {
        // TODO: Implement getClass() method.
    }

    public function getPrecision()
    {
        // TODO: Implement getPrecision() method.
    }

    public function getHouse()
    {
        // TODO: Implement getHouse() method.
    }

    public function getRoad()
    {
        // TODO: Implement getRoad() method.
    }

    public function getSuburb()
    {
        // TODO: Implement getSuburb() method.
    }

    public function getCityDistrict()
    {
        // TODO: Implement getCityDistrict() method.
    }

    public function getCounty()
    {
        // TODO: Implement getCounty() method.
    }

    public function getStateDistrict()
    {
        // TODO: Implement getStateDistrict() method.
    }

    public function getState()
    {
        // TODO: Implement getState() method.
    }

    public function getZip()
    {
        // TODO: Implement getZip() method.
    }

    public function getCountry()
    {
        // TODO: Implement getCountry() method.
    }

    public function getCountryCode()
    {
        // TODO: Implement getCountryCode() method.
    }

    public function getTimezone()
    {
        // TODO: Implement getTimezone() method.
    }

    public function getAreaCode()
    {
        // TODO: Implement getAreaCode() method.
    }

    public function getAirport()
    {
        // TODO: Implement getAirport() method.
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
        $request->getQuery()
            ->set( 'q', $address )
            ->set( 'addressdetails', 1 )
            ->set( 'format', 'json' );

        $response = $request->send();

        if ( $response->getStatusCode() !== 200 ) {
            return false;
        }

        $this->_result = $response->json();
        print_r( $this->_result );
        return true;
    }
}