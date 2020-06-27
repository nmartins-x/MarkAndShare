import PublicListings from './components/PublicListings.vue';
import UserListings from './components/UserListings.vue';
import AddListing from './components/AddListing.vue';
import EditListing from './components/EditListing.vue';
import ViewListing from './components/ViewListing.vue';

export const routes = [
    {
        name: 'home',
        path: '/home',
        component: PublicListings
    },
    {
        name: 'add',
        path: '/add',
        component: AddListing
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditListing
    },
    {
        name: 'view',
        path: '/l/:unique_url',
        component: ViewListing
    },
    {
        name: 'userListings',
        path: '/MyListings',
        component: UserListings
    },
];