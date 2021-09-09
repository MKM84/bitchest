import Api from "./Api";
import Csrf from "./Csrf";


export default {

    // get csrf kookie nessessary to login
    async login(form) {
        await Csrf.getCookie();
        return Api.post("/login", form);
    },
    // logout
    async logout() {
        await Csrf.getCookie();
        return Api.post("/logout");
    },
    // authentificated user
    auth() {
        return Api.get("/user");
    },
    // get all cryptos for admin
    getAllAdminCryptos() {
        return Api.get("/admin");
    },
    // get user list for admin
    getAllUsers() {
        return Api.get("/admin/user-list");
    },
    // add new user / admin
    addUser(user) {
        return Api.post("/admin/add-user", user).then((r) => sendActionResult(r));
    },
    // edit user
    editUser(user) {
        return Api.put(`admin/edit-user/${user.id}`, user).then((r) => sendActionResult(r));
    },
    // delete user
    deleteUser(id) {
        return Api.delete(`admin/delete-user/${id}`).then((r) => sendActionResult(r));
    },
    getAdminInfos() {
        return Api.get('admin/admin-infos/');
    },
    AdminEditMyProfile(admin) {
        return Api.put(`admin/edit-user/${admin.id}`, admin).then((r) => sendActionResult(r));
    },
    // get cryptos list for client
    getAllUserCryptos() {
        return Api.get("/client");
    },
    // get user wallet iformations
    getUserWallet() {
        return Api.get("/client/user-wallet");
    },
    // get client transactions history
    getUserHistory() {
        return Api.get('/client/purchase-history');
    },
    // get transaction to sell by id
    getCryptoToSell(id) {
        return Api.get(`client/user-sell-crypto/${id}`);
    },
    // get the user informations
    getUserInfos() {
        return Api.get("client/user-infos");
    },
    // edit user
    editUserInfos(user) {
        return Api.put(`/client/edit-user-infos/${user.id}`, user).then((r) => sendActionResult(r));
    },
    // get crypto evolution for the passed 30 day
    getCryptoEvolution(id) {
        return Api.get(`client/crypto-graph/${id}`);
    },
    // buy some crypto
    ByNewCryptos(crypto) {
        return Api.post("/client/add-transaction", crypto).then((r) => sendActionResult(r));
    },
    // sell transaction (crypto)
    sellCryptos(id) {
        return Api.patch(`/client/sell-transaction/${id}`).then((r) => sendActionResult(r));

    }
};

// verify if the respose is done
const sendActionResult = (r) => {
    if (r.statusText == 'OK' && r.data.done == true) {
        return r.data;
    } else {
        return {
            done: false
        };
    }
};
