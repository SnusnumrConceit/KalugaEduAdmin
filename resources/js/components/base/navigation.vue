<template>
    <div class="col-md-4 col-lg-2 navbar-container bg-light">
        <nav class="navbar navbar-expand-md navbar-light">
            <a class="navbar-brand" href="#">Административая панель</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <!-- Пункты вертикального меню -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link :to="{ name: 'AdminCategories'}" :class="'nav-link'">
                            Категории
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'AdminDocuments'}" :class="'nav-link'">
                            Документы
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{ name: 'AdminUsers'}" :class="'nav-link'">
                            Пользователи
                        </router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
  export default {
    name: "navigation"
  }
</script>

<style scoped>
    @media (min-width: 768px) {
        .navbar-container {
            position: sticky;
            top: 0;
            overflow-y: auto;
            height: 100vh;
        }

        .navbar-container .navbar {
            align-items: flex-start;
            justify-content: flex-start;
            flex-wrap: nowrap;
            flex-direction: column;
            height: 100%;
        }

        .navbar-container .navbar-collapse {
            align-items: flex-start;
        }

        .navbar-container .nav {
            flex-direction: column;
            flex-wrap: nowrap;
        }

        .navbar-container .navbar-nav {
            flex-direction: column !important;
        }
    }
</style>