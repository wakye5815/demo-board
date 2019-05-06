<template>
  <router-view/>
</template>

<script lang="ts">
import { Vue, Component,Watch } from "vue-property-decorator";
import { ElLoadingComponent } from "element-ui/types/loading";

@Component
export default class App extends Vue {
  private loadingComponent!: ElLoadingComponent;

  get isLoading(): boolean {
    return this.$store.getters.isLoading;
  }
  
  @Watch("isLoading", { immediate: false, deep: false })
  appearOrDisappearLoadingMask() {
    if (this.isLoading) {
      this.loadingComponent = this.$loading({
        lock: true,
        text: "Loading",
        spinner: "el-icon-loading",
        background: "rgba(0, 0, 0, 0.7)"
      });
    }else{
      this.loadingComponent.close();
    }
  }
}
</script>

<style scoped>
</style>