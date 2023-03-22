import { createStore } from 'vuex';

const store = createStore({
    state: {
        homeNavbar: false,
        homeFooter: false,
        LoggedIn: false,
        dashboardNavbar: false,
        showSidebar: true,
        isMobile: false,
        isTablet: false,
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
        putIdUser(state, idUser) {
            sessionStorage.setItem('idUser', idUser);
        },
        putApiKey(state, token) {
            sessionStorage.setItem('API_KEY', token);
            state.LoggedIn = true;
        },
        deleteApiKey(state) {
            sessionStorage.removeItem('API_KEY');
            state.LoggedIn = false;
        },
        checkApiToken(state) {
            if (
                sessionStorage.getItem('API_KEY') !== null &&
                sessionStorage.getItem('API_KEY') !== undefined
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
store.commit('setIsTablet', window.innerWidth < 850);

window.addEventListener('resize', () => {
    store.commit('setIsMobile', window.innerWidth < 850);
    store.commit('setIsTablet', window.innerWidth < 850 && window.innerWidth > 600);
});


export default store;