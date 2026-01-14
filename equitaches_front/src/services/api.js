import axios from "axios";

const api = axios.create({
  baseURL: "http://localhost/equitaches/equitaches_api/",
  headers: { "Content-Type": "application/json" },
  withCredentials: true
});

export default api;

export const login = (user) => api.post("login.php", user);
export const register = (user) => api.post("register.php", user);
export const logout = () => api.get("logout.php");
export const getUser = () => api.get("get_user.php");
export const getTaches = () => api.get("get_taches.php");
export const addTache = (tache) => api.post("add_tache.php", tache);
export const updateTache = (tache) => api.post("update_tache.php", tache);
export const deleteTache = (id) => api.get(`delete_tache.php?id=${id}`);