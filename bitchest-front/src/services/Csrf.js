import Api from "./Api";
import Cookie from "js-cookie";

export default {
    // get csrf kookie nessessary to login
  getCookie() {
    let token = Cookie.get("XSRF-TOKEN");

    if (token) {
      return new Promise(resolve => {
        resolve(token);
      });
    }
    return Api.get("/csrf-cookie");
  }
};
