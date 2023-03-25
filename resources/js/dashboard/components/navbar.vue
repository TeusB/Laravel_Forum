<template>
    <div class="topNav" v-bind:class="{ 'flexDirectionReverse': isMobile && showSidebar }">
        <div v-show="!showSidebar || (!isMobile || isMobile && !showSidebar)" class="hamburger mx-4 my-4"
            v-on:click="toggleActive">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="mx-4 my-4">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img :src="imageUrl" alt="" width="32" height="32"
                    class="rounded-circle me-2">
                <strong>{{ user.name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li>
                    <RouterLink class="dropdown-item" :to="{ name: 'dashboardProfile' }">Profile
                    </RouterLink>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
import store from '../../store.js'
import { mapState } from 'vuex';

export default {
    methods: {
        toggleActive() {
            store.commit('toggleSidebar');
        }

    },
    computed: {
        ...mapState({
            showSidebar: state => state.showSidebar,
            isMobile: state => state.isMobile,
            user: state => state.user,
        }),
        imageUrl() {
            return `../../../../avatars/${this.$store.state.user.profileIMG}`;
        }
    },
};


</script>
  
<style>
.topNav {
    height: 75px;
    background-color: aqua;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    transition: width 0.3s ease-in-out;
}

.hamburger {
    display: block;
    width: 30px;
    height: 20px;
    position: relative;
    cursor: pointer;
    margin-right: 5%;
}

.hamburger span {
    display: block;
    position: absolute;
    height: 3px;
    width: 100%;
    background: #000;
    border-radius: 9px;
    opacity: 1;
    left: 0;
    transform: rotate(0deg);
    transition: all 0.25s ease-in-out;
}

.hamburger span:nth-child(1) {
    top: 0;
}

.hamburger span:nth-child(2) {
    top: 8px;
}

.hamburger span:nth-child(3) {
    top: 16px;
}

.flexDirectionReverse {
    flex-direction: row-reverse;
}
</style>