<template>
  <div>
    <router-link to="/signup">
      <el-button type="primary" size="midium" round>signup</el-button>
    </router-link>

    <signin-form :onFail="setErrorMessageList"/>
    <p style="color:red" v-for="(msg,index) in errorMessageList" :key="index">{{msg}}</p>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Watch } from "vue-property-decorator";
import SigninForm from "../components/SigninForm.vue";
import Axios from "axios";

@Component({ components: { SigninForm } })
export default class Top extends Vue {
  private errorMessageList: string[] = [];

  setErrorMessageList(list: string[]) {
    this.errorMessageList = list;
  }
}
</script>

<style scoped>
</style>