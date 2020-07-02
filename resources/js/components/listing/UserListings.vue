<template>
    <div>
        <h3 class="text-center">Public Listings</h3><br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Updated At</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="listing in listings" :key="listing.id">
                <td>{{ listing.name }}</td>
                <td>{{ listing.description }}</td>
                <td>{{ listing.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'editListing', params: { id: listing.id, public_listed: listing.public_listed, unique_url: listing.unique_url }}" class="btn btn-primary">Edit
                        </router-link>
                        <button class="btn btn-danger" @click="deleteListing(listing.id)">Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                listings: []
            }
        },
        created() {
            this.axios
                .get('/listing/user_owned')
                .then(response => {
                    this.listings = response.data;
                });
        },
        methods: {
            deleteListing(id) {
                this.axios
                    .delete(`/listing/${id}`)
                    .then(response => {
                        let i = this.listings.map(item => item.id).indexOf(id); // find index of your object
                        this.listings.splice(i, 1);
                    });
            }
        }
    }
</script>
