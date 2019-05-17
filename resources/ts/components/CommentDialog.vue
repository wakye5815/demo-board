<template>
  <el-dialog
    title="コメント詳細"
    :visible.sync="isVisible"
    width="65%"
    :before-close="() => { currentActionType = actionType.NONE; onClose();}"
  >
    <comment-row :comment="comment"/>
    <span slot="footer" class="dialog-footer">
      <div class="button-container" v-if="currentActionType == actionType.NONE">
        <el-button
          type="primary"
          v-if="isMyComment"
          @click="currentActionType = actionType.EDIT"
        >Edit</el-button>
        <el-button
          type="danger"
          v-if="isMyComment"
          @click="currentActionType = actionType.DELETE"
        >Delete</el-button>
        <el-button
          type="primary"
          v-if="!isMyComment"
          @click="currentActionType = actionType.REPLY"
        >Reply</el-button>
      </div>
      <comment-input-field v-if="canDisplayInputField" :sendComment="() => {}"/>
    </span>
  </el-dialog>
</template>

<script lang="ts">
import { Vue, Component, Prop, Watch } from "vue-property-decorator";
import { Comment } from "../commonTypes";
import CommentRow from "./CommentRow.vue";
import CommentInputField from "./CommentInputField.vue";

@Component({ components: { CommentRow, CommentInputField } })
export default class CommentDialog extends Vue {
  private readonly actionType = {
    NONE: 0,
    DELETE: 1,
    EDIT: 2,
    REPLY: 3
  };

  private currentActionType = this.actionType.NONE;

  @Prop({ type: Boolean, required: true })
  private isVisible!: boolean;

  @Prop({
    type: Object,
    required: false,
    default: () => {
      return {
        comment_id: 0,
        board_id: 0,
        content: "",
        owner_id: 0,
        owner_name: "",
        created_at: "",
        updated_at: ""
      };
    }
  })
  private comment!: Comment;

  @Prop({ type: Function, required: false, default: () => {} })
  private onClose!: () => void;

  @Watch("currentActionType", { immediate: false })
  onDecideActionType() {
    console.log(this.currentActionType);
  }

  get isMyComment() {
    return this.$store.getters.loginUser.id == this.comment.owner_id;
  }

  get canDisplayInputField() {
    return (
      this.currentActionType == this.actionType.EDIT ||
      this.currentActionType == this.actionType.REPLY
    );
  }
}
</script>

<style scoped>
</style>