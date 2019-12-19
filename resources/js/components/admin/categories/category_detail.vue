<template>
    <div>
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

                <!-- Исправить на router-link -->
                <span v-for="doc in category.documents">
                {{ doc.name }}
            </span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-primary" @click="close">
                Закрыть
            </button>
        </div>
    </div>
</template>

<script>
  export default {
    name: "category_detail",

    props: {
        id: {
          value: 1,
          type: 'Integer'
        }
    },

    data() {
      return {
        category: {},

        docs: []
      }
    },

    computed: {
      hasSlug() {
        return this.category.slug !== null;
      },

      hasParent() {
        return this.category.parent_id !== null;
      }
    },

    methods: {
      close() {
        this.category = {};
        this.$modal.close();
      },

      async loadCategoryDetail() {
        const response = await axios.get(`/categories/${this.id}`);

        switch (response.status) {
          case 200:
            this.category = response.data.category;
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
      this.loadCategoryDetail();
    }
  }
</script>

<style scoped>

</style>