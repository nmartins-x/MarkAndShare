import PublicListings from './components/listing/PublicListings.vue';
import UserListings from './components/listing/UserListings.vue';
import AddListing from './components/listing/AddListing.vue';
import EditListing from './components/listing/EditListing.vue';
import ViewListing from './components/listing/ViewListing.vue';
import EditMarker from './components/marker/EditMarker.vue';
import AddMarker from './components/marker/AddMarker.vue';

export const routes = [
    {
        name: 'home',
        path: '/home',
        component: PublicListings
    },
    {
        name: 'addListing',
        path: '/add',
        component: AddListing
    },
    {
        name: 'editListing',
        path: '/edit/:unique_url',
        component: EditListing
    },
    {
        name: 'viewListing',
        path: '/l/:unique_url',
        component: ViewListing
    },
    {
        name: 'userListings',
        path: '/MyListings',
        component: UserListings
    },
    {
        name: 'addMarker',
        path: '/l/:unique_url/addmarker',
        component: AddMarker
    },
    {
        name: 'editMarker',
        path: '/l/:unique_url/editmarker',
        component: EditMarker
    },
    
];