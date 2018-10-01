<template>
      <b-nav-item-dropdown class="yenkii-dropdown-menu" right no-caret>
        <template slot="button-content">
          <!-- <img src="static/img/avatars/6.jpg" class="img-avatar" alt="Admin"> -->
          <div class="header-user-setting gym-header-user-setting">{{ companyName }} <i class="fa fa-ellipsis-v"></i></div>
        </template>
        <b-dropdown-item @click="logout"><i class="fa fa-lock"></i> Logout</b-dropdown-item>
      </b-nav-item-dropdown>
</template>
<style>
  .yenkii-dropdown-menu .dropdown-menu {
    top: 39px !important;
    background-color: #fdfdfd !important;
    right: 3px !important;
    border: none;
    box-shadow: 1px 2px 1px 1px rgba(0, 0, 0, 0.18823529411764706)
  }

  .yenkii-dropdown-menu .dropdown-menu a {
    background-color: white;
  }
  .yenkii-dropdown-menu .dropdown-menu a:hover {
    background-color: #f3f3f3;
    color: #060606;
  }

  .yenkii-dropdown-menu .dropdown-menu a:hover i {
    color: #060606;
  }

  .yenkii-dropdown-menu .dropdown-menu a i {
    margin-right: 0px;
  }

  .header-user-setting {
    margin-right: 20px;
  }
</style>
<script>
export default {
  name: 'header-dropdown',
  props: ['companyName'],
  data: () => {
    return { itemsCount: 42 }
  },
  methods: {
    logout (event) {
      event.preventDefault();
      var url = this.$root.baseUrl;
      axios.post(url + '/api/logout').then(response => {
          if (response.status === 302 || 401) {
            auth.logout();
            // this.$router.push('login');
            window.location.href = '';
          }
          else {
              // throw error and go to catch block
          }
      }).catch(error => {
          //run this code always when status!==200
      });
    }
  }
}
</script>
