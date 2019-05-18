<template>
  <el-dialog
    title="コメント詳細"
    :visible.sync="canDisplayDialog"
    width="65%"
    :before-close="closeDialog"
  >
    <comment-row :comment="comment"/>
    <span slot="footer">
      <div class="button-container" v-if="currentActionType == actionType.NONE">
        <el-button type="primary" v-if="isMine" @click="currentActionType = actionType.EDIT">Edit</el-button>
        <el-button type="danger" v-if="isMine" @click="currentActionType = actionType.DELETE">Delete</el-button>
        <el-button type="primary" v-if="!isMine" @click="currentActionType = actionType.REPLY">Reply</el-button>
      </div>
      <comment-input-field
        v-if="canDisplayInputField"
        :sendComment="isMine ? editComment : replyComment"
      />
    </span>
    <comment-delete-dialog :comment="comment" :onClose="closeDialog"/>
  </el-dialog>
</template>

<script lang="ts">
import { Vue, Component, Prop, Watch } from "vue-property-decorator";
import { Comment } from "../commonTypes";
import CommentRow from "./CommentRow.vue";
import CommentInputField from "./CommentInputField.vue";
import CommentDeleteDialog from "./CommentDeleteDialog.vue";
import { editComment } from "../api/comment";
import { isSuccessResponse, extractErrorMessageList } from "../api/utils";
import { SuccessApiResponse, FailuerApiResponse } from "../api/types";

@Component({
  components: { CommentRow, CommentInputField, CommentDeleteDialog }
})
export default class CommentDialog extends Vue {
  private readonly actionType = {
    NONE: 0,
    DELETE: 1,
    EDIT: 2,
    REPLY: 3
  };

  private currentActionType = this.actionType.NONE;

  @Watch("currentActionType", { immediate: false })
  onDecideActionType() {
    if (this.currentActionType == this.actionType.DELETE)
      this.$store.commit("commentDeleteDialog/canDisplay", true);
  }

  get comment(): Comment {
    return this.$store.state["commentDialog"].comment;
  }

  get isMine() {
    return this.$store.getters["commentDialog/isMine"];
  }

  get canDisplayDialog() {
    return this.$store.state["commentDialog"].canDisplay;
  }

  get canDisplayInputField() {
    return (
      this.currentActionType == this.actionType.EDIT ||
      this.currentActionType == this.actionType.REPLY
    );
  }

  closeDialog() {
    this.$store.commit("commentDialog/canDisplay", false);
    this.currentActionType = this.actionType.NONE;
  }

  async editComment(comment: string) {
    const response = await editComment({
      comment_id: this.comment.id,
      new_content: comment
    });
    this.processResponse(response);
    this.closeDialog();
  }

  async replyComment(comment: string) {
    // this.processResponse(response);
    // this.closeDialog();
  }

  // commentAPIに対する共通処理
  processResponse<T, U>(
    response:
      | SuccessApiResponse<T & { comment_list: Comment[] }>
      | FailuerApiResponse<U>
  ) {
    if (isSuccessResponse(response)) {
      const commentList = response.content.comment_list;
      this.$store.commit(`${this.comment.board_id}/update`, commentList);
    } else {
      const errorMessage = extractErrorMessageList(response).join("br");
      alert(errorMessage);
    }
  }
}
</script>