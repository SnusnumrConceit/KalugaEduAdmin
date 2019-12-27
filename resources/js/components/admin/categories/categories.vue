<template>
    <div class="container-fluid mt-4">
        <div class="category_functional row">
            <div class="col-3">
                <button class="btn btn-outline-success" @click="$router.push({path: toCreate})">
                    <i class="pe-7s-plus"></i> Добавить
                </button>
            </div>
            <div class="col-4 offset-5">
                <input class="form-control" v-model="search.keyword" placeholder="Поиск">
            </div>
        </div>
        <div class="category_content mt-4" v-if="categories.length">
            <table class="table table-striped table-responsive-xs">
                <thead>
                    <th>
                        Название
                    </th>
                    <th>
                        Родитель
                    </th>
                    <th></th>
                </thead>
                <tbody>
                    <tr v-for="(category, index) in categories" :key="category.id">
                    <td>
                        <!-- по клику вызывать модалку -->
                        <span>
                            {{ category.name }}
                        </span>
                    </td>
                    <td>
                        <span v-if="category.parent_id !== null">
                            {{ category.parent.name }}
                        </span>
                        <span v-else>
                            <i>Нет</i>
                        </span>
                    </td>
                    <!-- иконки -->
                    <td>
                        <i class="pe-7s-note2 text-info pointer icons"
                           @click="$emit('show_category_detail', {id: category.id})"
                           v-tooltip="'Детали'">

                        </i>
                        <i class="pe-7s-settings text-success pointer icons"
                           @click="$router.push({path: toEdit(category.id)})"
                           v-tooltip="`Редактировать ${category.name}`">
                        </i>
                        <i class="pe-7s-trash text-danger pointer icons"
                           @click="destroy(category.id, index)"
                           v-tooltip="`Удалить ${category.name}`">
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
            Не найдено ни одной категории
        </div>

        <category-detail>

        </category-detail>
    </div>
</template>

<script>
  import CategoryDetail from './category_detail';
  import debounce from '../../../debounce';
  import swal_error from '../../../mixins/swal';

  export default {
    name: "categories",

    components: {
      "category-detail": CategoryDetail,
    },

    mixins: [
      swal_error
    ],

    data() {
      return {
        categories: [],

        search: {
          keyword: '',
          sort_by: '',
          order_by: '',
        },

        pagination: {
          page: 1,
          last_page: 1
        }
      }
    },

    computed: {
      toCreate() {
        return '/admin/categories/create';
      },

      toEdit() {
        return id => `/admin/categories/${id}`;
      },

      isSearching() {
        return this.search.keyword.length;
      }
    },

    methods: {
      async loadData() {
        const response = await axios.get('/categories', {
          params: {
            page: this.pagination.page
          }
        });

        switch (response.status) {
          case 200:
            this.categories = response.data.categories.data;
            this.pagination.last_page = response.data.categories.last_page;
            break;

          case 'error':
            this.showErrorSwal(response.data.msg);
            break;
        }
      },

      async searchData() {
        const response = await axios.get('/admin/categories/search', {
          params: {
            page: this.pagination.page,
            keyword: this.search.keyword
            /** дописать ещё параметры **/
          }
        });

        switch (response.status) {
          case 200:
            this.categories = response.data.categories.data;
            this.pagination.last_page = response.data.categories.last_page;
            break;

          default:
            console.error(response.data);
            this.showErrorSwal(response.data.msg);
            break;
        }
      },

      destroy(id, index) {
        this.$swal.fire({
          type: 'question',
          title: `Вы уверены что хотите удалить категорию ${this.categories[index].name}`,
          text: "Данное действие необратимо",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Удалить!',
          cancelButtonText: 'Отмена'
        }).then((result) => {
          if (result.value) {
            const response = axios.delete(`/categories/${id}`)
                .then(response => {
                  switch (response.data.status) {
                    case 'success':
                      this.$swal('Успешно!', response.data.msg, 'success');
                      this.loadData();
                      break;

                    case 'error':
                      this.showErrorSwal(response.data.msg);
                      break;
                  }
                });
          }
        })
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
    },

    mounted() {

    }
  }
</script>

<style scoped>

</style>