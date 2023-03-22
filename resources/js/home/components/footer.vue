<template>
    <footer v-if="homeFooter" class="footer">
        dit is de footer
    </footer>
</template>
  
<script>
import { mapState } from 'vuex';
export default {
    computed: {
        ...mapState({
            homeFooter: state => state.homeFooter,
        }),
    },
    methods: {

    },
};
</script>
<style>
.footer {
    margin-top: auto !important;
    width: 100%;
    background-color: aqua;
}
</style>
