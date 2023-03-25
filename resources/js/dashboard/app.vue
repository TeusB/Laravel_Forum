

<template>
    <div class="keeper proAni">
        <transition name="nestedLeft" mode="out-in">
            <sidebar class="innerLeft leftSide" v-bind:class="{
                'width0': !showSidebar,
                'absolute': isMobile,
                'col-2': showSidebar && !isMobile,
                'col-8': showSidebar && isMobile && !isTablet,
                'col-4': showSidebar && isMobile && isTablet,
            }"></sidebar>
        </transition>
        <div class="rightSide" v-bind:class="{ 'col-12': !showSidebar || isMobile, 'col-10': showSidebar && !isMobile }">
            <div v-if="showSidebar && isMobile" class="blackTrans" v-on:click="toggleActive"></div>
            <transition name="nestedTop" mode="out-in">
                <navbar class="innerTop rightAlign col-12" v-bind:class="{ 'col-4': showSidebar && isMobile }"></navbar>
            </transition>
            <div class="scrollContent innerRight">
                <div class="container-fluid">
                    <router-view v-slot="{ Component }">
                        <transition name="nested" mode="out-in">
                            <div v-if="isLoading" class="spinnerContainer d-flex align-items-center justify-content-center">
                                <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                            <component :is="Component" v-else></component>
                        </transition>
                    </router-view>
                </div>
                <footerVue class="innerBottom"></footerVue>
            </div>

        </div>
    </div>
</template>
  
<script>
import { mapState } from 'vuex';
import store from '../store.js';
import axios from '../axios';
import sidebar from './components/sidebar.vue';
import footerVue from './components/footer.vue';
import navbar from './components/navbar.vue';
export default {
    name: 'App',
    components: {
        sidebar,
        footerVue,
        navbar,
    },
    data() {
        return {
            isLoading: false,
            Component: null,
        };
    },
    methods: {
        toggleActive() {
            store.commit('toggleSidebar');
        },
        toggleActiveIfSide() {
            if (this.showSidebar && this.isMobile) {
                store.commit('toggleSidebar');
            }
        },
    },
    computed: {
        ...mapState({
            dashboardNavbar: (state) => state.dashboardNavbar,
            showSidebar: (state) => state.showSidebar,
            isMobile: (state) => state.isMobile,
            isTablet: (state) => state.isTablet,
            user: (state) => state.user,
        }),

    },
    created() {
        if (!this.isMobile) {
            store.commit('toggleSidebar');
        }
        axios.get('user', {
            headers: {
                Authorization: `Bearer ${sessionStorage.getItem('API_KEY')}`
            }
        })
            .then(response => {
                store.commit('putUser', response.data.user);
            })
            .catch(error => {
                console.log(error);
            });
    },
    beforeRouteUpdate(to, from, next) {
        this.isLoading = true;
        next();
        setTimeout(() => {
            this.isLoading = false
        }, 1000)
    },
    mounted() {
        // this.isLoading = true;

        // setTimeout(() => {
        //     this.isLoading = false
        // }, 1000)
    },
};
</script>
  
<style>
.keeper {
    display: flex;
}

.innerRightContainer {
    height: 100%;
}

.spinnerContainer {
    height: 90%;
    width: 100%;
}

.blackTrans {
    background-color: rgb(0 0 0 / 37%);
    height: 100vh;
    width: 100%;
    position: absolute;
    z-index: 2;
}

.rightAlign {
    margin-left: auto;
    margin-right: 0;
}

.absolute {
    position: absolute;
}

.rightSide {
    display: flex;
    flex-direction: column;
    transition: width 0.3s ease-in-out;
    height: 100vh;
}

.leftSide {
    background-color: antiquewhite;
    height: 100vh;
    transition: width 0.3s ease-in-out;
    overflow-y: auto;
    overflow-x: hidden;
    z-index: 3;
}

.width0 {
    width: 0%;

}
</style>