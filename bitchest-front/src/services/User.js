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

    getAllCurrencies() {
        return Api.get("/admin");
    }
};


