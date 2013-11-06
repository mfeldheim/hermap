mapStuff
========

stuff related to maps

Class \Map\Projection
---------------------

convert lat/lng to pixels on a map

**Usage**

```
$mapProjection = new \Map\Projection();
$pixelCoordinates = $mapProjection->convert( $latitude, $longitude, $mapWidth, $mapHeight );
```

Example file tests/drawPointsOnMap.php requires

- php-gd
- php-image-text
