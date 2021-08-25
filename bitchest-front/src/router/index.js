import {
    createRouter,
    createWebHistory
} from 'vue-router';

import Login from "../pages/Login.vue";
import AdminAllCryptos from "../pages/admin/AdminAllCryptos.vue";
import UserList from "../pages/admin/UserList.vue";
import AddUser from "../pages/admin/AddUser.vue";
import EditUser from "../pages/admin/EditUser.vue";

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

    // Admin route
    {
        path: '/admin',
        name: 'AdminAllCryptos',
        component: AdminAllCryptos,
        meta: {
            authOnly: true,
            adminOnly: true
        }
    },
    {
        path: '/admin/user-list',
        name: 'UserList',
        component: UserList,
        meta: {
            authOnly: true,
            adminOnly: true

        }
    },
    {
        path: '/admin/add-user',
        name: 'AddUser',
        component: AddUser,
        meta: {
            authOnly: true,
            adminOnly: true

        }
    },
    {
        path: '/admin/edit-user/:id',
        name: 'EditUser',
        component: EditUser,
        meta: {
            authOnly: true,
            adminOnly: true

        }
    },

        // Client routes
    {
        path: '/client',
        name: 'UserAllCryptos',
        component: UserAllCryptos,
        meta: {
            authOnly: true,
            clientOnly: true
        }
    },
    {
        path: '/client/user-wallet',
        name: 'UserWallet',
        component: UserAllCryptos,
        meta: {
            authOnly: true,
            clientOnly: true
        }
    },
    {
        path: '/client/user-purchases',
        name: 'UserPurchases',
        component: UserAllCryptos,
        meta: {
            authOnly: true,
            clientOnly: true
        }
    },
    {
        path: '/client/User-Sell-crypto',
        name: 'UserSellCrypto',
        component: UserAllCryptos,
        meta: {
            authOnly: true,
            clientOnly: true
        }
    },
    {
        path: '/client/user-form',
        name: 'UserSellCrypto',
        component: UserAllCryptos,
        meta: {
            authOnly: true,
            clientOnly: true
        }
    },


        // 404 route
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

function isAdmin() {
    return localStorage.getItem("admin");
}

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
        if (isLoggedIn() && isAdmin() === 'true') {
            next({
                path: "/admin",
                query: {
                    redirect: to.fullPath
                }
            });

        }
        else if (isLoggedIn() && isAdmin() === 'false') {
            next({
                path: "/client",
                query: {
                    redirect: to.fullPath
                }
            });
        } else {
            next(); // make sure to always call next()!
        }
    } else {
        next(); // make sure to always call next()!
    }
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.adminOnly)) {
        if (isLoggedIn() && isAdmin() === 'false') {
            next({
                path: "/client",
                query: {
                    redirect: to.fullPath
                }
            });
        }
        else {
            next();
        }
    }
    else if (to.matched.some(record => record.meta.clientOnly)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (isLoggedIn() && isAdmin() === 'true') {
            next({
                path: "/admin",
                query: {
                    redirect: to.fullPath
                }
            });

        } else {
            next(); // make sure to always call next()!
        }
    } else {
        next(); // make sure to always call next()!
    }
});
export default router;
