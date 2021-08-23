import axios from "axios";

let Api = axios.create({
  baseURL: "http://localhost:8000/api",
  withCredentials : true
});

// Api.defaults.withCredentials = true;

export default Api;
