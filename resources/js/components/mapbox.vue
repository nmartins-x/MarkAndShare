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
            <p>Hello world!</p>
          </template>
        </mapbox-marker>
    </mapbox-map>
</template>

<script>
    export default {
        data() {
            return {
                markers : [
                    {
                      id: 1,
                      gpsCoords: [0,0],
                      draggable: false
                    }
                ],
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
            updateGpsCoordinates (id, event) {
                // get new coordinates
                let newCoords = event.target._lngLat;

                // sets the GPS coords
                this.markers[id].gpsCoords = [newCoords.lng, newCoords.lat];
                
                // centers the map on marker position
                this.center = this.markers[id].gpsCoords;
                
                this.$store.commit('updateCoordinates', {
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
            
            markerDraggableStatus() {
                this.markers[0].draggable = this.$store.state.editedMarker.draggable;
          }
        },
                
        watch: {
            // control when to set a marker as draggable
            $route (to, from){
                let drag_value = false;
                
                if (['addMarker', 'editMarker'].indexOf(to.name) >= 0){
                    drag_value = true;
                }
                
                this.$store.commit('setMarkerAsDraggable', drag_value);
            },
    
            markerDraggableStatus() {
                // nothing to do, just watch this function on 'computed'
            },
        },
        
        beforeMount(){
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