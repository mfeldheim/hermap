<?php
/*
 *  Copyright 2013 Michel Feldheim
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

namespace Map;

class Projection
{
    public function __construct() {

    }

    public function __destruct() {

    }

    /**
     * Returns pixel coordinates for given decimal geograhpic coordinates projected to a map width and height
     *
     * @param $lat
     * @param $lng
     * @param $width
     * @param $height
     * @throws \RangeException http://www.php.net/manual/en/class.rangeexception.php
     * @return array
     */
    public function convert( $lat, $lng, $width, $height ) {

        $lat = doubleval( $lat );
        $lng = doubleval( $lng );
        $width = intval( $width );
        $height = intval( $height );

        if ( $lat < -90 or $lat > 90 ) {
            throw new \RangeException ( 'Latitude out of range (valid range: ±90°)' );
        }

        if ( $lng < -180 or $lng > 180 ) {
            throw new \RangeException ( 'Longitude out of range (valid range: ±180°)' );
        }

        if ( $width <= 0 ) {
            throw new \RangeException ( 'Width must be greater than 0' );
        }

        if ( $height <= 0 ) {
            throw new \RangeException ( 'Height must be greater than 0' );
        }

        return array(
                'x' => ($lng+180)*($width/360),
                'y' => ($height/2)-($width*log(tan((M_PI/4)+(($lat*M_PI/180)/2)))/(2*M_PI))
        );
    }
}
