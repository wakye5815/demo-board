<template>
  <div>
    <signup-form :onFail="setErrorMessageList"/>
    <p style="color:red" v-for="(msg,index) in errorMessageList" :key="index">{{msg}}</p>
  </div>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";
import SignupForm from "../components/SignupForm.vue";

@Component({ components: { SignupForm } })
export default class Signup extends Vue {
  private errorMessageList: string[] = [];

  setErrorMessageList(list: string[]) {
    this.errorMessageList = list;
  }
}
</script>

<style scoped>
</style>