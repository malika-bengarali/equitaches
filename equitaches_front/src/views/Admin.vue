<template>
  <div class="admin-layout">
    <!-- Sidebar -->
    <BarreLaterale />

    <!-- Contenu principal -->
    <div class="main-content">
      <!-- Header -->
      <Entete :utilisateur="utilisateur" :titre="titre" />
      
      <!-- Dashboard Stats -->
      <div class="content-wrapper">
        <DashboardStats />
        
        <!-- Contenu des pages -->
        <!-- <div class="page-content">
          <router-view />
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import BarreLaterale from "../components/BarreLaterale.vue";
import Entete from "../components/Entete.vue";
import DashboardStats from "../components/DashboardStats.vue";
import { getUser } from "../services/api.js";

export default {
  name: "Admin",
  components: { BarreLaterale, Entete, DashboardStats },
  data() {
    return {
      utilisateur: { nom: 'Invité', role: 'guest' },
      titre: "Tableau de bord"
    };
  },
  async created() {
    await this.getUserInfo();
  },
  methods: {
    async getUserInfo() {
      try {
        const response = await getUser();
        if (response.data.success) {
          this.utilisateur = response.data.user;
        }
      } catch (err) {
        console.error("Erreur récupération utilisateur :", err);
      }
    }
  }
};
</script>

<style scoped>
.admin-layout {
  display: flex;
  height: 100vh;
  background-color: #f4f5f7;
  overflow: hidden;
}

.main-content {
  display: flex;
  flex-direction: column;
  flex: 1;
  overflow: hidden;
}

.content-wrapper {
  flex: 1;
  overflow-y: auto;
  padding: 16px 24px;
  background-color: #f8f9fa;
}

.page-content {
  margin-top: 24px;
}
</style>