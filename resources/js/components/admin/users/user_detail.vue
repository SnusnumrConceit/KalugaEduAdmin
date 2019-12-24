<template>
    <modal name="user_detail" adaptive draggable scrollable height="auto">
        <div class="modal-header">
            {{ user.login }}
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label for="">
                    Email:
                </label>
                <label for="">
                    {{ user.email }}
                </label>
            </div>
            <div class="form-group">
                <label for="">
                    Роль:
                </label>
                <label for=""></label>
            </div>
            <div class="form-group">
                <label for="">Дата создания: </label>
                <span>{{ user.created_at }}</span>
            </div>
            <div class="form-group">
                <label for="">Дата последнего обновления: </label>
                <span>{{ user.updated_at }}</span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-primary" @click="close">
                Закрыть
            </button>
        </div>
    </modal>
</template>

<script>
  export default {
    name: "user_detail",

    data() {
      return {
        user: {
          email: '',
          login: '',
        }
      }
    },

    methods: {
      close() {
        this.user = {
          email: '',
          login: ''
        };
        this.$modal.hide('user_detail');
      },

      show() {
        this.$modal.show('user_detail');
      },

      async loadUserDetail(e) {
        const response = await axios.get(`/users/${e.id}`);

        switch (response.status) {
          case 200:
            this.user = response.data.user;
            this.show();
            break;

          default:
            this.$swal('Ошибка!', response.data.msg, 'error');
            break;
        }

      }

    },

    mounted() {
      this.$parent.$on('show_user_detail', this.loadUserDetail);
    }
  }
</script>

<style scoped>

</style>