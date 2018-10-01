<template>
  <div class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <AppHeader :companyName="'Admin'"/>
    <div class="app-body">
      <Sidebar :navItems="nav" />
      <main class="main">
        <breadcrumb :list="list" />
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
      <!-- <AppAside/> -->
    </div>
    <AppFooter/>
  </div>
</template>
<script>
  import nav from '../../_nav.js'
  import Sidebar from '../Sidebar/Sidebar.vue'
  import AppFooter from '../Footer.vue'
  import AppHeader from '../Header/Header.vue'
  import Breadcrumb from '../Breadcrumb.vue'
  // import AppAside from './components/Aside.vue'
  export default {
    name: 'app',
    data() {
      return {
        nav: nav.items,
        authenticated: auth.check(),
        user: auth.user
      }
    },
    components: {
      Sidebar,
      AppFooter,
      AppHeader,
      Breadcrumb,
      // AppAside
    },
    computed: {
      name() {
        return this.$route.name
      },
      list() {
        return this.$route.meta.breadcrumb
      }
    },
    mounted() {
      Event.$on('userLoggedIn', () => {
        this.authenticated = true;
        this.user = auth.user;
      });
    },
  }
</script>
<style lang="scss">
  @import '../../../scss/style';
</style>