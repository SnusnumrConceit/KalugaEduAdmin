<template>
    <modal name="document_modal" adaptive draggable scrollable height="auto">
        <div class="modal-header text-justify">
            <h2>{{ document.name }}</h2>
        </div>

        <div class="modal-body">
            <div class="form-group">
                <label for="">
                    Категория:
                </label>
                <label for="">
                    {{ document.category.name }}
                </label>
            </div>
            <div class="form-group">
                <label for="">Дата создания: </label>
                <span>{{ document.created_at }}</span>
            </div>
            <div class="form-group">
                <label for="">Дата последнего обновления: </label>
                <span>{{ document.updated_at }}</span>
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
    name: "DocumentModal",

    data() {
      return {
        document: {
          name: '',
          category: {},
          created_at: '',
          updated_at: ''
        }
      }
    },

    methods: {
      async getDocument(id) {
        const response = await axios.get(`/documents/${id}`);

        this.document = response.data.document;
      },

      async initData({id}) {
        this.$modal.show('document_modal');

        this.getDocument(id);
      },

      close() {
        this.$modal.hide('document_modal');
      },
    },

    mounted() {
      this.$parent.$on('show_doc_detail', this.initData)
    }
  }
</script>