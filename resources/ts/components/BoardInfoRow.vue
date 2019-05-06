<template>
  <div class="frame">
    <div class="content">
      <p>{{`${board.name} 作成者:${board.owner_name}`}}</p>
      <router-link :to="`board/${board.id}`">
        <el-button type="primary" size="mini" round>join</el-button>
      </router-link>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { isSuccessResponse, isFailuerResponse } from "../api/utils";
import { User, Board } from "../commonTypes";

@Component
export default class BoardInfoRow extends Vue {
  @Prop({ type: Object, required: true })
  private board!: Board;
}
</script>

<style scoped>
.frame {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  background: #fff;
}
.content {
  padding: 10px;
  display: flex;
  justify-content: space-between;
}
</style>