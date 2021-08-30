import Api from "./Api";
import Csrf from "./Csrf";


export default {

    async login(form) {
        await Csrf.getCookie();

        return Api.post("/login", form);
    },

    async logout() {
        await Csrf.getCookie();

        return Api.post("/logout");
    },

    auth() {
        return Api.get("/user");
    },

    getAllAdminCryptos() {
        return Api.get("/admin");
    },
    getAllUsers() {
        return Api.get("/admin/user-list");
    },
    addUser(user) {
        return Api.post("/admin/add-user", user).then((r) => sendActionResult(r));
    },
    editUser(user) {
        return Api.put(`admin/edit-user/${user.id}`, user).then((r) => sendActionResult(r));
    },
    deleteUser(id) {
        return Api.delete(`admin/delete-user/${id}`).then((r) => sendActionResult(r));
    },
    getAllUserCryptos() {
        return Api.get("/client");
    },
    getUserWallet() {
        return Api.get("client/user-wallet");
    },
    getUserInfos() {
        return Api.get("client/user-infos");
    },
    editUserInfos(user) {
        return Api.put(`/client/edit-user-infos/${user.id}`, user).then((r) => sendActionResult(r));
    }
};

const sendActionResult = (r) => {
	if (r.statusText == 'OK' && r.data.done == true) {
		return r.data;
	} else {
		return { done: false };
	}
};

