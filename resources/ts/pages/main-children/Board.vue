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
        />
      </div>
    </el-main>
    <el-footer>
      <comment-input-field :sendComment="writeComment"/>
    </el-footer>
    <comment-dialog/>
  </el-container>
</template>

<script lang="ts">
import { Vue, Component, Watch } from "vue-property-decorator";
import { createComment } from "../../api/comment";
import { isSuccessResponse, extractErrorMessageList } from "../../api/utils";
import { User, Board as BoardInfo, Comment } from "../../commonTypes";
import { Route } from "vue-router";
import CommentRow from "../../components/CommentRow.vue";
import CommentDialog from "../../components/CommentDialog.vue";
import CommentInputField from "../../components/CommentInputField.vue";
import store from "../../store";
import { createBoardModule } from "../../store/board";

Component.registerHooks(["beforeRouteEnter"]);
@Component({ components: { CommentRow, CommentInputField, CommentDialog } })
export default class Board extends Vue {
  // comment-dialogに渡すProp
  private focusedComment!: Comment;
  private canDisplayCommentDialog = false;

  beforeRouteEnter(to: Route, from: Route, next: Function) {
    store.registerModule(to.params.boardId, createBoardModule());
    store
      .dispatch(`${to.params.boardId}/fetch`, to.params.boardId)
      .then(() => next());
  }

  get board(): BoardInfo {
    return this.$store.state[this.$route.params.boardId].board;
  }

  get commentList(): Comment[] {
    return this.$store.state[this.$route.params.boardId].commentList;
  }

  async writeComment(comment: string) {
    const response = await createComment({
      board_id: this.board.id,
      content: comment
    });

    if (isSuccessResponse(response)) {
      const commentList = response.content.comment_list;
      this.$store.commit(`${this.$route.params.boardId}/update`, commentList);
    } else {
      const errorMessage = extractErrorMessageList(response).join("</br>");
      alert(errorMessage);
    }
  }

  displayCommentDialog(comment: Comment) {
    this.$store.commit("commentDialog/comment", comment);
    this.$store.commit("commentDialog/canDisplay", true);
    // this.focusedComment = comment;
    // this.canDisplayCommentDialog = true;
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