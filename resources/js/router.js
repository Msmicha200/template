import VueRouter from 'vue-router';
import Index from './pages/Index';

export default new VueRouter ({
    routes: [
        {
            path: '/',
            component: Index
        }
    ],
    mode: 'history'
})