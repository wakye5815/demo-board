<template>
  <div class="frame">
    <el-input placeholder="Please input comment" style="width:85%;" v-model="comment"></el-input>
    <el-button icon="el-icon-position" @click="sendComment(comment)" circle></el-button>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";

@Component
export default class CommentInputField extends Vue {
  private comment: string = "";
  @Prop({ type: Function, required: true })
  private sendComment!: (comment: string) => Promise<any>;
}
</script>

<style scoped>
.frame {
  display: flex;
  justify-content: space-around;
  align-items: center;
}
</style>