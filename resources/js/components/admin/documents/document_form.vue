<template>
    <div class="card w-50 mx-auto mt-4 p-5">
        <h2>
            <span v-if="hasID">
                Редактирование
            </span>
            <span v-else>
                Создание
            </span>
        </h2>
        <div class="form-group">
            <label for="">
                Наименование <sup>*</sup>
            </label>
            <input type="text"
                   class="form-control"
                   v-model="document.name">
        </div>
        <div class="form-group">
            <label for="">
                Категория
            </label>
            <v-select :reduce="category => category.id"
                      v-model="document.category_id"
                      :options="categories"
                      label="name">
            </v-select>
        </div>
        <div class="form-group" v-if="! document.url.length">
            <label for="">
                Документ
            </label>
            <vue-dropzone ref="doc_dropzone" id="dropzone" :options="dropzone_options" @vdropzone-success="successUpload" @vdropzone-error="errorUpload"></vue-dropzone>
        </div>
        <div class="form-group">
            <button class="btn btn-outline-success" @click="save">
                Добавить
            </button>
            <button class="btn btn-outline-default" @click="$router.go(-1)">
                Отмена
            </button>
        </div>
    </div>
</template>

<script>

  import dropzone_options from '../../../mixins/dropzone_options';
  import vue2Dropzone from 'vue2-dropzone'
  import 'vue2-dropzone/dist/vue2Dropzone.min.css'
  import swal_error from '../../../mixins/swal'

  export default {
    name: "document_form",

    components: {
      vueDropzone: vue2Dropzone
    },

    mixins: [
      dropzone_options,
      swal_error
    ],

    data() {
      return {
        document: {
          name: '',
          url: '',
          category_id: null
        },

        categories: []
      }
    },

    computed: {
      hasID() {
        return this.$route.params.id;
      },
    },

    methods: {

      async loadDoc() {
        const response = await axios.get(`/documents/${this.hasID}/edit`);

        switch (response.status) {
          case 200:
            this.document = response.data.doc;
            break;

          default:
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      async save() {
        if (! this.hasID) {
          const response = await axios.post('/documents', {...this.document});

          switch (response.data.status) {
            case 'success':
              this.$swal('Успешно!', response.data.msg, 'success');
              this.$router.push({name: 'AdminDocuments'});
              break;

            case 'error':
              this.showErrorSwal(response.data.error);
              break;
          }
        } else {
          const response = await axios.patch(`/documents/${this.hasID}`, {...this.document});

          switch (response.data.status) {
            case 'success':
              this.$swal('Успешно!', response.data.msg, 'success');
              this.$router.push({name: 'AdminDocuments'});
              break;

            case 'error':
              this.showErrorSwal(response.data.error);
              break;
          }
        }
      },

      async loadCategories() {
        const response = await axios.get(`/categories`);

        switch (response.status) {
          case 200:
            this.categories = response.data.categories;
            break;

          default:
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      successUpload(file, response) {
        console.log('SUCCESS', file, response);
        this.document.url = response.url;
      },

      errorUpload(file, response) {
        console.error(file, response);
      }
    },

    created() {
      if (this.hasID) {
       this.loadDoc();
      }

      this.loadCategories();
    }

  }
</script>

<style scoped>

</style>