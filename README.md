Hermap libraries
========

stuff related to maps

Class \Geo\Coder
---------------------

Client to receive coordinates from a webservice.
Plugins implemented:
- Y!Boss (Yahoo)
- Nominatim (OSM)

**Usage**

```
use Geo\Coder\Plugin;

$geocoder = new \Geo\Coder(
    new Nominatim( array(
        'requestURI' => 'http://nominatim.openstreetmap.org/search',
        'i118n' => 'en'
    ))
);

$result = self::$geocoder->fetchCoords(
   'Muellerstr. 40, 80469 München',
        Coder::PRECISION_HIGH
    );

$result->getLat();
$result->getLon();
// etc.
```


Class \Geo\Projection
---------------------

degreesToPixels lat/lng to pixels on a map

**Usage**

```
$mapProjection = new \Geo\Projection();
$pixelCoordinates = $mapProjection->degreesToPixels( $latitude, $longitude, $mapWidth, $mapHeight );
```

Example file examples/drawPointsOnMap.php
-----------------------------------------

```
# composer install
php drawPointsOnMap.php
```

**requires**

- php >= 5.3.2
- php-gd (optionally compiled with freetype support)
