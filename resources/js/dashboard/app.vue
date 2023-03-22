<template>
    <div class="keeper proAni">
        <transition name="nestedLeft" mode="out-in">
            <sidebar class="innerLeft leftSide"
                v-bind:class="{ 'width0': !showSidebar, 'absolute': isMobile, 'col-2': showSidebar && !isMobile, 'col-8': showSidebar && isMobile && !isTablet, 'col-4': showSidebar && isMobile && isTablet, }">
            </sidebar>
        </transition>
        <div class="rightSide" v-bind:class="{ 'col-12': !showSidebar || isMobile, 'col-10': showSidebar && !isMobile }">
            <transition name="nestedTop" mode="out-in">
                <navbar class="innerTop rightAlign col-12" v-bind:class="{ 'col-4': showSidebar && isMobile, }"></navbar>
            </transition>
            <div v-on:click="toggleActiveIfSide" class="scrollContent innerRight"
                v-bind:class="{ 'fague': showSidebar && isMobile }">
                <div class="container-fluid">
                    <router-view v-slot="{ Component }">
                        <transition name="nested" mode="out-in">
                            <component :is="Component" />
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
import store from '../store.js'

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
            dashboardNavbar: state => state.dashboardNavbar,
            showSidebar: state => state.showSidebar,
            isMobile: state => state.isMobile,
            isTablet: state => state.isTablet,
        }),
    },
};
</script>
  
<style>
.keeper {
    display: flex;
}

.rightAlign {
    margin-left: auto;
    margin-right: 0;
}

.absolute {
    position: absolute;
}

.fague {
    background: rgba(0, 0, 0, 0.6);
    opacity: 1;
    transition: opacity 0.5s;
    -webkit-transition: opacity 0.5s;
    -moz-transition: opacity 0.5s;


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
    z-index: 1;
}

.width0 {
    width: 0%;

}
</style>