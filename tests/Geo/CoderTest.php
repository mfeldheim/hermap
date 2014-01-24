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

use Geo\Coder\Plugin\Mock;

class CoderTest extends \PHPUnit_Framework_TestCase
{
    public function testCyclePlugin()
    {
        $geocoder = new Coder(array(
            new Mock( array( 'name' => 'resolution didnt work', 'retval' => false ) ),
            new Mock( array( 'name' => 'resolution worked', 'retval' => true ) ) )
        );

        $result = $geocoder->fetchCoords(
            'Müllerstr. 40, 80469 München',
            Coder::PRECISION_HIGH
        );

        $this->assertInstanceOf( '\Geo\Coder\PluginInterface', $result );
        $this->assertEquals( 'resolution worked', $result->getClass() );
        $this->assertEquals( Coder::PRECISION_HIGH, $result->getPrecision() );
    }
}
