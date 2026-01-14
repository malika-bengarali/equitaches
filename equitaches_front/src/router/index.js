import { createRouter, createWebHistory } from "vue-router";
import { getCurrentUser } from "../services/auth";

import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Admin from "../views/Admin.vue";
import Member from "../views/Member.vue";
import Dashboard from "../views/admin/Dashboard.vue";
import Users from "../views/admin/Users.vue";

const routes = [
  { path: "/", redirect: "/login" },
  { path: "/login", name: 'Login', component: Login },
  { path: "/register", name: 'Register', component: Register },
  { 
    path: "/admin", 
    name: 'Admin',
    component: Admin,
    meta: { requiresAuth: true, role: 'admin' },
    children: [
      { path: "", name: 'Dashboard', component: Dashboard },
      { path: "users", name: 'Users', component: Users },
    ],
  },
  { 
    path: "/member",  
    name: 'Member',
    component: Member,
    meta: { requiresAuth: true, role: 'membre' }
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// 🔐 Protection des routes avec vérification session PHP
router.beforeEach(async (to, from, next) => {
  // Routes publiques (pas besoin de vérifier)
  if (to.path === "/login" || to.path === "/register") {
    next();
    return;
  }

  // Routes protégées
  if (to.meta.requiresAuth) {
    const user = await getCurrentUser();
    
    if (!user) {
      // Pas de session active
      next("/login");
    } else if (to.meta.role && to.meta.role !== user.role) {
      // Rôle incorrect
      next("/login");
    } else {
      // Tout est OK
      next();
    }
  } else {
    next();
  }
});

export default router;