<template>
    <div class="card mx-auto p-5 w-50 mt-4">
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
                Название<sup>*</sup>
            </label>
            <input type="text" class="form-control" v-model="category.name">
        </div>
        <div class="form-group">
            <label for="">
                Родительская категория
            </label>
            <v-select v-model="category.parent_id" :options="categories" label="name" :reduce="category => category.id">

            </v-select>
            <!--<select class="form-control" v-model="category.parent_id">-->
                <!--<option :value="categ.id" v-for="categ in categories">-->
                    <!--{{ categ.name }}-->
                <!--</option>-->
            <!--</select>-->
        </div>
        <div class="form-group">
            <label for="">
                Псевдоним
            </label>
            <input type="text" class="form-control" v-model="category.slug">
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
  import swal_error from '../../../mixins/swal'

  export default {
    name: "category_form",

    mixins: [
      swal_error
    ],

    data() {
      return {
        category: {
          name: '',
          parent_id: null,
          slug: null
        },

        /** список категорий для формы **/
        categories: []
      }
    },

    computed: {
        ID() {
          return this.$route.params.id;
        }
    },

    methods: {
      async save() {
        if (this.category.id === undefined) {
          const response = await axios.post('/categories', {...this.category});

          switch (response.data.status) {
            case 'success':
              this.$swal('Успешно!', response.data.msg, 'success');
              this.$router.push({ name: 'AdminCategories'});
              break;

            case 'error':
              this.showErrorSwal(response.data.error);
              break;
          }
        } else {
          const response = await axios.patch(`/categories/${this.category.id}`, {...this.category});

          switch (response.data.status) {
            case 'success':
              this.$swal('Успешно!', response.data.msg, 'success');
              this.$router.push({ name: 'AdminCategories'});
              break;

            case 'error':
              this.showErrorSwal(response.data.error);
              break;
          }
        }
      },

      async loadCategory() {
        $('.spinner-block').removeClass('d-none');
        const response = await axios.get(`/categories/${this.$route.params.id}/edit`);

        switch (response.status) {
          case 200:
            $('.spinner-block').addClass('d-none');
            this.category = response.data.category;
            break;

          default:
            $('.spinner-block').addClass('d-none');
            this.showErrorSwal(response.data.msg);
            break;
        }
      },

      async loadCategories() {
        const response = await axios.get(`/categories`);

        switch (response.status) {
          case 200:
            this.categories = response.data.categories;
            break;

          default:
            this.showErrorSwal(response.data.msg);
            break;
        }
      }
    },

    mounted() {
      if (this.ID) {
        this.loadCategory();
      }
      this.loadCategories();
    }


  }
</script>

<style scoped>

</style>