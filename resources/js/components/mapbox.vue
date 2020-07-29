<template>
    <mapbox-map
        :style="{ height: computedHeight }"
        :access-token="token"
        map-style="mapbox://styles/mapbox/streets-v11"
        :center="center"
        :zoom="1" 
        @mb-created="(mapboxInstance) => map = mapboxInstance">
        <mapbox-marker v-for="(marker, index) in markers" :key="marker.id" :lng-lat="marker.gpsCoords" :gpsCoords="marker.gpsCoords" popup :draggable="marker.draggable" @mb-dragend="updateGpsCoordinates(index, $event)">
            <template v-slot:popup>
                <p class="marker-name">{{ marker.name }}</p>
                <p>{{ marker.description }}</p>
            </template>
        </mapbox-marker>
    </mapbox-map>
</template>

<script>
    export default {
        data() {
            return {
                markers: [],
                map: null,
                height: '800px',
                center: [0, 0],
                token: process.env.MIX_MAPBOX_TOKEN, // mapbox.com token
            };
        },

        methods: {
            // Stretch and resize map to viewport size
            resizeMap() {
                // nav bar height
                let element = document.querySelector('nav');
                let elementH = getComputedStyle(element).height;

                // remove everything after dot and/or any non numeric characters
                let navHeight = elementH.split('.')[0].replace(/\D/g, "");

                // window height
                let wH = window.innerHeight;

                this.height = (wH - navHeight) + "px";
            },

            // Update the coordinates of the GPS based on marker position after dragend event
            updateGpsCoordinates(id, event) {
                // get new coordinates
                let newCoords = event.target._lngLat;

                // sets the GPS coords
                this.markers[id].gpsCoords = [newCoords.lng, newCoords.lat];

                // centers the map on marker position
                this.center = this.markers[id].gpsCoords;

                this.$store.commit('updateEditedMarkerCoordinates', {
                    lgt: (newCoords.lng).toFixed(8),
                    lat: (newCoords.lat).toFixed(8),
                    id: id
                });
            },
        },

        computed: {
            computedHeight: function () {
                return this.height;
            },

            // retrieve markers from store that should be visible on the map
            visibleMarkers() {
                let tempArray = [];

                for (let marker of this.$store.state.visibleMarkers)
                {
                    tempArray.push({
                        id: marker.id,
                        name: marker.name,
                        description: marker.description,
                        gpsCoords: [marker.lgt, marker.lat],
                        draggable: marker.draggable === undefined ? false : marker.draggable, 
                    });
                }

                this.markers = [...tempArray];
            },
        },

        watch: {
            // control when to set a marker as draggable
            $route(to, from) {
                // allow draggable marker on specific pages only
                var edit_marker = ['editMarker'].indexOf(to.name) >= 0;
                var add_marker = ['addMarker'].indexOf(to.name) >= 0;
                
                this.markers.forEach((item, index) => {
                    if (edit_marker && item.id === to.params.id) {
                        item.draggable = true;

                        // centers the map on edited marker position
                        this.center = item.gpsCoords;
                    } else if(add_marker){
                        this.center = [1,1];
                    } else {
                        item.draggable = false;
                    }
                });
            },

            visibleMarkers() {
                // nothing to do, just watch this function on 'computed'
            },
        },

        beforeMount() {
            this.resizeMap();
        },

        mounted() {
            window.addEventListener("resize", this.resizeMap);
        },

        destroyed() {
            window.removeEventListener("resize", this.resizeMap);
        },

    };
</script>