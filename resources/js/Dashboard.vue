<template>
    <div class="container">
        <nav v-if="$store.state.userAuthenticated" class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link :to="{name: 'home'}" class="nav-item nav-link">Home</router-link>
                    <router-link :to="{name: 'addListing'}" class="nav-item nav-link">Add Listing</router-link>
                    <router-link :to="{name: 'userListings'}" class="nav-item nav-link">My Listings</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        created() {
            this.$store.commit('checkAuthAndUpdate');
            this.$store.commit('checkUserId');
        },
    }
</script>