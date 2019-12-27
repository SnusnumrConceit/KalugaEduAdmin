<template>
    <div class="card w-50 mx-auto mt-4 p-5">
        <h2>
            <span v-if="ID">
                Редактирование
            </span>
            <span v-else>
                Создание
            </span>
        </h2>
        <div class="form-group">
            <label for="">
                Логин <sup>*</sup>
            </label>
            <input type="text"
                   class="form-control"
                   v-model="user.login">
        </div>
        <div class="form-group">
            <label for="">
                Email <sup>*</sup>
            </label>
            <input type="text"
                   class="form-control"
                   v-model="user.email">
        </div>
        <div class="password-section" v-if="! ID">
            <div class="form-group">
                <label for="">
                    Пароль <sup>*</sup>
                </label>
                <input type="password"
                       class="form-control"
                       v-model="user.password">
            </div>
            <div class="form-group">
                <label for="">
                    Подвердите пароль <sup>*</sup>
                </label>
                <input type="password"
                       class="form-control"
                       v-model="user.password_confirmation">
            </div>
        </div>
        <div class="form-group" @click="$emit('show_reset_password_form')" v-else>
            <button class="btn btn-outline-primary">
                Сбросить пароль
            </button>
        </div>
        <div class="form-group" v-if="roles.length">
            <label for="">
                Роли
            </label>
            <v-select :reduce="role => role.id"
                      v-model="user.role[0].id"
                      :options="roles"
                      label="name">
            </v-select>
        </div>
        <div class="form-group">
            <button class="btn btn-outline-success" @click="save">
                Добавить
            </button>
            <button class="btn btn-outline-default" @click="$router.go(-1)">
                Отмена
            </button>
        </div>

        <reset-password></reset-password>
    </div>
</template>

<script>
  import swal_error from '../../../mixins/swal';
  import ResetPassword from './reset_password';

  export default {
    name: "user_form",

    mixins: [
        swal_error
    ],

    components: {
      ResetPassword
    },

    data() {
      return {
        user: {
          login: '',
          email: '',
          password: '',
          password_confirmation: '',
          role: [
            {
              id: null
            }
          ]
        },

        roles: []
      }
    },

    computed: {
      ID() {
        return this.$route.params.id;
      }
    },

    methods: {
      async loadUser() {
        const response = await axios.get(`/users/${this.ID}`);

        switch (response.status) {
          case 200:
            this.user = response.data.user;
            break;

          default:
            console.error(response.data);
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      async loadRoles() {
        const response = await axios.get(`/admin/roles`);

        switch (response.status) {
          case 200:
            this.roles = response.data.roles;
            break;

          default:
            console.error(response.data);
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      async save() {
        if (! this.ID) {
          const response = await axios.post('/users', {...this.user});

          switch (response.data.status) {
            case 'success':
              this.$swal('Успешно!', response.data.msg, 'success');
              this.$router.push({name: 'AdminUsers'});
              break;

            case 'error':
              this.showErrorSwal(response.data.error);
              break;
          }
        } else {
          const response = await axios.patch(`/users/${this.ID}`, {...this.user});

          switch (response.data.status) {
            case 'success':
              this.$swal('Успешно!', response.data.msg, 'success');
              this.$router.push({name: 'AdminUsers'});
              break;

            case 'error':
              this.showErrorSwal(response.data.error);
              break;
          }
        }
      },
    },

    created() {
      if (this.ID) {
        this.loadUser();
      }
    },

    mounted() {
      this.loadRoles();
    }
  }
</script>

<style scoped>

</style>