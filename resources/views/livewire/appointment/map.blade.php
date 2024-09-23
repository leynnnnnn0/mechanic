<div x-data="map" class="h-[300px] w-full" wire:ignore>
    <div class="h-full w-full" id="my-map">

    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('map', () => ({
            customerAddress: JSON.parse('<?php echo json_encode($from) ?>'),
            init() {
                Livewire.on('updateMap', (param) => {
                    this.customerAddress = param[0];
                    initMap(this.customerAddress);
                })
                initMap(this.customerAddress)
            }
        }))
    })

    let map;

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


        fetch(`https://api.geoapify.com/v1/routing?waypoints=${fromWaypoint.join(',')}|${toWaypoint.join(',')}&mode=drive&apiKey=${myAPIKey}`).then(res => res.json()).then(result => {

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

        }, error => console.log(err));
    }
</script>