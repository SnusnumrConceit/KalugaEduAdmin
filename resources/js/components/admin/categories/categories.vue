<template>
    <div>
        <div class="category_functional">
            <button class="btn btn-outline-success" @click="$router.push({path: '/admin/categories/create'})">
                <i class="pe-7s-plus"></i> Добавить
            </button>
        </div>
        <div class="category_content" v-if="categories.length">
            <table>
                <tr v-for="(category, index) in categories">
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
                        <i class="pe-7s-settings" @click="$router.push({name: 'AdminCategory'})"></i>
                        <i class="pe-7s-trash" @click="destroy(category.id, index)"></i>
                    </td>
                </tr>
            </table>

            <paginate :page="pagination.page">

            </paginate>
        </div>
        <div class="alert alert-info" v-else>
            Не добавлено ни одной категории
        </div>
    </div>
</template>

<script>
  export default {
    name: "categories",

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

    },

    methods: {
      async loadData() {
        const response = await axios.get('/categories', {
          params: {
            page: this.pagination.page
          }
        });

        switch (response.data.status) {
          case 'success':
            this.categories = response.data.categories.data;
            this.pagination.last_page = response.data.categories.last_page;
            break;

          case 'error':
            /** написать функцию вывода сообщений и вынести её в миксин **/
            break;
        }
      },

      async destroy(id, index) {
        const response = await axios.delete(`/categories/${id}`);

        switch (response.data.status) {
          case 'success':
            this.loadData();
            break;

          case 'error':
            /** написать функцию вывода сообщений и вынести её в миксин **/
            break;
        }
      }
    },

    watch: {
      'search.keyword': function (after, before) {

      },

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