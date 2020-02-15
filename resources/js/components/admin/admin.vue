<template>
    <div class="container-fluid row">
        <navigation v-if="$route.name !== 'Login'"></navigation>

        <div class="col-8 col-md-8 col-lg-8 bg-light">
            <div class="row col-12 flex-row-reverse">
                <div class="pull-right">
                    <span v-if="this.$auth.user() !== undefined">
                        {{ $auth.user().user.email}}

                        <a class="btn btn-link" @click.prevent="logout()">Выйти</a>
                    </span>
                </div>
            </div>
            <div class="row col-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
  import Navigation from '../base/navigation';

  export default {
    name: "admin",

    components: {
      Navigation
    },

    methods: {
      logout() {
        if (this.$route.name !== 'Admin') {
          this.$auth.logout({
            url: `auth/logout`,
            method: 'POST',
            redirect: '/dashboard',
            makeRequest: true
          });
          return true;
        } else {
          this.$auth.logout();
        }

      }
    },

    created() {

    }
  }
</script>

<style scoped>

</style>