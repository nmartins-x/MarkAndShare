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
                <td>
                    <router-link :to="{ name: 'view', params: { unique_url: listing.unique_url }}" class="nav-item nav-link">
                        {{ listing.name }}
                    </router-link></td>
                <td>{{ listing.description }}</td>
                <td>{{ listing.updated_at }}</td>
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
                .get('/listing')
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
