import { createStore } from 'vuex';

const store = createStore({
    state: {
        homeNavbar: false,
        homeFooter: false,
        LoggedIn: false,
        dashboardNavbar: false,
        showSidebar: false,
        isMobile: false,
        isTablet: false,
        user: [],
    },
    mutations: {
        toggleHomeNavbar(state, bool) {
            state.homeNavbar = bool;
        },
        toggleHomeFooter(state, bool) {
            state.homeFooter = bool;
        },
        toggleSidebar(state) {
            state.showSidebar = !state.showSidebar;
        },
        toggleDashboardNavbar(state, bool) {
            state.dashboardNavbar = bool;
        },
        putUser(state, user) {
            state.user = user;
        },
        updateUserProperty(state, payload) {
            state.user = {
                ...state.user,
                ...payload
            }
        },
        login(state, token) {
            sessionStorage.setItem('API_TOKEN', token);
            state.LoggedIn = true;
        },
        logout(state) {
            sessionStorage.removeItem('API_TOKEN');
            state.user = [];
            state.LoggedIn = false;
        },
        checkApiToken(state) {
            if (
                sessionStorage.getItem('API_TOKEN') !== null &&
                sessionStorage.getItem('API_TOKEN') !== undefined
            ) {
                state.LoggedIn = true;
            } else {
                state.LoggedIn = false;
            }
        },
        setIsMobile(state, bool) {
            state.isMobile = bool;
        },
        setIsTablet(state, bool) {
            state.isTablet = bool;
        },
    },
});

store.commit('checkApiToken');
store.commit('setIsMobile', window.innerWidth < 850);
store.commit('setIsTablet', window.innerWidth < 850 && window.innerWidth > 600);

window.addEventListener('resize', () => {
    store.commit('setIsMobile', window.innerWidth < 850);
    store.commit('setIsTablet', window.innerWidth < 850 && window.innerWidth > 600);
});


export default store;