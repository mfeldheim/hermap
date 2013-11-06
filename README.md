mapStuff
========

stuff related to maps

Class \Map\Projection
---------------------

degreesToPixels lat/lng to pixels on a map

**Usage**

```
$mapProjection = new \Map\Projection();
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
