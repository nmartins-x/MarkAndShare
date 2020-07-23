<template>
    <div>
        <h3 class="text-center">Edit Marker</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateMarker">
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
                    
                    <button type="submit" class="btn btn-primary">Update Marker</button>
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
                    lgt: null,
                    lat: null,
                    listing_id: undefined
                },
                errors: {}
            }
        },
        
        created() {
            this.marker.listing_id = this.$route.params.listing_id;

            if (this.marker.listing_id === undefined) {
                this.axios
                        .get(`/listing/${this.$route.params.unique_url}`)
                        .then((response) => {
                            this.marker.listing_id = response.data.id;
                        });
            }
            
            if (this.marker.name === undefined) {
                this.axios
                    .get(`/listing/${this.$route.params.unique_url}/markers`)
                    .then((response) => {
                        let marker_id = parseInt(this.$route.params.id);

                        for (let marker of response.data) {
                            if (marker.id === marker_id) {
                                this.marker = marker;
                            }
                        }
                    });
            }
                            
            this.$store.commit('setMarkerAsDraggable', true);
        },
        
        methods: {
            updateMarker() {
                this.axios
                    .put(`/marker/${this.$route.params.id}`, this.marker)
                    .then((response) => {
                        this.$router.push({name: 'home'});
                    });
            }
        },
        
        computed: {
          markerState() {
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
    }
</script>
