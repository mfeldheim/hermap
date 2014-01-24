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

namespace Geo\Coder;

interface PluginInterface
{
    // e.g. OSM ID
    public function getId();
    // e.g. Place id
    public function getPlaceId();

    public function getLat();
    public function getLon();

    public function getBoundingBox();

    public function getType();
    public function getClass();

    // scale 0-9
    public function getPrecision();

    public function getHouse();
    public function getRoad();
    public function getSuburb();
    public function getCityDistrict();
    public function getHamlet();
    public function getCounty();
    public function getStateDistrict();
    public function getState();
    public function getZip();
    public function getCountry();
    public function getCountryCode();
    public function getContinent();
    public function getTimezone();
    public function getAreaCode();
    public function getAirport();

    /**
     * @param $address
     * @return mixed
     */
    public function fetchCoords($address);
}