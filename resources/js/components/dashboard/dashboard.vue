<template>
    <div class="jumbotron jumbotron__bg-image jumbotron__font">
        <h1 class="display-4 font-weight-bold">Официальный сайт

            Администрации Калужского муниципального образования

            Федоровского муниципального района Саратовской области</h1>
        <p class="lead font-weight-bold">Администрация муниципального образования рада приветствовать Вас на нашем официальном сайте!</p>
        <hr class="my-4">
        <p class="font-weight-bold">На страничках сайта вы найдете исчерпывающую информацию о муниципальном образовании и всех аспектах его жизни</p>
        <!--<p class="lead">-->
            <!--<a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>-->
        <!--</p>-->
    </div>
</template>

<script>
  export default {
    name: "dashboard"
  }
</script>

<style scoped lang="scss">
    .jumbotron {
        &__bg-image {
            background-image: url(https://sun9-60.userapi.com/c855332/v855332378/1902db/1AQSpJUGnTE.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        &__font {
            color: #ffaf4a;
            text-shadow: 1px 1px #000;
        }
    }
</style>