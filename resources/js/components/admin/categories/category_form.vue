<template>
    <div class="card m-auto h-100 p-5 w-50">
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
                Добавить
            </button>
            <button class="btn btn-outline-default" @click="$router.go(-1)">
                Отмена
            </button>
        </div>
    </div>
</template>

<script>
  export default {
    name: "category_form",

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
        hasID() {
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
              this.$swal('Ошибка!', '', 'error');
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
              this.$swal('Ошибка!', '', 'error');
              break;
          }
        }
      },

      async loadCategory() {
        const response = await axios.get(`/categories/${this.$route.params.id}/edit`);

        switch (response.status) {
          case 200:
            this.category = response.data.category;
            break;

          default:
            this.$swal('Ошибка!', '', 'error');
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
            this.$swal('Ошибка!', '', 'error');
            break;
        }
      }
    },

    mounted() {
      if (this.hasID) {
        this.loadCategory();
      }
      this.loadCategories();
    }


  }
</script>

<style scoped>

</style>