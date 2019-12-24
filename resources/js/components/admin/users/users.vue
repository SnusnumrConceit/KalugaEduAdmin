<template>
    <div class="container-fluid mt-4">
        <div class="user_functional row">
            <div class="col-3">
                <button class="btn btn-outline-success" @click="$router.push({path: toCreate})">
                    <i class="pe-7s-plus"></i> Добавить
                </button>
            </div>
            <div class="col-4 offset-5">
                <input class="form-control" v-model="search.keyword" placeholder="Поиск">
            </div>
        </div>
        <div class="user_content mt-4" v-if="users.length">
            <table class="table table-striped table-responsive-xs">
                <thead>
                <th>
                    Логин
                </th>
                <th>
                    Email
                </th>
                <th>
                    Роль
                </th>
                <th></th>
                </thead>
                <tbody>
                <tr v-for="(user, index) in users" :key="user.id">
                    <td>
                        <!-- по клику вызывать модалку -->
                        <span>
                            {{ user.login }}
                        </span>
                    </td>
                    <td>
                        <!-- по клику вызывать модалку -->
                        <span>
                            {{ user.email }}
                        </span>
                    </td>
                    <td>
                        <!--<span v-if="user.role !== null">-->
                            <!--{{ user.role.name }}-->
                        <!--</span>-->
                        <!--<span v-else>-->
                            <!--<i>Нет</i>-->
                        <!--</span>-->
                    </td>
                    <!-- иконки -->
                    <td>
                        <i class="pe-7s-note2 text-info pointer icons"
                           @click="$emit('show_user_detail', {id: user.id})"
                           v-tooltip="'Детали'">
                        </i>
                        <i class="pe-7s-settings text-success pointer icons"
                           @click="$router.push({path: toEdit(user.id)})"
                           v-tooltip="`Редактировать ${user.login}`">
                        </i>
                        <i class="pe-7s-trash text-danger pointer icons"
                           @click="destroy(user.id, index)"
                           v-tooltip="`Удалить ${user.login}`">
                        </i>
                    </td>
                </tr>
                </tbody>
            </table>

            <paginate v-model="pagination.page"
                      v-if="pagination.last_page"
                      :page-count="pagination.last_page"
                      :container-class="'pagination'"
                      :page-class="'page-item'"
                      :page-link-class="'page-link'"
                      :prev-text="'Пред.'"
                      :prev-class="'page-item'"
                      :prev-link-class="'page-link'"
                      :next-text="'След.'"
                      :next-class="'page-item'"
                      :next-link-class="'page-link'"
                      :click-handler="switchPage">

            </paginate>
        </div>
        <div class="alert alert-info mt-4" v-else>
            Не найдено ни одного пользователя
        </div>
    </div>
</template>

<script>
  import debounce from '../../../debounce';
  import swal_error from '../../../mixins/swal';

  export default {
    name: "users",

    mixins: [
      swal_error
    ],

    data() {
      return {
        users: [],

        search: {
          keyword: '',
          sort_by: '',
          order_by: '',
        },

        pagination: {
          page: 1,
          last_page: 1
        },
      }
    },

    computed: {
      toCreate() {
        return '/admin/users/create';
      },

      toEdit() {
        return id => `/admin/users/${id}`;
      },

      isSearching() {
        return this.search.keyword.length;
      }
    },

    methods: {
      async loadData() {
        const response = await axios.get('/users', {
          params: {
            page: this.pagination.page
          }
        });

        switch (response.status) {
          case 200:
            this.users = response.data.users.data;
            this.pagination.last_page = response.data.users.last_page;
            break;

          default:
            console.error(response.data);
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      async searchData() {
        const response = await axios.get('/admin/users/search', {
          params: {
            page: this.pagination.page,
            keyword: this.search.keyword
          }
        });

        switch (response.status) {
          case 200:
            this.users = response.data.users.data;
            this.pagination.last_page = response.data.users.last_page;
            break;

          default:
            console.error(response.data);
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      destroy(id, index) {
        this.$swal.fire({
          type: 'question',
          title: `Вы уверены что хотите удалить пользовтеля ${this.users[index].login}`,
          text: "Данное действие необратимо",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Удалить!',
          cancelButtonText: 'Отмена'
        }).then((result) => {
          if (result.value) {
            const response = axios.delete(`/users/${id}`)
                .then(response => {
                  switch (response.data.status) {
                    case 'success':
                      this.$swal('Успешно!', response.data.msg, 'success');
                      this.loadData();
                      break;

                    case 'error':
                      this.showErrorSwal(response.data.error);
                      break;
                  }
                });
          }
        });
      },

      switchPage(page) {
        this.pagination.page = page;
        (this.isSearching) ? this.searchData() : this.loadData();
      }
    },

    watch: {
      'search.keyword': debounce(function (newVal) {
        this.switchPage(1);
      }, 300),

      'search.order_by': function (after, before) {

      },

      'search.sort_by': function (after, before) {

      }
    },

    created() {
      this.loadData();
    }
  }
</script>

<style scoped>

</style>