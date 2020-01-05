<template>
    <div class="mt-4" v-cloak>
        <h2>{{ category.name }}</h2>
        <div class="document-section" v-if="documents.length">
            <div v-for="(doc, index) in documents" :key="doc.id">
                <button class="btn btn-outline-default"
                        @click.prevent="download(doc.name, doc.url)">
                    <i class="fas fa-file-word"></i> {{ doc.name }}
                </button>
            </div>
        </div>
        <div class="alert alert-info" v-else>
            Список документов пополняется
        </div>
    </div>
</template>

<script>
  import swal_error from '../../mixins/swal';
  import doc_download from '../../mixins/doc_download';

  export default {
    name: "category_documents",

    mixins: [
      swal_error,
      doc_download
    ],

    data() {
      return {
        documents: [],
        category: {}
      }
    },

    methods: {
      async loadDocuments() {
        $('.spinner-block').removeClass('d-none');
        const response = await axios.get(`/categories/${this.$route.params.id}/documents`);

        switch (response.status) {
          case 200:
            $('.spinner-block').addClass('d-none');
            this.documents = response.data.category.documents;
            this.category = response.data.category;
            break;

          default:
            $('.spinner-block').addClass('d-none');
            this.showErrorSwal(response.data.msg);
            break;
        }
      }
    },

    mounted() {
      this.loadDocuments();
    }
  }
</script>

<style scoped>

</style>