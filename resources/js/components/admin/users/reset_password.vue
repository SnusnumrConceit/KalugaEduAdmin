<template>
    <modal name="reset_password" adaptive draggable scrollable height="auto">
        <div class="modal-header">
            <h2>Сбросить пароль</h2>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="">
                    Введите Email
                </label>
                <input type="password" class="form-control" v-model="email">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-success" @click="reset">
                Отправить
            </button>
        </div>
    </modal>
</template>

<script>
  import swal_error from '../../../mixins/swal';

  export default {
    name: "reset_password",

    mixins: [
      swal_error
    ],

    data() {
      return {
        email: ''
      }
    },

    methods: {
      async reset() {
        const response = await axios.post('/reset', this.email);

        switch (response.data.status) {
          case 'success':
            this.$swal('Успешно', response.data.msg, 'success');
            this.hide();
            this.$router.push({name: 'AdminUsers'});
            break;

          case 'error':
            this.showErrorSwal(response.data.msg);
            break;
        }
      },

      show() {
        this.$modal.show('reset_password');
      },

      hide() {
        this.email = '';
        this.$modal.hide('reset_password');
      }
    },

    mounted() {
      this.$parent.$on('show_reset_password_form', this.show);
    }


  }
</script>

<style scoped>

</style>