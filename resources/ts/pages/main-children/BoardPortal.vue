s<template>
  <el-container style="height:100%">
    <el-main>
      <div class="board-info-conteiner">
        <board-info-row 
          :board="board" 
          v-for="(board, index) in boardList"
          :key="index"
          />
      </div>
    </el-main>
    <el-footer class="footer">
      <el-input placeholder="Please input board name" style="width:85%;" v-model="newBoardName"></el-input>
      <el-button type="primary" size="small" @click="createBoard" round>create</el-button>
    </el-footer>
  </el-container>
</template>

<script lang="ts">
import { Vue, Component, Watch } from "vue-property-decorator";
import { createBoard, fetchAllBoard } from "../../api/board";
import { isSuccessResponse, isFailuerResponse, extractErrorMessageList } from "../../api/utils";
import { Board } from "../../commonTypes";
import { Route } from "vue-router";
import BoardInfoRow from "../../components/BoardInfoRow.vue";

Component.registerHooks(["beforeRouteEnter"]);

@Component({ components: { BoardInfoRow } })
export default class BoardPortal extends Vue {
  private boardList: Board[] = [];

  beforeRouteEnter(to: Route, from: Route, next: Function) {
    fetchAllBoard().then(response => {
      if (isSuccessResponse(response))
        next((vm: any) => (vm.boardList = response.content.all_board_list));
    });
  }

  private newBoardName: string = "";
  async createBoard() {
    const response = await createBoard({ name: this.newBoardName });
    if (isSuccessResponse(response)) {
      this.boardList = response.content.all_board_list;
    } else {
      const errorMessage = extractErrorMessageList(response).join("</br>");
      alert(errorMessage);
    }
  }
}
</script>

<style scoped>
.footer {
  display: flex;
  justify-content: space-around;
  align-items: center;
}

.board-info-conteiner > div:not(:last-child) {
  margin-bottom: 10px;
}
</style>