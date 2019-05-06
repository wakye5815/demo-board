<template>
  <div class="frame">
    <div class="content">
      <p>username</p>
      <el-input placeholder="Please input" v-model="name" clearable></el-input>
      <p>email-address</p>
      <el-input placeholder="Please input" v-model="email" clearable></el-input>
      <p>password</p>
      <el-input placeholder="Please input password" v-model="password" show-password></el-input>
      <el-button type="primary" size="midium" @click="signup" round>signup</el-button>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { signup } from "../api/account";
import { isSuccessResponse, isFailuerResponse } from "../api/utils";

@Component
export default class SignupForm extends Vue {
  private name: string = "";
  private email: string = "";
  private password: string = "";

  @Prop({ type: Function, required: true })
  private onFail!: (errorMessageList: string[]) => void;

  async signup() {
    const response = await signup({
      name: this.name,
      signup_email: this.email,
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