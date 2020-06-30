<template>
    <div>
        <h3 class="text-center">Edit Listing</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateListing">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="listing.name">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" v-model="listing.description">
                    </div>
                    <div class="form-group">
                        <label>Public listed</label>
                        <label class="switch">
                            <input type="checkbox" class="slider" v-model="listing.public_listed">
                         </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Listing</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listing: {}
            }
        },
        created() {
            this.axios
                .get(`/listing/${this.$route.params.unique_url}`)
                .then((response) => {
                    this.listing = response.data;
                });
        },
        methods: {
            updateListing() {
                this.axios
                    .put(`/listing/${this.$route.params.id}`, this.listing)
                    .then((response) => {
                        this.$router.push({name: 'home'});
                    });
            }
        }
    }
</script>
