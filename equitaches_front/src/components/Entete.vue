<template>
  <div class="header-container">
    <div class="d-flex justify-content-between align-items-center header-box">
      <h4 class="fw-bold mb-0">
        <i class="bi bi-house-door-fill me-2"></i>{{ titre ? capitalize(titre) : 'Tableau de bord' }}
      </h4>
      <div class="d-flex align-items-center gap-3 user-box">
        <span><i class="bi bi-person-circle"></i> {{ utilisateur.nom || 'Invité' }}</span>
        <button @click="logout" class="btn btn-sm btn-purple">Déconnexion</button>
      </div>
    </div>
  </div>
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
.header-container {
  padding: 16px 24px 12px 24px;
  background-color: #f8f9fa;
}

.header-box {
  background: linear-gradient(135deg, #ffffff, #e9ecef);
  padding: 20px 25px;
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}

.btn-purple {
  background: linear-gradient(135deg, #f77efc, #a346c8, #490eec);
  color: white;
  border: none;
  padding: 6px 16px;
  border-radius: 6px;
  transition: all 0.3s ease;
}

.btn-purple:hover {
  background: linear-gradient(135deg, #aa46c8, #6c63ff);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3);
}
</style>