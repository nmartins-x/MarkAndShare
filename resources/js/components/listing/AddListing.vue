<template>
    <div>
        <h3 class="text-center">Add Listing</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="addListing">
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
                    
                    <button type="submit" class="btn btn-primary">Add Listing</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listing: {
                    public_listed: true
                }
            }
        },
        methods: {
            addListing() {
                this.axios
                    .post('/listing', this.listing)
                    .then(response => (
                        this.$router.push({name: 'userListings'})
                        // console.log(response.data)
                    ))
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>
