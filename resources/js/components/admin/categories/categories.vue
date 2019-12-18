<template>

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