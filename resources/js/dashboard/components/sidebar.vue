<template>
    <div class="d-flex flex-column">
        <div class="d-flex topSideContainer">
            <RouterLink v-bind:class="{ 'col-8': isMobile, 'col-12': !isMobile }"
                class="topSideContainer d-flex align-items-center justify-content-center" :to="{ name: 'dashboardIndex' }">
                <div>Logo</div>
            </RouterLink>
            <div v-if="isMobile" class="col-4 d-flex justify-content-center mt-2" v-on:click="toggleActive">X</div>
        </div>
        <div class="nav nav-pills flex-column mb-auto p-3">
            <div class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'dashboardIndex' }" v-on:click="toggleActive"
                    exact-active-class="active" active-class="active">
                    <!-- <svg class="bi bi-house" width="16" height="16">
                    </svg> -->
                    home
                </RouterLink>
            </div>
            <div class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'dashboardMakePost' }" v-on:click="toggleActive"
                    exact-active-class="active" active-class="active">
                    add post
                </RouterLink>
            </div>
            <!-- <div class="nav-item">
                <RouterLink class="nav-link" :to="{ name: 'dashboardMakePost2' }" v-on:click="toggleActive"
                    exact-active-class="active" active-class="active">
                    post2
                </RouterLink>
            </div> -->

        </div>

    </div>
</template>
  
<script>
import store from '../../store.js'
import { mapState } from 'vuex';


export default {
    computed: {
        ...mapState({
            showSidebar: state => state.showSidebar,
            isMobile: state => state.isMobile,
        }),
    },
    methods: {
        toggleActive() {
            if (this.isMobile) {
                store.commit('toggleSidebar');
            }
        }
    },
};
</script>
  
<style>
.topSideContainer {
    height: 75px;
    background-color: orange;
}
</style>