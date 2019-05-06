<template>
  <el-container style="height:100%">
    <el-aside width="250px">
      <el-menu default-active="1" style="height:100%">
        <el-menu-item index="1">
          <router-link to="/main/board-portal">
            <i class="el-icon-postcard"></i>
            <span>Board</span>
          </router-link>
        </el-menu-item>
        <el-menu-item @click="signout" index="2">
          <i class="el-icon-menu"></i>
          <span>Signout</span>
        </el-menu-item>
      </el-menu>
    </el-aside>

    <el-container>
      <el-header>LoginUser:{{loginUser.name}}</el-header>
      <el-main>
        <router-view/>
      </el-main>
    </el-container>
  </el-container>
</template>

<script lang="ts">
import { Vue, Component } from "vue-property-decorator";
import { User } from "../commonTypes";
import { Route } from "vue-router";
import { signout } from "../api/account";
import store from "../store";

Component.registerHooks(["beforeRouteEnter"]);

@Component
export default class Main extends Vue {
  beforeRouteEnter(to: Route, from: Route, next: Function) {
    store.getters.loginUser ? next() : next("/");
  }

  get loginUser(): User {
    return this.$store.getters.loginUser;
  }

  async signout(){
    await signout();
    this.$store.commit("loginUser", undefined);
    this.$router.push("/");
  }
}
</script>

<style scoped>
.side-bar {
  position: fixed;
  width: 200px;
  height: 100%;
}
</style>