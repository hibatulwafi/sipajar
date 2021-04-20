<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Add multiple geometries from one GeoJSON source</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
<script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
<style>
	body { margin: 0; padding: 0; }
	#map { position: absolute; top: 0; bottom: 0; width: 100%; }
</style>
</head>
<body>
<div id="map"></div>
<script>
	mapboxgl.accessToken = 'pk.eyJ1Ijoid2FwaXB1dHJhIiwiYSI6ImNrYzM0em9zaTAwczIzM3BjemlnbXoyd3QifQ.5JkBFnavsM5KAGZvMxNDyg';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [106.92512827677746, -6.928013156983084],
        zoom: 12
    });

    map.on('load', function () {
        map.addSource('national-park', {
            'type': 'geojson',
            'data': {
                'type': 'FeatureCollection',
                'features': [
                   ,
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates':  [106.72512827677746, -6.828013156983084]
                        }
                    },
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [106.82512827677746, -6.828013156983084]
                        }
                    },
                    {
                        'type': 'Feature',
                        'geometry': {
                            'type': 'Point',
                            'coordinates': [106.72512827677746, -6.928013156983084]
                        }
                    }
                ]
            }
        });

     

        map.addLayer({
            'id': 'park-volcanoes',
            'type': 'circle',
            'source': 'national-park',
            'paint': {
                'circle-radius': 6,
                'circle-color': '#B42222'
            },
            'filter': ['==', '$type', 'Point']
        });
    });
</script>

</body>
</html>

