import VueRouter from 'vue-router';
import Index from './pages/Index';

const router = new VueRouter ({
    routes: [
        {
            path: '/',
            component: Index
        }
    ],
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    window.scrollTo(0, 0);
    next();
});

export default router;