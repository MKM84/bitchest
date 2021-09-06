import {
    createRouter,
    createWebHistory
} from 'vue-router';

// login component
import Login from "../pages/Login.vue";

// admin components
import Admin from "../pages/admin/Admin.vue"
import AdminAllCryptos from "../pages/admin/AdminAllCryptos.vue";
import Users from "../pages/admin/Users.vue";
import AdminUserForm from "../pages/admin/AdminUserForm.vue";

// cliet components
import Client from "../pages/client/Client.vue"
import UserAllCryptos from "../pages/client/UserAllCryptos.vue";
import UserForm from "../pages/client/UserForm.vue";
import UserWallet from "../pages/client/UserWallet.vue";
import PurchaseHistory from "../pages/client/PurchaseHistory.vue";
import UserSellCrypto from "../pages/client/UserSellCrypto.vue";
import CryptoGraph from "../pages/client/CryptoGraph.vue"
import BuyCrypto from "../pages/client/BuyCrypto.vue"

// 404 component
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
        name: 'Admin',
        component: Admin,
        meta: {
            authOnly: true,
            adminOnly: true
        },
        redirect: '/admin/cryptos',

        children: [{
                path: 'cryptos',
                name: 'AdminAllCryptos',
                component: AdminAllCryptos,
                meta: {
                    authOnly: true,
                    adminOnly: true
                }
            },
            {
                path: 'user-list',
                name: 'Users',
                component: Users,
                meta: {
                    authOnly: true,
                    adminOnly: true

                }
            },

            {
                path: 'user-form/:id',
                name: 'AdminUserForm',
                component: AdminUserForm,
                meta: {
                    authOnly: true,
                    adminOnly: true

                }
            }
        ]
    },


    // Client routes
    {
        path: '/client',
        name: 'Client',
        component: Client,
        meta: {
            authOnly: true,
            clientOnly: true
        },
        redirect: '/client/cryptos',
        children: [{
                path: 'cryptos',
                name: 'UserAllCryptos',
                component: UserAllCryptos,
                meta: {
                    authOnly: true,
                    clientOnly: true
                },
            },
            {
                path: 'user-wallet',
                name: 'UserWallet',
                component: UserWallet,
                meta: {
                    authOnly: true,
                    clientOnly: true
                }
            },
            {
                path: 'purchase-history',
                name: 'PurchaseHistory',
                component: PurchaseHistory,
                meta: {
                    authOnly: true,
                    clientOnly: true
                }
            },
            {
                path: 'user-sell-crypto/:id',
                name: 'UserSellCrypto',
                component: UserSellCrypto,
                meta: {
                    authOnly: true,
                    clientOnly: true
                }
            },
            {
                path: 'user-form',
                name: 'UserForm',
                component: UserForm,
                meta: {
                    authOnly: true,
                    clientOnly: true
                }
            },
            {
                path: 'crypto-graph/:id',
                name: 'CryptoGraph',
                component: CryptoGraph,
                meta: {
                    authOnly: true,
                    clientOnly: true
                }
            },
            {
                path: 'buy-crypto/:id',
                name: 'BuyCrypto',
                component: BuyCrypto,
                meta: {
                    authOnly: true,
                    clientOnly: true
                }
            }
        ]
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

// redirection system : auth then admin or client

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

        if (isLoggedIn() && isAdmin() === 'true') {
            next({
                path: "/admin",
                query: {
                    redirect: to.fullPath
                }
            });

        }
        if (isLoggedIn() && isAdmin() === 'false') {
            next({
                path: "/client",
                query: {
                    redirect: to.fullPath
                }
            });
        } else {
            next();
        }
    } else {
        next();
    }
});


export default router;
