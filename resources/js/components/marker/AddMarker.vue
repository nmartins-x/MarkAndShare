<template>
    <div>
        <h3 class="text-center">Add Marker</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addMarker">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="marker.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="marker.description">
                    </div>

                    <span>Longitude: {{ marker.lgt }}</span>

                    <span>Latitude: {{ marker.lat }}</span>

                    <button type="submit" class="btn btn-primary">Add Marker</button>
                </form>
            </div>
        </div>
        <errors-list :errors="errors"></errors-list>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                marker: {
                    lgt: 1,
                    lat: 1,
                    draggable: true,
                    listing_id: undefined
                },
                errors: {}
            }
        },
        
        created() {
            this.marker.listing_id = this.$route.params.id;

            if (this.marker.listing_id === undefined) {
                this.axios
                        .get(`/listing/${this.$route.params.unique_url}`)
                        .then((response) => {
                            this.marker.listing_id = response.data.id;
                        });
            }
            
            // create temporary visible marker
            this.$store.commit('updateMarkers', [
                this.marker
            ]);
            
            // Update marker position on the map
            this.$store.commit('updateEditedMarkerCoordinates', {
                                    lgt: (this.marker.lgt),
                                    lat: (this.marker.lat)
                                });
            
            this.$store.commit('setMarkerAsDraggable', true);
        },
        
        methods: {
            addMarker() {
                this.axios
                        .post('/marker', this.marker)
                        .then(response => (
                                    this.$router.push({name: 'editListing'})
                                    // console.log(response.data)
                                    ))
                        .catch(error => {
                            this.errors = error.response.data.errors;
                        })
                        .finally(() => this.loading = false)
            }
        },
        
        computed: {
          markerState() {
            if (this.marker.listing_id === undefined) return;
            
            this.marker.lgt = this.$store.state.editedMarker.lgt;
            this.marker.lat = this.$store.state.editedMarker.lat;
          }
        },
        
        watch: {
          markerState() {
              // nothing to do, just watch this function on 'computed'
          }
        },
        
        components: {
            'errors-list': require('../utils/Errors.vue').default,
        },
    };
</script>
