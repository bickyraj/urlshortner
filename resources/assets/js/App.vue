
<template>
    <component v-bind:is="layout"></component>
</template>

<script>
import LoginLayout from './components/Layouts/Login'
import AdminLayout from './components/Layouts/Admin'
import ErrorLayout from './components/Layouts/Error'
import FrontLayout from './components/Layouts/Front'
export default {
  computed: {
    layout () {
      // return this.$store.getters.layout
      return (this.$route.meta.layout) + '-layout'
    }
  },
  components: {
    'login-layout': LoginLayout,
    'admin-layout': AdminLayout,
    'error-layout': ErrorLayout,
    'front-layout': FrontLayout,
    // define as many layouts you want for the application
  }
}
</script>