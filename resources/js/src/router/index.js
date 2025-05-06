import {createRouter, createWebHistory} from "vue-router";
import {useAuthStore} from '../store/Auth.js'

const routes = [
    {
        path: "/",
        children: [
            {
                path: "/login",
                name: "login",
                component: () => import("../views/Login.vue"),
                meta: {requiredAuth: false}
            },
            {
                path: "/register",
                name: "register",
                component: () => import("../views/Register.vue"),
                meta: {requiredAuth: false}
            },
            {
                path: "/tasks",
                name: "tasks",
                component: () => import("../views/Task.vue"),
                meta: {requiredAuth: true}
            },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return {left: 0, top: 0};
        }
    },
});

router.beforeEach(async (to,from) => {
    const authStore = useAuthStore();

    if (to.meta.requiredAuth && !authStore.isAuthenticated) {
        await router.push('/login');
    }

    if (to.meta.requiredAuth && authStore.isAuthenticated) {
        next();
    }
});

export default router;
