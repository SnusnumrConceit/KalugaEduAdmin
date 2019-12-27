<template>
    <modal name="category_detail" adaptive draggable scrollable height="auto">
        <div class="modal-header">
            {{ category.name }}
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label for="">
                    Тип:
                </label>
                <label for="">
                <span v-if="! hasParent">
                    Родительская
                </span>
                    <span v-else>
                    Дочерняя от {{ category.parent.name }}
                </span>
                </label>
            </div>
            <div class="form-group">
                <label for="">
                    Псевдоним:
                </label>
                <span v-if="! hasSlug">
                Отсутствует
            </span>
                <span>
                {{ category.slug }}
            </span>
            </div>
            <div class="form-group">
                <label for="">Дата создания: </label>
                <span>{{ category.created_at }}</span>
            </div>
            <div class="form-group">
                <label for="">Дата последнего обновления: </label>
                <span>{{ category.updated_at }}</span>
            </div>
            <div class="form-group">
                <label for="">
                    Документы
                </label>

                <div class="modal__documents-container" v-if="category.documents.length">
                    <!-- Исправить на router-link -->
                    <div class="row" v-for="(doc, index) in category.documents" :key="doc.id">
                        <div class="col-10">
                        <button class="btn btn-outline-default" @click.prevent="download(doc.name, doc.url)">
                            <i class="fas fa-file-word"></i> {{ doc.name }}
                        </button>
                        </div>
                        <div class="col-2">
                            <i class="pe-7s-settings text-success pointer icons"
                               @click="$router.push({path: toDocEdit(doc.id)})"
                               v-tooltip="`Редактировать ${doc.name}`">
                            </i>
                        </div>
                    </div>
                </div>
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
  import doc_download from '../../../mixins/doc_download';

  export default {
    name: "category_detail",

    mixins: [
        doc_download
    ],

    data() {
      return {
        category: {
          name: '',
          parent_id: null,
          slug: null,
          documents: []
        },

        docs: []
      }
    },

    computed: {
      hasSlug() {
        return this.category.slug !== null;
      },

      hasParent() {
        return this.category.parent_id !== null;
      },

      toDocEdit() {
        return id => `/admin/documents/${id}`;
      }
    },

    methods: {
      close() {
        this.category = {
          name: '',
          parent_id: null,
          slug: null,
          documents: []
        };
        this.$modal.hide('category_detail');
      },

      show() {
        this.$modal.show('category_detail');
      },

      async loadCategoryDetail(e) {
        const response = await axios.get(`/categories/${e.id}`);

        switch (response.status) {
          case 200:
            this.category = response.data.category;
            this.show();
            break;

          default:
            this.$swal('Ошибка!', response.data.msg, 'error');
            break;
        }

      }

      // async loadDocsList() {
      //   const response = await axios.get(`/categories/${category.id}/docs`);
      //
      //   switch (response.status) {
      //     case 200:
      //       this.docs = response.data.docs;
      //       break;
      //
      //     default:
      //       this.$swal('Ошибка!', response.data.msg, 'error');
      //       break;
      //   }
      // }
    },

    mounted() {
      this.$parent.$on('show_category_detail', this.loadCategoryDetail);
    }
  }
</script>

<style scoped>

</style>