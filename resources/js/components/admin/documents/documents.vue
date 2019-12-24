<template>
    <div class="container-fluid mt-4">
        <div class="document_functional row">
            <div class="col-3">
                <button class="btn btn-outline-success" @click="$router.push({path: toCreate})">
                    <i class="pe-7s-plus"></i> Добавить
                </button>
            </div>
            <div class="col-4 offset-5">
                <input class="form-control" v-model="search.keyword" placeholder="Поиск">
            </div>
        </div>
        <div class="document_content mt-4" v-if="docs.length">
            <table class="table table-striped table-responsive-xs">
                <thead>
                    <th>
                        Название
                    </th>
                    <th>
                        Категория
                    </th>
                    <th></th>
                </thead>
                <tbody>
                    <tr v-for="(doc, index) in docs" :key="doc.id">
                        <td>
                            <!-- по клику вызывать модалку -->
                            <span>
                                {{ doc.name }}
                            </span>
                        </td>
                        <td>
                            <span v-if="doc.category_id !== null">
                                {{ doc.category.name }}
                            </span>
                            <span v-else>
                                <i>Нет</i>
                            </span>
                        </td>
                        <!-- иконки -->
                        <td>
                            <i class="pe-7s-note2 text-info pointer icons"
                               @click="$emit('show_doc_detail', {id: doc.id})"
                               v-tooltip="'Детали'">

                            </i>
                            <i class="pe-7s-settings text-success pointer icons"
                               @click="$router.push({path: toEdit(doc.id)})"
                               v-tooltip="`Редактировать ${doc.name}`">
                            </i>
                            <i class="pe-7s-trash text-danger pointer icons"
                               @click="destroy(doc.id, index)"
                               v-tooltip="`Удалить ${doc.name}`">
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
            Не найдено ни одного документа
        </div>
    </div>
</template>

<script>

  import debounce from '../../../debounce';
  import swal_error from '../../../mixins/swal';

  export default {
    name: "documents",

    mixins: [
      swal_error
    ],

    data() {
      return {
        docs: [],

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
        return '/admin/documents/create';
      },

      toEdit() {
        return id => `/admin/documents/${id}`;
      },

      isSearching() {
        return this.search.keyword.length;
      }
    },

    methods: {
      async loadData() {
        const response = await axios.get('/documents', {
          params: {
            page: this.pagination.page
          }
        });

        switch (response.status) {
          case 200:
            this.docs = response.data.docs.data;
            this.pagination.last_page = response.data.docs.last_page;
            break;

          default:
            console.error(response.data);
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      async searchData() {
        const response = await axios.get('/admin/documents/search', {
          params: {
            page: this.pagination.page,
            keyword: this.search.keyword
          }
        });

        switch (response.status) {
          case 200:
            this.docs = response.data.docs.data;
            this.pagination.last_page = response.data.docs.last_page;
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
          title: `Вы уверены что хотите удалить документ ${this.docs[index].name}`,
          text: "Данное действие необратимо",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Удалить!',
          cancelButtonText: 'Отмена'
        }).then((result) => {
          if (result.value) {
            const response = axios.delete(`/documents/${id}`)
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