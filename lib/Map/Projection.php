<?php
/**
 * Created by PhpStorm.
 * User: Michel Feldheim
 * Date: 05.11.13
 * Time: 17:16
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
