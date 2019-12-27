<template>
    <div class="card w-50 mx-auto mt-4 p-5">
        <h2>Войти</h2>


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

        <div class="form-group">
            <button class="btn btn outline-primary" @click="authorize()">
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
          password: ''
        }
      }
    },

    methods: {
      async authorize() {
        const redirect = this.$auth.redirect();
        const app = this;

        const response = await this.$auth.login({
          data: {
            email: this.auth.email,
            password: this.auth.password
          }
        });
        console.log(response);
        // const response = await axios.post(`/auth/login`, this.auth);

        console.log(response.data);

        switch (response.data.status) {
          case 'success':
            this.$router.push({name: 'AdminDocs'});
            this.$swal('Успешно!', response.data.msg, 'success');
            break;

          case 'error':
            this.showErrorSwal(response.data.error);
            break;
        }
      }
    }
  }
</script>

<style scoped>

</style>