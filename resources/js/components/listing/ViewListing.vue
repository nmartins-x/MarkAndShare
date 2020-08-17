<template>
    <div>
        <div class="listing-description">
            <h3 class="text-left">{{ listing.name }}</h3>
            <span class="text-center">{{ listing.description }}</span>
            <div>
                <router-link v-if="$store.state.userId == listing.user_id" 
                             :to="{name: 'editListing', params: { id: listing.id, public_listed: listing.public_listed, unique_url: listing.unique_url }}" 
                             class="btn btn-primary">Edit
                </router-link>
            </div>
        </div>
        <view-markers></view-markers>
        <ShareNetwork
            v-if="listing.public_listed"
            
            network="twitter"
            :url="url"
            :title="listing.name"
            :description="listing.description"
            hashtags="MarkAndShare">
            <button>Share on Twitter!</button>
        </ShareNetwork>
    </div>
</template>

<script>
    import displayMarkers from '../marker/DisplayMarkers.vue';
    
    export default {
        data() {
            return {
                listing: {
                    name: ""
                },
                url: window.location.href
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
            
        },
        components: {
            'view-markers': displayMarkers
        }
    }
</script>
