<?php
namespace Geo\Coder\Plugin;

use Geo\Coder\PluginInterface;
use Geo\Coder;

class Mock implements PluginInterface
{
    private $_config;

    public function getId()
    {
    }

    public function getPlaceId()
    {
    }

    public function getLat()
    {
    }

    public function getLon()
    {
    }

    public function getBoundingBox()
    {
    }

    public function getType()
    {
    }

    public function getClass()
    {
        return $this->_config['name'];
    }

    public function getPrecision()
    {
        return $this->_config['retval'] ? Coder::PRECISION_HIGH : Coder::PRECISION_NONE;
    }

    public function getHouse()
    {
    }

    public function getRoad()
    {
    }

    public function getSuburb()
    {
    }

    public function getCityDistrict()
    {
    }

    public function getHamlet()
    {
    }

    public function getCounty()
    {
    }

    public function getStateDistrict()
    {
    }

    public function getState()
    {
    }

    public function getZip()
    {
    }

    public function getCountry()
    {
    }

    public function getCountryCode()
    {
    }

    public function getContinent()
    {
    }

    public function getTimezone()
    {
    }

    public function getAreaCode()
    {
    }

    public function getAirport()
    {
    }

    /**
     * @param $addr
     * @return mixed
     */
    public function fetchCoords( $addr )
    {
        return $this->_config['retval'];
    }

    function __construct( $conf )
    {
        $this->_config = $conf;
    }

    function __destruct()
    {
    }

}