<?php
function __autoload($className)
{
    preg_match('/(:?\\\)?(?P<namespace>.+\\\)?(?P<class>[^\\\]+$)/', $className, $matches);
    $class     = (isset($matches['class'])) ? $matches['class'] : '';
    $namespace = (isset($matches['namespace'])) ? str_replace( '\\', '/', $matches['namespace'] ) : '';
    return (bool)(include "../lib/{$namespace}{$class}.php");
}

$mapProjection = new \Map\Projection();

$mapWidth   = 2400;
$mapHeight  = 2400;
$mapFile = '../resources/Normal_Mercator_map_85deg.jpg';

$coords = array
(
    'Santiago, CL'      => array( -33.469120, -70.641997 ),
    'New York, US'      => array( 40.714353, -74.005973 ),
    'Ottawa, CA'        => array( 45.421530, -75.697193 ),
    'Bejing, ZH'        => array( 39.904030, 116.407526 ),
    'Wellington, NZ'    => array( -41.286460, 174.776236),
    'Berlin, DE'        => array( 52.519171, 13.406091 ),
    'Anchorage, AK'     => array( 61.218056, -149.900278 ),
    'Bergen, NO'        => array( 60.391263, 5.322054 ),
    'Reykjavik, IS'     => array( 64.135338, -21.895210 ),
    'Nordvik, RU'       => array( 74.018100, 111.469000),
    'Rio d Janeiro, BR' => array( -22.903539, -43.209587 ),
    'Cape Town, ZA'     => array( -33.924869, 18.424055 ),
    'Brrrr, cold'       => array( -82.494824, -52.910156 )

);

$image = imagecreatefromjpeg( $mapFile );
$red = imagecolorallocate( $image, 255, 0, 0 );
$white = imagecolorallocate( $image, 255, 255, 255 );

foreach( $coords as $city => $coord )
{
    $res = $mapProjection->convert( $coord[0], $coord[1], $mapWidth, $mapHeight );
    imagefilledellipse( $image, $res['x'], $res['y'], 10, 10, $red );
    imagefttext( $image, 20, 0, $res['x']+15,$res['y'], $white, '../resources/FineAgain.ttf', $city );
}


if ( PHP_SAPI !== 'cli' ) {
    header( 'Content-Type: image/png' );
    imagepng( $image );
} else {
    $outfile = '../resources/result_' . time() . '.png';
    imagepng( $image, $outfile );
    echo "file saved to {$outfile}\n";
}
