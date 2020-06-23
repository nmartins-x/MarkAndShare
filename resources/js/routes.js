import AllListings from './components/AllListings.vue';
import AddListing from './components/AddListing.vue';
import EditListing from './components/EditListing.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllListings
    },
    {
        name: 'add',
        path: '/vue/add',
        component: AddListing
    },
    {
        name: 'edit',
        path: '/vue/edit/:id',
        component: EditListing
    }
];