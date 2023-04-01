import { createRouter, createWebHistory } from 'vue-router';
import homeIndex from './home/views/index.vue';
import homeAbout from './home/views/about.vue';
import homeLogin from './home/views/login.vue';
import homeRegister from './home/views/register.vue';
import homeCv from './home/views/cv.vue';

import homeApp from './home/app.vue';

import dashboardMakePost from './dashboard/views/makePost.vue';
import dashboardPost from './dashboard/views/post.vue'
import dashBoardUpdatePost from './dashboard/views/updatePost.vue'
const dashboardIndex = () => import('./dashboard/views/index.vue');
const dashboardProfile = () => import('./dashboard/views/profile.vue')



import dashboardApp from './dashboard/app.vue';

import store from './store';
import swal from 'sweetalert';
import axios from './axios';


const belongsTo = (to, from, next) => {
    let owner = to.meta.requiresOwnership
    axios.get(owner + '/' + to.params.id, {
        headers: {
            Authorization: `Bearer ${sessionStorage.getItem('API_TOKEN')}`
        }
    }).then(response => {
        to.params[owner] = response.data;
        next();
    })
};

const routes = [
    {
        path: '/',
        name: 'homeApp',
        component: homeApp,
        children: [
            {
                path: '',
                component: homeIndex,
                name: 'homeIndex',
                meta: { homeNavbar: true, homeFooter: true }
            },
            {
                path: '/about',
                component: homeAbout,
                name: 'homeAbout',
                meta: { homeNavbar: true, homeFooter: true }
            },
            {
                path: '/login',
                component: homeLogin,
                name: 'homeLogin',
                meta: { homeNavbar: true }
            },
            {
                path: '/register',
                component: homeRegister,
                name: 'homeRegister',
                meta: { homeNavbar: true }
            },
            {
                path: '/cv',
                component: homeCv,
                name: 'homeCv',
                meta: {}
            }
        ]
    },
    {
        path: '/dashboard',
        name: 'homeDashboard',
        component: dashboardApp,
        children: [
            {
                path: '',
                component: dashboardIndex,
                name: 'dashboardIndex',
                meta: { requiresAuth: true, dashboardNavbar: true, }
            },
            {
                path: 'makePost',
                component: dashboardMakePost,
                name: 'dashboardMakePost',
                meta: { requiresAuth: true, dashboardNavbar: true, }
            },
            {
                path: 'profile',
                component: dashboardProfile,
                name: 'dashboardProfile'
            },
            {
                path: 'post/:id',
                component: dashboardPost,
                name: 'dashboardPost',
                meta: { requiresAuth: true, dashboardNavbar: true, },
            },
            {
                path: 'updatePost/:id',
                component: dashBoardUpdatePost,
                name: 'dashboardUpdatePost',
                meta: {
                    requiresAuth: true, dashboardNavbar: true, //requiresOwnership: 'post'
                },
                props: true,
                // beforeEnter: belongsTo,
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const matchedRecords = to.matched;
    store.commit('toggleHomeNavbar', matchedRecords.some(record => record.meta.homeNavbar));
    store.commit('toggleDashboardNavbar', matchedRecords.some(record => record.meta.dashboardNavbar));
    store.commit('toggleHomeFooter', matchedRecords.some(record => record.meta.homeFooter));
    if (matchedRecords.some(record => record.meta.requiresAuth) && !store.state.LoggedIn) {
        next('/login');
        swal({
            title: "Alert",
            text: "You are not signed in",
            icon: "warning",
        });
        return;
    }

    next();
});

export { router };