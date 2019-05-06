<template>
  <div>
    <router-link to="/main">
      <p>mainに戻る</p>
    </router-link>
    <p>システムエラー</p>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";

@Component
export default class Error extends Vue {}
</script>

<style scoped>
</style>