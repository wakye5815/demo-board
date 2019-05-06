<template>
  <div class="frame">
    <div class="content">
    <p>email-address</p>
    <el-input placeholder="Please input emailaddress" v-model="email" clearable></el-input>
    <p>password</p>
    <el-input placeholder="Please input password" v-model="password" show-password></el-input>
    <el-button type="primary" size="midium" @click="signin" round>Signin</el-button>
  </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { signin } from "../api/account";
import { isSuccessResponse, isFailuerResponse } from "../api/utils";
import store from "../store";

@Component
export default class SigninForm extends Vue {
  private email: string = "";
  private password: string = "";

  @Prop({ type: Function, required: true })
  private onFail!: (errorMessageList: string[]) => void;

  private async signin() {
    const response = await signin({
      signin_email: this.email,
      password: this.password
    });

    if (isSuccessResponse(response)) {
      this.$store.commit("loginUser", response.content.user);
      this.$router.push("/main");
    } else if (isFailuerResponse(response)) {
      const errorMessageList =
        typeof response.content.param_error_list != "undefined"
          ? Object.keys(response.content.param_error_list)
              .map(keys => (response.content.param_error_list as any)[keys])
              .reduce((acc: string[], next: string[]) => [...acc, ...next])
          : [];
      this.onFail(errorMessageList);
    }
  }
}
</script>

<style scoped>
.frame {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  background: #fff;
  height: 500px;
  width: 350px;
}

.content {
  padding: 10px;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  height: 80%;
}
</style>