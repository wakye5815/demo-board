import Vue from 'vue'
import VueRouter from 'vue-router'
import Top from '../pages/Top.vue'
import Signup from '../pages/Signup.vue'
import Main from '../pages/Main.vue'
import Board from '../pages/main-children/Board.vue'
import BoardPortal from '../pages/main-children/BoardPortal.vue'
import Error from '../pages/Error.vue'

Vue.use(VueRouter);

const mainRoutes = [
    { path: 'board/:boardId', component: Board },
    { path: 'board-portal', component: BoardPortal }
]

const routes = [
    { path: '/', component: Top },
    { path: '/signup', component: Signup },
    { path: '/main', component: Main, children: mainRoutes },
    { path: '/error', component: Error }
];

const router = new VueRouter({ routes })
export default router