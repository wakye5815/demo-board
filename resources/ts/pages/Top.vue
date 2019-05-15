<template>
  <div class="main">
    <router-link to="/signup">
      <el-button type="primary" size="midium" round>signup</el-button>
    </router-link>

    <signin-form :onFail="setErrorMessageList"/>
    <ul class="error-list">
      <li style="color:red" v-for="(msg,index) in errorMessageList" :key="index">{{msg}}</li>
    </ul>
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