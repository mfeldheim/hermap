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

use Geo\Coder;

class NominatimTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Coder
     */
    protected static $geocoder;
    /** @var Nominatim */
    protected static $result;

    public static function setUpBeforeClass()
    {
        self::$geocoder = new Coder(
            new Nominatim( array(
                'requestURI' => 'http://nominatim.openstreetmap.org/search',
                'i118n' => 'en'
            ))
        );

        self::$result = self::$geocoder->fetchCoords(
            'Müllerstr. 40, 80469 München',
            Coder::PRECISION_HIGH
        );
    }

    public function testPrecision()
    {
        $this->assertInstanceOf( '\Geo\Coder\Plugin\Nominatim', self::$result );
        $this->assertEquals( Coder::PRECISION_HIGH, self::$result->getPrecision() );
    }

    public function testCoords()
    {
        $this->assertEquals( 48.1311855, self::$result->getLat() );
    }

    public function testAddress()
    {
        $this->assertEquals( 40, self::$result->getHouse() );
        $this->assertEquals( 'Müllerstraße', self::$result->getRoad() );
        $this->assertEquals( 'Bezirksteil Angerviertel', self::$result->getSuburb() );
        $this->assertEquals( 'Altstadt-Lehel', self::$result->getCityDistrict() );
        $this->assertEquals( 'Angerviertel', self::$result->getHamlet() );
        $this->assertEquals( 'Munich', self::$result->getCounty() );
        $this->assertEquals( 'Upper Bavaria', self::$result->getStateDistrict() );
        $this->assertEquals( 'Free State of Bavaria', self::$result->getState() );
        $this->assertEquals( '80469', self::$result->getZip() );
        $this->assertEquals( 'Germany', self::$result->getCountry() );
        $this->assertEquals( 'DE', self::$result->getCountryCode() );
        $this->assertEquals( 'European Union', self::$result->getContinent() );
    }
}
