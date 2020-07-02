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
                    
                    <button type="submit" class="btn btn-primary">Update Marker</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                marker: {}
            }
        },
        created() {
            // ES6 way to copy object
            this.marker = {...this.$route.params};
        },
        methods: {
            updateMarker() {
                this.axios
                    .put(`/marker/${this.$route.params.id}`, this.marker)
                    .then((response) => {
                        this.$router.push({name: 'home'});
                    });
            }
        }
    }
</script>
