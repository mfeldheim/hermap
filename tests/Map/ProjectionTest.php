<?php
/**
 * Created by PhpStorm.
 * User: Michel Feldheim
 * Date: 06.11.13
 * Time: 13:32
 */

namespace Map;

class ProjectionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Projection
     */
    protected static $projection;

    public static function setUpBeforeClass() {
        self::$projection = new Projection();
    }

    public static function degreesToPixelRangeExceptionProvider() {
        return array (
            'less_or_equal_zero'    => array( 0,0,0,0 ),
            'lat_out_of_range_min'  => array( -120,-180,5,20),
            'lat_out_of_range_max'  => array( 120,180,20,5),
            'lng_out_of_range_min'  => array( 89,-190,20,5),
            'lng_out_of_range_max'  => array( 89,190,20,5)
        );
    }

    public static function pixelToDegreesRangeExceptionProvider() {
        return array (
            'less_or_equal_zero'    => array( 0,0,0,0 ),
            'pixelx_less_than_zero' => array( -10,5,10,20 ),
            'pixely_less_than_zero' => array( 10,-10,10,20 ),
            'pixelx_greater_width'  => array( 10,10,5,20),
            'pixely_greater_height' => array( 10,10,20,5)
        );
    }

    public static function coordsProvider() {
        return array
        (
            'Santiago, CL'          => array( -33.469120, -70.641997 ),
            'New York, US'          => array( 40.714353, -74.005973 ),
            'Ottawa, CA'            => array( 45.421530, -75.697193 ),
            'Bejing, ZH'            => array( 39.904030, 116.407526 ),
            'Wellington, NZ'        => array( -41.286460, 174.776236),
            'Berlin, DE'            => array( 52.519171, 13.406091 ),
            'Anchorage, AK'         => array( 61.218056, -149.900278 ),
            'Bergen, NO'            => array( 60.391263, 5.322054 ),
            'Reykjavik, IS'         => array( 64.135338, -21.895210 ),
            'Nordvik, RU'           => array( 74.018100, 111.469000),
            'Rio d Janeiro, BR'     => array( -22.903539, -43.209587 ),
            'Cape Town, ZA'         => array( -33.924869, 18.424055 ),
            'Brrrr, cold'           => array( -82.494824, -52.910156 )
        );
    }

    /**
     * @dataProvider degreesToPixelRangeExceptionProvider
     * @expectedException \RangeException
     */
    public function testDegreesToPixelsRangeException( $lng, $lat, $width, $height ) {
        self::$projection->degreesToPixels( $lng, $lat, $width, $height );
    }

    /**
     * @dataProvider pixelToDegreesRangeExceptionProvider
     * @expectedException \RangeException
     */
    public function testPixelsToDegreesRangeException( $pixelX, $pixelY, $width, $height ) {
        self::$projection->pixelsToDegrees( $pixelX, $pixelY, $width, $height );
    }
}
