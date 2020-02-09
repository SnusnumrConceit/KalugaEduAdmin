<template>
    <div class="card w-50 mx-auto mt-4 p-3">
        <h2 class="text-center mb-3">Авторизация</h2>


        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">
                Email
            </label>

            <div class="col-md-6">
                <input type="text" id="email" class="form-control" v-model="auth.email">
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">
                Пароль
            </label>

            <div class="col-md-6">
                <input type="password" id="password" class="form-control" v-model="auth.password">
            </div>
        </div>

        <div class="form-group flex flex-center">
            <button class="btn btn-outline-primary" @click="authorize()">
                Войти
            </button>
        </div>
    </div>
</template>

<script>
  import swal_error from '../../../mixins/swal';

  export default {
    name: "login",

    mixins: [
      swal_error
    ],

    data() {
      return {
        auth: {
          email: '',
          password: '',
          error: false,
          has_error: '',
          success: false
        }
      }
    },

    methods: {
      authorize() {
        const redirect = this.$auth.redirect();
        const app = this;

        console.log(this.$auth);

        this.$auth.login({
          data: {
            email: app.auth.email,
            password: app.auth.password
          },
          success: function(res) {
            console.log(res);
            switch (res.data.status) {
              case 'success':
                break;

              case 'error':
                this.showErrorSwal(res.response.data.error);
                return false;
            }
            app.success = true;
            const redirectTo = '/admin';
            this.$router.push({path: redirectTo});
          },
          error: function(res) {
            this.showErrorSwal(res.response.data.error);
            app.has_error = true;
            app.error = res.response.data.error;
          },
          rememberMe: true,
             // app.error = response;
          fetchUser: true
        })
      // .then((response) => {
      //     console.log(response.data);
      //     switch (response.data.status) {
      //       case 'success':
      //         app.success = true;
      //         this.$router.push({name: 'AdminDocs'});
      //         break;
      //
      //       case 'error':
      //         this.showErrorSwal(response.data.error);
      //         app.has_error = true;
      //         console.log(response, 'error');
      //         app.error = response;
      //         return false;
      //     }
      //   });
      }
    },

    created() {
      
    }
  }
</script>

<style scoped>

</style>