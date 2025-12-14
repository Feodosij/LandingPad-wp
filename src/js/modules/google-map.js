import $ from 'jquery';

export function initGoogleMap() {
    // init async map
    window.init_map = async function($el) {
        const $markers = $el.find('.marker');
        const { Map } = await google.maps.importLibrary("maps");
        const { Marker } = await google.maps.importLibrary("marker"); 

        const args = {
            zoom: 16,
            center: { lat: 0, lng: 0 }, 
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true,
            mapTypeControl: true,
            streetViewControl: false,
            fullscreenControl: false,

            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.BOTTOM_LEFT
            },
        };

        const map = new Map($el[0], args);
        map.markers = [];

        $markers.each(function() {
            add_marker($(this), map, Marker);
        });

        center_map(map);
        return map;
    };

    // add marker adress on map
    function add_marker($marker, map, MarkerClass) {
        const lat = parseFloat($marker.attr('data-lat') || $marker.data('lat'));
        const lng = parseFloat($marker.attr('data-lng') || $marker.data('lng'));
        
        if (!lat || !lng) return;

        const latlng = { lat: lat, lng: lng };

        const marker = new (MarkerClass || google.maps.Marker)({
            position: latlng,
            map: map,
            title: $marker.data('title')
        });

        map.markers.push(marker);

        let content = $marker.html();
        
        const addressText = $marker.attr('data-address') || $marker.data('address');
        
        if (addressText) {
            content = '<div class="map-infowindow">' + addressText + '</div>';
        }

        if (content) {
            const infowindow = new google.maps.InfoWindow({
                content: content
            });

            infowindow.open(map, marker);

            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });
        }
    }

    // centered marker on map
    function center_map(map) {
        const bounds = new google.maps.LatLngBounds();

        $.each(map.markers, function(i, marker) {
            const pos = marker.getPosition(); 
            
            bounds.extend(pos);
        });

        if (map.markers.length == 1) {
            map.setCenter(bounds.getCenter());
            map.setZoom(15);
        } else {
            map.fitBounds(bounds);
        }
    }

    // callback for render google map 
    window.acf_init_maps = function() {
        $('.acf-map').each(function() {
            window.init_map($(this));
        });
    };

    window.acf_init_maps_callback = function() {
        window.acf_init_maps();
    };
}
