import {
    createRouter,
    createWebHistory
} from 'vue-router';

import Login from "../pages/Login.vue";
import AdminAllCryptos from "../pages/admin/AdminAllCryptos.vue";
import UserAllCryptos from "../pages/client/UserAllCryptos.vue";
import NotFound from "../pages/NotFound.vue";




const routes = [{
        path: '/',
        redirect: '/login'
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            guestOnly: true
        }
    },
    {
        path: '/admin',
        name: 'AdminAllCryptos',
        component: AdminAllCryptos,
        meta: {
            authOnly: true
        }
    },
    {
        path: '/client',
        name: 'UserAllCryptos',
        component: UserAllCryptos,
        meta: {
            authOnly: true
        }
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        component: NotFound
    },



];


const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes,
});

function isLoggedIn() {
    return localStorage.getItem("auth");
}

// function isAdmin() {
//     return localStorage.getItem("admin");
// }

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.authOnly)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!isLoggedIn()) {
            next({
                path: "/login",
                query: {
                    redirect: to.fullPath
                }
            });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.guestOnly)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (isLoggedIn()) {
            // if (isAdmin() == 'true') {
            //     next({
            //         path: "/admin",
            //         query: {
            //             redirect: to.fullPath
            //         }
            //     })
            // } else if (isAdmin() == 'false') {
            //     next({
            //         path: "/client",
            //         query: {
            //             redirect: to.fullPath
            //         }
            //     })
            // }
        } else {
            next();
        }
    } else {
        next(); // make sure to always call next()!
    }
});

export default router;
