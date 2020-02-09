<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="card card-default">
                    <div class="card-header">Новый пароль</div>
                    <div class="card-body">
                        <!-- <ul v-if="errors">
                          <li v-for="error in errors" v-bind:key="error">{{ msg }}</li>
                        </ul> -->
                        <form autocomplete="off" @submit.prevent="resetPassword" method="post">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Пароль</label>
                                <input type="password" id="password" class="form-control" placeholder="" v-model="password" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Подтвердите пароль</label>
                                <input type="password" id="password_confirmation" class="form-control" placeholder="" v-model="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
    name: "resetPasswordForm",

    data() {
      return {
        token: null,
        email: null,
        password: null,
        password_confirmation: null,
        has_error: false
      }
    },
    methods: {
      async resetPassword() {
        const response = await axios.post("/admin/auth/reset/password/", {
          token: this.$route.params.token,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });

        console.log(response.data);
        switch (response.data.status) {
          case 'success':
            this.$swal('Успешно!', response.data.msg, 'success');
            this.$router.push('/admin/users');
            break;

          case 'error':
            this.$swal('Ошибка!', response.data.msg, 'error');
            break;
        }

      }
    },


    created() {
      this.email = (this.$route.params.email) ? this.$route.params.email : null;
    }

  }
</script>

<style scoped>

</style>