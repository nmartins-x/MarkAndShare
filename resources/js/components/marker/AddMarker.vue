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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                marker: {
                    lgt: null,
                    lat: null,
                },
                coordinates: this.$store.state.markerCoordinates
            }
        },
        
        created() {
            this.marker.listing_id = this.$route.params.id;

            if (this.marker.listing_id == undefined) {
                this.axios
                        .get(`/listing/${this.$route.params.unique_url}`)
                        .then((response) => {
                            this.marker.listing_id = response.data.id;
                        });
            }
        },
        
        methods: {
            addMarker() {
                this.axios
                        .post('/marker', this.marker)
                        .then(response => (
                                    this.$router.push({name: 'userMarker'})
                                    // console.log(response.data)
                                    ))
                        .catch(error => console.log(error))
                        .finally(() => this.loading = false)
            }
        },

    }
</script>
