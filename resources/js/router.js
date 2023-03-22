import { createRouter, createWebHistory } from 'vue-router';
import homeIndex from './home/views/index.vue';
import homeAbout from './home/views/about.vue';
import homeLogin from './home/views/login.vue';
import homeRegister from './home/views/register.vue';
import homeApp from './home/app.vue';

import dashboardProfile from './dashboard/views/profile.vue';
import dashboardIndex from './dashboard/views/index.vue';
import dashboardMakePost from './dashboard/views/makePost.vue';
import dashboardMakePost2 from './dashboard/views/makePost2.vue'
import dashboardApp from './dashboard/app.vue';

import store from './store';
import swal from 'sweetalert';

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
                path: 'makePost2',
                component: dashboardMakePost2,
                name: 'dashboardMakePost2',
                meta: { requiresAuth: true, dashboardNavbar: true, },
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