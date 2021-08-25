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

    getAllAdminCurrencies() {
        return Api.get("/admin");
    },
    getAllUsers() {
        return Api.get("/admin/user-list");
    },
    addUser(user) {
        return Api.post("/admin/add-user", user);
    },
    getAllUserCurrencies() {
        return Api.get("/client");
    }
};


