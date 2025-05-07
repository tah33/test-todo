import {createRouter, createWebHistory} from "vue-router";
import {useAuthStore} from '../store/Auth.js'

const routes = [
    {
        path: "/",
        children: [
            {
                path: "login",
                name: "login",
                component: () => import("../views/Login.vue"),
                meta: {forGuestsOnly: true}
            },
            {
                path: "/register",
                name: "register",
                component: () => import("../views/Register.vue"),
                meta: {forGuestsOnly: true}
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

router.beforeEach(async (to) => {
    const authStore = useAuthStore();

    if (to.meta.requiredAuth && !authStore.token) {
        return {
            name: 'login',
            query: { redirect: to.fullPath }
        };
    }

    if (to.meta.forGuestsOnly && authStore.token) {
        return { name: 'tasks' };
    }

    return true;
});

export default router;
