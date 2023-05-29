import axios from "axios";

const ApiService = axios.create({
  baseURL: "http://localhost:80/api",
  timeout: 50000,
  headers: {
    Accept: "*/*",
    "Content-Type": "application/json",
  },
});

export default ApiService;
