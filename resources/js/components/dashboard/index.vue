<template>
    <div class="container-fluid row">
        <categories>

        </categories>

        <div class="col-md-8 col-lg-8 bg-light">
            <router-view :key="$route.params.id"></router-view>
        </div>
    </div>
</template>

<script>
  import Categories from "./categories";

  export default {
    name: "index",

    components: {
      Categories
    },

    created() {
      $('title').text('Администрация Калужского муниципального образования Федоровского муниципального района Саратовской области');
    }
  }
</script>

<style scoped>

</style>