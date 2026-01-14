<template>
  <div class="dashboard-stats d-flex gap-4 mb-4">
    <div class="stat-card p-3 bg-white rounded shadow-sm">
      <h5>Utilisateurs</h5>
      <p>{{ stats.users }}</p>
    </div>
    <div class="stat-card p-3 bg-white rounded shadow-sm">
      <h5>Tâches</h5>
      <p>{{ stats.tasks }}</p>
    </div>
  </div>
</template>

<script>
import api from "../services/api";

export default {
  data() {
    return { stats: { users: 0, tasks: 0 } };
  },
  async created() {
    try {
     //const response = await api.get("stats.php");
      //this.stats = response.data;
    } catch (err) { console.error(err); }
  },
};
</script>

<style scoped>
.dashboard-stats { display: flex; gap: 20px; }
.stat-card { flex: 1; text-align: center; }
</style>
