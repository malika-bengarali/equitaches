<template>
  <main class="flex-fill p-4 overflow-auto main-content">
    <div class="d-flex justify-content-between align-items-center mb-4 header-box">
      <h4 class="fw-bold">
        <i class="bi bi-house-door-fill me-2"></i>{{ titre ? capitalize(titre) : 'Tableau de bord' }}
      </h4>
      <div class="d-flex align-items-center gap-3 user-box">
        <span><i class="bi bi-person-circle"></i> {{ utilisateur.nom || 'Invité' }}</span>
        <button @click="logout" class="btn btn-sm btn-purple">Déconnexion</button>
      </div>
    </div>
  </main>
</template>

<script>
import { logout } from "../services/api";

export default {
  props: {
    titre: { type: String, default: '' },
    utilisateur: { type: Object, default: () => ({ nom: 'Invité', role: 'guest' }) }
  },
  methods: {
    capitalize(str) {
      return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
    },
    async logoutUser() {
      try {
        await logout(); // Appel API logout.php
      } catch(e) { console.error(e); }
      finally {
        localStorage.removeItem("utilisateur");
        localStorage.removeItem("role");
        window.location.href = "/login";
      }
    },
    logout() { this.logoutUser(); }
  }
};
</script>

<style scoped>
.header-box {
  background: linear-gradient(135deg, #ffffff, #e9ecef);
  padding: 20px 25px;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}
.btn-purple {
  background-color: #6f42c1;
  color: white;
  border: none;
  padding: 4px 10px;
  border-radius: 6px;
}
</style>
