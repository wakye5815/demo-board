<template>
  <div class="frame">
    <div class="content">
      <p>投稿者:{{comment.owner_name}} 投稿日:{{comment.updated_at}}</p>
      <div class="main">
        <p>{{comment.content}}</p>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { isSuccessResponse, isFailuerResponse } from "../api/utils";
import { User, Comment } from "../commonTypes";

@Component
export default class CommentRow extends Vue {
  @Prop({ type: Object, required: true })
  private comment!: Comment;
}
</script>

<style scoped>
.frame {
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.12), 0 0 6px rgba(0, 0, 0, 0.04);
  background: #fff;
}

.content {
  padding: 10px;
}

.main {
  display: flex;
  justify-content: space-between;
}
</style>