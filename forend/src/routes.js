import Login from './views/Login.vue'
import NotFound from './views/404.vue'
import Home from './views/Home.vue'
import Main from './views/Main.vue'

import VideoList from './views/video/list.vue'
import EventList from './views/event/list.vue'

let routes = [
    {
        path: '/login',
        component: Login,
        name: '',
        hidden: true
    },
    {
        path: '/404',
        component: NotFound,
        name: '',
        hidden: true
    },
    //{ path: '/main', component: Main },
    {
        path: '/',
        component: Home,
        name: '教学视频',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            { path: '/video', component: VideoList, name: '教学视频查看' }
        ]
    },
    {
        path: '/',
        component: Home,
        name: '事件记录',
        iconCls: 'el-icon-message',//图标样式class
        children: [
            { path: '/event', component: EventList, name: '社团事件' }
        ]
    },
    {
        path: '*',
        hidden: true,
        redirect: { path: '/404' }
    }
];

export default routes;