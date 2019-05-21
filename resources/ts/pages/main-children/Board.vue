<template>
  <el-container style="height:100%">
    <el-header>
      <p>
        <span style="font-size:30px;">{{board.name}}</span>
        作成者:{{board.owner_user.name}}
      </p>
    </el-header>
    <el-main>
      <div class="comment-conteiner">
        <component
          class="comment"
          v-for="(comment, i) in commentList"
          :key="i"
          :is="comment.is_reply ? 'reply-comment-row':'comment-row'"
          :comment="comment"
          @click.native="()=>{if(!comment.is_deleted){displayCommentDialog(comment)}}"
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
import ReplyCommentRow from "../../components/ReplyCommentRow.vue";
import CommentDialog from "../../components/CommentDialog.vue";
import CommentInputField from "../../components/CommentInputField.vue";
import store from "../../store";
import { createBoardModule } from "../../store/board";

Component.registerHooks(["beforeRouteEnter"]);
@Component({
  components: { CommentRow, ReplyCommentRow, CommentInputField, CommentDialog }
})
export default class Board extends Vue {
  beforeRouteEnter(to: Route, from: Route, next: Function) {
    const moduleName = to.params.boardId;
    // モジュール登録済か確認
    if (typeof (store.state as any)[moduleName] == "undefined")
      store.registerModule(moduleName, createBoardModule());

    store
      .dispatch(`${moduleName}/initialize`, to.params.boardId)
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
      await this.$store.dispatch(`${this.$route.params.boardId}/update`);
    } else {
      const errorMessage = extractErrorMessageList(response).join("</br>");
      alert(errorMessage);
    }
  }

  displayCommentDialog(comment: Comment) {
    this.$store.commit("commentDialog/comment", comment);
    this.$store.commit("commentDialog/canDisplay", true);
  }
}
</script>

<style scoped>
.comment-conteiner > div:not(:last-child) {
  margin-bottom: 10px;
}

.comment {
  position: relative;
}

.comment:hover::after {
  top: 0;
  position: absolute;
  content: "";
  display: block;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.3);
}
</style>