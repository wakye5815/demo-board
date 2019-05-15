<template>
  <div class="main">
    <signup-form :onFail="setErrorMessageList"/>
    <ul class="error-list">
      <li style="color:red" v-for="(msg,index) in errorMessageList" :key="index">{{msg}}</li>
    </ul>
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
.main {
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  align-items: center;
}

.error-list{
  height: 80px;
}
</style>