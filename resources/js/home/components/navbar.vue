<template>
    <nav id="navbar" v-if="homeNavbar" class="navbar">
        <div class="flexContainer">
            <div class="logoContainer">
                <img class="logo" src="../../IMG/logo.png" alt="My Image" v-bind:class="{ logoRemove: isActive }">
            </div>
            <div v-if="hamburgerCheck" class="hamburger" v-bind:class="{ active: isActive }" v-on:click="toggleActive">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="linkContainer" v-bind:class="{ linkMobile: isActive }">
            <RouterLink :to="{ name: 'homeIndex' }" v-on:click="toggleActive" exact-active-class="active"
                active-class="active">Home</RouterLink>
            <RouterLink :to="{ name: 'homeAbout' }" v-on:click="toggleActive" exact-active-class="active"
                active-class="active">About</RouterLink>
            <RouterLink :to="{ name: 'homeLogin' }" v-on:click="toggleActive" exact-active-class="active"
                active-class="active">Login</RouterLink>
            <RouterLink :to="{ name: 'homeRegister' }" v-on:click="toggleActive" exact-active-class="active"
                active-class="active">Register
            </RouterLink>
        </div>
    </nav>
</template>
  
<script>
import { mapState } from 'vuex';
export default {
    data() {
        return {
            isActive: false,
            removeStick: true,
            hamburgerCheck: true,
        };
    },
    methods: {
        toggleActive() {
            this.isActive = !this.isActive;
        },
        handleResize() {
            if (window.innerWidth > 850) {
                this.hamburgerCheck = false;
            } else {
                this.hamburgerCheck = true;
            }
        }
    },
    computed: {
        ...mapState({
            homeNavbar: state => state.homeNavbar,
        }),
    },
    created() {
        window.addEventListener("resize", this.handleResize);
        this.handleResize();
    },
    destroyed() {
        window.removeEventListener("resize", this.handleResize);
    },
};

</script>
  
<style>
@media (max-width: 850px) {

    .linkContainer {
        transition: height 0.4s ease-in-out;
        height: 1px;
        background-color: aqua;
        width: 100%;
        display: flex !important;
        flex-direction: column;
        align-items: center;
        overflow: hidden;
    }

    .linkContainer a {
        opacity: 0;
        transition: opacity 0.2s ease-in !important;
    }

    .linkContainer a:nth-child(3) {
        transition: opacity 0.3s ease-in !important;
    }

    .linkContainer a:nth-child(4) {
        transition: opacity 0.3s ease-in !important;
    }

    .linkMobile {
        height: 100vh;
    }

    .linkMobile a {
        display: block;
        opacity: 1;
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

    .hamburger.active span:nth-child(1) {
        top: 8px;
        transform: rotate(45deg);
    }

    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .hamburger.active span:nth-child(3) {
        top: 8px;
        transform: rotate(-45deg);
    }

    .flexContainer {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        background-color: aqua;
        width: 100%;
        align-items: center;
        height: 50px;
    }

    .navbar {
        justify-content: center;
        align-items: center;

    }

    .logoRemove {
        opacity: 0 !important;
    }

}

@media (min-width: 850px) {
    .linkContainer {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-right: 35%;
    }

    .navbar {
        justify-content: space-around;
    }
}


.navbar {
    height: fit-content;
    display: flex;
    flex-direction: row;
    background-color: aqua;
    /* position: fixed; */
    width: 100%;
    z-index: 999;
}

.logo {
    height: 30px;
    width: 30px;
    opacity: 1;
    transition: opacity 0.1s ease-in !important;
}

.active {
    color: black !important;
}

.logoContainer {
    margin-left: 5%;
    position: relative;
    display: block;

}


.linkContainer a {
    margin-left: 15%;
    margin-right: 15%;
    font-size: 160%;
    text-decoration: none;
    position: relative;
    color: rgb(255, 255, 255);
    transition: color 0.3s ease-in-out;
}

.linkContainer a:hover {
    color: black;
}

.linkContainer a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background-color: black;
    transition: width 0.2s ease-in-out;
}

.linkContainer a:hover::after {
    width: 100%;
}

.linkContainer a:not(:hover)::after {
    width: 0;
    right: 0;
    left: auto;
    transition: width 0.2s ease-in-out;
}
</style>