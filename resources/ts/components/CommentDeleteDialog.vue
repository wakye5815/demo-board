<template>
  <el-dialog
    title="本当に削除しますか？"
    :visible.sync="canDisplay"
    width="40%"
    :before-close="closeDialog"
    append-to-body
  >
    <span slot="footer">
      <el-button type="danger" @click="deleteComment">Delete</el-button>
      <el-button type="primary" @click="closeDialog">Cancel</el-button>
    </span>
  </el-dialog>
</template>

<script lang="ts">
import { Vue, Component, Prop } from "vue-property-decorator";
import { Comment } from "../commonTypes";
import { deleteComment } from "../api/comment";
import { isSuccessResponse, extractErrorMessageList } from "../api/utils";

@Component
export default class CommentDeleteDialog extends Vue {
  @Prop({ type: Object, required: true })
  private comment!: Comment;

  @Prop({ type: Function, required: false, default: () => {} })
  private onClose!: () => void;

  get canDisplay() {
    return this.$store.state["commentDeleteDialog"].canDisplay;
  }

  async deleteComment() {
    const response = await deleteComment({
      comment_id: this.comment.id
    });
    if (isSuccessResponse(response)) {
      await this.$store.dispatch(`${this.comment.board_id}/update`);
    } else {
      const errorMessage = extractErrorMessageList(response).join("br");
      alert(errorMessage);
    }
    this.closeDialog();
  }

  closeDialog() {
    this.$store.commit("commentDeleteDialog/canDisplay", false);
    this.onClose();
  }
}
</script>