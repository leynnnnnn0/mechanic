<div x-data="map" class="relative h-[300px] w-full" wire:ignore>
    <div class="h-full w-full" id="my-map"></div>
    <div id="distance-info" class="absolute top-2 left-2 bg-white p-3 rounded-lg shadow-md z-[1000] text-sm font-semibold"></div>
    <div id="loading-overlay" class="absolute inset-0 bg-gray-200 bg-opacity-75 flex items-center justify-center z-[2000]">
        <div class="text-center">
            <svg class="animate-spin h-10 w-10 text-blue-500 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-blue-600 font-semibold">Loading map...</span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('map', () => ({
            customerAddress: JSON.parse('<?php echo json_encode($from) ?>'),
            init() {
                Livewire.on('updateMap', () => {
                    showLoading();
                })
                Livewire.on('locationLoaded', (param) => {
                    initMap(param[0]);
                })
                initMap(this.customerAddress)
            }
        }))
    })

    let map;

    function showLoading() {
        document.getElementById('loading-overlay').style.display = 'flex';
    }

    function hideLoading() {
        document.getElementById('loading-overlay').style.display = 'none';
    }

    function initMap(customerAddress) {

        if (map) {
            map.remove();
        }
        map = L.map('my-map').setView([14.386013, 120.8802597], 13);

        const myAPIKey = "<?php echo $apiKey ?>";

        const baseUrl = `https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}.png?apiKey=${myAPIKey}`;

        L.tileLayer(baseUrl, {
            attribution: 'Powered by <a href="https://www.geoapify.com/" target="_blank">Geoapify</a> | <a href="https://openmaptiles.org/" rel="nofollow" target="_blank">© OpenMapTiles</a> <a href="https://www.openstreetmap.org/copyright" rel="nofollow" target="_blank">© OpenStreetMap</a> contributors',
            apiKey: myAPIKey,
            maxZoom: 20,
            id: 'osm-bright',
        }).addTo(map);

        const mechanicAddress = JSON.parse('<?php echo json_encode($mechanicAddress) ?>');

        const fromWaypoint = [customerAddress.latitude, customerAddress.longitude];
        const fromWaypointMarker = L.marker(fromWaypoint).addTo(map).bindPopup(customerAddress.address);

        const toWaypoint = [mechanicAddress.latitude, mechanicAddress.longitude];
        const toWaypointMarker = L.marker(toWaypoint).addTo(map).bindPopup(mechanicAddress.address);

        const turnByTurnMarkerStyle = {
            radius: 5,
            fillColor: "#fff",
            color: "#555",
            weight: 1,
            opacity: 1,
            fillOpacity: 1
        }

        fetch(`https://api.geoapify.com/v1/routing?waypoints=${fromWaypoint.join(',')}|${toWaypoint.join(',')}&mode=drive&apiKey=${myAPIKey}`)
            .then(res => res.json())
            .then(result => {
                const distance = result.features[0].properties.distance / 1000;
                const time = result.features[0].properties.time / 60; // Convert seconds to minutes

                // Display distance and time
                const distanceInfo = document.getElementById('distance-info');
                distanceInfo.innerHTML = `
            <strong>Distance:</strong> ${distance.toFixed(2)} km<br>
            <strong>Estimated Time:</strong> ${Math.round(time)} minutes
        `;

                L.geoJSON(result, {
                    style: (feature) => {
                        return {
                            color: "rgba(20, 137, 255, 0.7)",
                            weight: 5
                        };
                    }
                }).bindPopup((layer) => {
                    return `${layer.feature.properties.distance} ${layer.feature.properties.distance_units}, ${layer.feature.properties.time}`
                }).addTo(map);

                const turnByTurns = [];
                result.features.forEach(feature => feature.properties.legs.forEach((leg, legIndex) => leg.steps.forEach(step => {
                    const pointFeature = {
                        "type": "Feature",
                        "geometry": {
                            "type": "Point",
                            "coordinates": feature.geometry.coordinates[legIndex][step.from_index]
                        },
                        "properties": {
                            "instruction": step.instruction.text
                        }
                    }
                    turnByTurns.push(pointFeature);
                })));

                L.geoJSON({
                    type: "FeatureCollection",
                    features: turnByTurns
                }, {
                    pointToLayer: function(feature, latlng) {
                        return L.circleMarker(latlng, turnByTurnMarkerStyle);
                    }
                }).bindPopup((layer) => {
                    return `${layer.feature.properties.instruction}`
                }).addTo(map);

                // Fit the map to show both markers
                const group = new L.featureGroup([fromWaypointMarker, toWaypointMarker]);
                map.fitBounds(group.getBounds().pad(0.1));

                hideLoading();
            }).catch(error => {
                hideLoading();
                document.getElementById('distance-info').innerHTML = '<h1 class="text-red-500">Could not find the estimated ditance and time</h1>';
            });
    }

    initMap(JSON.parse('<?php echo json_encode($from) ?>'));
</script>