<template>
    <div class="container-fluid row">
        <navigation></navigation>

        <div class="col-md-8 col-lg-10 bg-light">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
  import Navigation from '../base/navigation';

  export default {
    name: "admin",

    components: {
      Navigation
    }
  }
</script>

<style scoped>

</style>