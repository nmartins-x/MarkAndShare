<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <br>
            <span class="text-secondary">Mark & Share</span>
        </div>

        <nav v-if="$store.state.userAuthenticated" class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link :to="{name: 'home'}" class="nav-item nav-link">Home</router-link>
                    <router-link :to="{name: 'add'}" class="nav-item nav-link">Add Listing</router-link>
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
            this.$store.commit('checkAndUpdate');
        }
    }
</script>