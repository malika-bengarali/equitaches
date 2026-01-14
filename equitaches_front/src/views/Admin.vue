<template>
  <div class="admin-layout">
    <!-- Sidebar -->
    <BarreLaterale />

    <!-- Contenu principal -->
    <div class="main-content">
      <!-- Header -->
       <Entete :utilisateur="utilisateur" :titre="titre" />

      <!-- Contenu des pages -->
      <div class="page-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import BarreLaterale from "../components/BarreLaterale.vue";
import Entete from "../components/Entete.vue";
import { getUser } from "../services/api.js";

export default {
  name: "Admin",
  components: { BarreLaterale, Entete },
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
}

.main-content {
  display: flex;
  flex-direction: column;
  flex: 1;
}

.page-content {
  flex: 1;
  overflow: auto;
  padding: 20px;
}
</style>
