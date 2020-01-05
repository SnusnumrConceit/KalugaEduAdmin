<template>
    <div class="container-fluid row" v-cloak>
        <keep-alive>
            <component :is="dynamicComponent"></component>
        </keep-alive>
<!--        <admin v-if="$auth.check('admin')"></admin>-->

<!--        <dashboard v-else>-->

<!--        </dashboard>-->
    </div>
</template>

<script>
  import Admin from './admin/admin';
  import Dashboard from './dashboard/index';
  import Login from './base/auth/login'

  export default {
    name: "base-main",
    components: {
      Admin,
      Dashboard,
      Login
    },

    computed: {
      dynamicComponent() {
        if (this.$route.name === 'Login') {
          return 'login';
        }
        return (this.isAdminRoute && this.$auth.user().user !== undefined && this.$auth.user().user.roles[0].slug === 'admin')
          ? 'admin'
          : 'dashboard';
      },

      isAdminRoute() {
        const regex = /[admin]/;
        console.log(regex.test(this.$route.name));
        return regex.test(this.$route.name);
      }
    },

    created() {
      console.log(this.$auth.user().user);
      if (this.$auth.user().user === undefined) {
        let app = this;
        this.$auth.fetch({
          url: `admin/auth/user`,
          method: 'GET',
          enabled: false,
          success: function (res) {
            app.$auth.user(res.data);
          },
          error: function (res) {
            app.$swal('Ошибка!', res.response.data.msg, 'error');
            app.$router.push({name: 'Dashboard'});
          }
        });
      } else {
        console.log(this.$auth.user().user, 'user');
        console.log(this.$auth.check(), 'check');
        console.log(this.$auth.user().user.roles[0].slug === 'admin', 'is admin');
      }
    }
  }
</script>

<style scoped lang="scss">

</style>