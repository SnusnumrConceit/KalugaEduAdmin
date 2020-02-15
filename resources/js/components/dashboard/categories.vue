<template>
    <div class="col-md-4 col-lg-4 navbar-container bg-light">
        <nav class="navbar navbar-expand-md navbar-light">
            <router-link class="navbar-brand kaluga-title" :to="{name: 'Dashboard'}">Калужская администрация</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <!-- Пункты вертикального меню -->
                <ul class="navbar-nav">
                    <li class="nav-item" v-for="(category, index) in categories" :key="categories.id">
                        <router-link :to="{ path: `/category/${category.id}`}" :class="'nav-link category-link'">
                            {{ category.name }}
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
  export default {
    name: "categories",

    data() {
        return {
          categories: []
        }
    },

    methods: {
      async loadCategories() {
        const response = await axios.get('/categories');

        switch (response.status) {
          case 200:
            this.categories = response.data.categories;
            break;

          case 'error':
            this.showErrorSwal(response.data.msg);
            break;
        }
      }
    },

    created() {
      this.loadCategories();
    }
  }
</script>

<style scoped lang="scss">
    @media (min-width: 768px) {
        .navbar-container {
            position: sticky;
            top: 0;
            overflow-y: auto;
            height: 100vh;
            background: #0b0b2d !important;

            .navbar {
                align-items: flex-start;
                justify-content: flex-start;
                flex-wrap: nowrap;
                flex-direction: column;
                height: 100%;
            }

            .navbar-collapse {
                align-items: flex-start;
            }

            .nav {
                flex-direction: column;
                flex-wrap: nowrap;
            }

            .navbar-nav {
                flex-direction: column !important;
            }

            .category-link {
                color: #e2e6ea;
            }

            .category-link:hover {
                color: #fff !important;
            }
        }

        .kaluga-title {
            color: #e2e6ea;
        }

        .kaluga-title:hover {
            color: #fff !important;
        }
    }
</style>