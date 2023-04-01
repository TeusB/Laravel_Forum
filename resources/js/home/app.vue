<template>
  <div class="homeContainer">
    <transition name="nestedTop" mode="out-in">
      <navbar class="innerTop"></navbar>
    </transition>
    <div class="scrollContent">
      <router-view v-slot="{ Component }">
        <transition name="nestedRight" mode="out-in">
          <component class="innerRight" :is="Component" />
        </transition>
      </router-view>
      <transition name="nestedRight" mode="out-in">
        <footerVue class="innerRight"></footerVue>
      </transition>
    </div>
  </div>
</template>

<script>
import navbar from './components/navbar.vue';
import footerVue from './components/footer.vue';

export default {
  name: 'App',
  components: {
    navbar,
    footerVue,
  },
  methods: {
  },
};
</script>

<style>
.homeContainer {
  height: 100vh;
  display: flex;
  flex-direction: column;
}
.marginTop {
  margin-top: 90px;
  margin-bottom: 30px;
}

</style>