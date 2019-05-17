<template>
  <el-container style="height:100%">
    <el-header>
      <p>
        <span style="font-size:30px;">{{board.name}}</span>
        作成者:{{board.owner_name}}
      </p>
    </el-header>
    <el-main>
      <div class="comment-conteiner">
        <comment-row
          class="comment"
          v-for="(comment, i) in commentList"
          :key="i"
          :comment="comment"
          @click.native="displayCommentDialog(comment)"
          :onUpdateComment="setCommentList"
        />
      </div>
    </el-main>
    <el-footer>
      <comment-input-field :sendComment="writeComment"/>
    </el-footer>
    <comment-dialog
      :isVisible="canDisplayCommentDialog"
      :comment="focusedComment"
      :onClose="onCloseCommentDialog"
    />
  </el-container>
</template>

<script lang="ts">
import { Vue, Component, Watch } from "vue-property-decorator";
import { fetchBoardTop } from "../../api/board";
import { createComment } from "../../api/comment";
import { isSuccessResponse, extractErrorMessageList } from "../../api/utils";
import { User, Board as BoardInfo, Comment } from "../../commonTypes";
import { Route } from "vue-router";
import CommentRow from "../../components/CommentRow.vue";
import CommentDialog from "../../components/CommentDialog.vue";
import CommentInputField from "../../components/CommentInputField.vue";

Component.registerHooks(["beforeRouteEnter"]);
@Component({ components: { CommentRow, CommentInputField, CommentDialog } })
export default class Board extends Vue {
  private board_: BoardInfo | {} = {};
  private commentList: Comment[] = [];

  // comment-dialogに渡すProp
  private focusedComment!: Comment;
  private canDisplayCommentDialog = false;

  get board() {
    return this.board_ as BoardInfo;
  }

  beforeRouteEnter(to: Route, from: Route, next: Function) {
    const boardId = parseInt(to.params.boardId);

    fetchBoardTop({ board_id: boardId }).then(response => {
      if (isSuccessResponse(response))
        next((vm: any) => {
          vm.board_ = response.content.board;
          vm.commentList = response.content.comment_list;
        });
    });
  }

  async writeComment(comment: string) {
    const response = await createComment({
      board_id: this.board.id,
      content: comment
    });

    if (isSuccessResponse(response)) {
      this.commentList = response.content.comment_list;
    } else {
      const errorMessage = extractErrorMessageList(response).join("</br>");
      alert(errorMessage);
    }
  }

  setCommentList(commentList: Comment[]) {
    this.commentList = commentList;
  }

  displayCommentDialog(comment: Comment) {
    this.focusedComment = comment;
    this.canDisplayCommentDialog = true;
  }

  onCloseCommentDialog() {
    this.canDisplayCommentDialog = false;
  }
}
</script>

<style scoped>
.comment-conteiner > div:not(:last-child) {
  margin-bottom: 10px;
}

.comment:hover {
  background: rgb(0, 0, 0, 0.05);
}
</style>