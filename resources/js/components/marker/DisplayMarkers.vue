<template>
    <div class="markers-description">
        <h4>Markers</h4>
        <table class="table table-bordered" v-if="markers[0]">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="marker in markers" :key="marker.id">
                <td>
                    <router-link :to="{name: 'editMarker', params: { id: marker.id, name: marker.name, description: marker.description, listing_id: marker.listing_id }}" class="nav-item nav-link">
                    {{ marker.name }}
                    </router-link>
                <td>{{ marker.description }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>   
    export default {
        data() {
            return {
                markers: []
            }
        },
        created() {
            this.axios
                .get(`/listing/${this.$route.params.unique_url}/markers`)
                .then((response) => {
                    this.markers = [...response.data];
            
                    this.$store.commit('updateMarkers', this.markers);
                });
        },
        methods: {
        }
    }
</script>
