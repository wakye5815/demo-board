<template>
  <el-container style="height:100%">
    <el-main>
      <div class="comment-conteiner">
        <comment-row :comment="comment"/>
        <div class="button-container">
          <el-button type="danger" @click="deleteComment" size="mini" round>delete</el-button>
        </div>
      </div>
    </el-main>
    <el-footer class="footer">
      <comment-input-field :sendComment="editComment"/>
    </el-footer>
  </el-container>
</template>

<script lang="ts">
import { Vue, Component, Watch } from "vue-property-decorator";
import { fetchCommentById, editComment } from "../../api/comment";
import { isSuccessResponse, extractErrorMessageList } from "../../api/utils";
import { Comment } from "../../commonTypes";
import { Route } from "vue-router";
import CommentRow from "../../components/CommentRow.vue";
import CommentInputField from "../../components/CommentInputField.vue";
import { deleteComment } from "../../api/comment";
import { FailuerApiResponse } from "../../api/types";

Component.registerHooks(["beforeRouteEnter"]);
@Component({ components: { CommentRow, CommentInputField } })
export default class CommentEdit extends Vue {
  private comment_: Comment | {} = {};

  get comment() {
    return this.comment_ as Comment;
  }

  beforeRouteEnter(to: Route, from: Route, next: Function) {
    const commentId = parseInt(to.params.commentId);

    fetchCommentById({ comment_id: commentId }).then(response => {
      if (isSuccessResponse(response))
        next((vm: any) => (vm.comment_ = response.content.comment));
    });
  }

  deleteComment() {
    deleteComment({
      comment_id: this.comment.comment_id
    }).then(response => {
      isSuccessResponse(response)
        ? this.$router.push(`/main/board/${this.comment.board_id}`)
        : this.onFail(response);
    });
  }

  editComment(comment: string) {
    editComment({
      comment_id: this.comment.comment_id,
      new_content: comment
    }).then(response => {
      isSuccessResponse(response)
        ? this.$router.push(`/main/board/${this.comment.board_id}`)
        : this.onFail(response);
    });
  }

  onFail<T>(response: FailuerApiResponse<T>) {
    const errorMessage = extractErrorMessageList(response).join("</br>");
    alert(errorMessage);
  }
}
</script>

<style scoped>
.comment-conteiner > div:not(:last-child) {
  margin-bottom: 10px;
}
</style>