<template>
    <div class="card w-50 mx-auto mt-4 p-5">
        <h2>
            <span v-if="ID">
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
        <div class="form-group">
            <label for="">
                Документ
            </label>
            <vue-dropzone ref="doc_dropzone"
                          id="dropzone"
                          :options="dropzone_options"
                          @vdropzone-success="successUpload"
                          @vdropzone-error="errorUpload"
                          @vdropzone-removed-file="removeDoc"></vue-dropzone>
        </div>
        <div class="form-group">
            <button class="btn btn-outline-success" @click="save">
                <span v-if="ID">
                    Сохранить
                </span>
                <span v-else>
                    Добавить
                </span>
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

        file: {},

        categories: []
      }
    },

    computed: {
      ID() {
        return this.$route.params.id;
      },
    },

    methods: {

      async loadDoc() {
        const response = await axios.get(`/documents/${this.ID}/edit`);

        switch (response.status) {
          case 200:
            this.document = response.data.doc;
            this.file = response.data.file;
            break;

          default:
            this.showErrorSwal(response.data.error);
            break;
        }
      },

      async save() {
        if (! this.ID) {
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
          const response = await axios.patch(`/documents/${this.ID}`, {...this.document});

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

      /** если файл успешно загружен, то присваиваем путь до файла **/
      successUpload(file, response) {
        console.log('SUCCESS', file, response);
        this.document.url = response.url;
        this.$refs.doc_dropzone.disable();
      },

      /** если загрузка файла завершилась ошибкой, то выводим ошибку в консоль **/
      errorUpload(file, response) {
        console.error(file, response);
      },

      /** при удалении документа удаляем его из системы **/
      async removeDoc(file, error) {
        const response = await axios.post(`/admin/documents/remove`, {
          url: this.document.url
        });

        this.document.url = '';
        this.$refs.doc_dropzone.enable();

        console.log(response.data);
      }
    },

    created() {
      if (this.ID) {
       this.loadDoc();
      }

      this.loadCategories();
    },

    mounted() {
      if (this.ID)
      setTimeout(() => {
        var file = { size: this.file.size, name: this.document.name, type: "image/png" };
        var url = this.document.url;
        this.$refs.doc_dropzone.manuallyAddFile(file, url);
      }, 300);

    }

  }
</script>

<style scoped>

</style>