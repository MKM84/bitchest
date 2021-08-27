export default {

isLoggedIn() {
    const isAuth = localStorage.getItem("auth")
    return isAuth;
},
isAdmin() {
    const isAdmin = localStorage.getItem("admin")
    return isAdmin;
}
};
