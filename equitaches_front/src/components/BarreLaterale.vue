<template>
  <aside class="sidebar d-flex flex-column p-3">
    <div class="text-center mb-4">
      <img src="@/assets/images/logo1.png" alt="Logo" class="sidebar-logo mb-3" />
      <h5 class="text-purple fw-bold">ÉQUITÂCHES</h5>
    </div>
    <nav class="nav flex-column gap-2">
  <router-link to="/admin" class="nav-link"><i class="bi bi-speedometer2 me-2"></i>Dashboard</router-link>
  <router-link to="/admin/users" class="nav-link"><i class="bi bi-people-fill me-2"></i>Utilisateurs</router-link>
 
</nav>

  </aside>
</template>

<script>
export default {};
</script>

<style scoped>
.sidebar {
  width: 220px;
  background-color: #2e2e3a;
  color: #fff;
  height: 100vh;
  box-shadow: 2px 0 12px rgba(0,0,0,0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  position: sticky;
  top: 0;
}
.sidebar .nav-link {
  color: #ccc;
  padding: 10px 15px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  text-decoration: none;
  transition: all 0.2s;
}
.sidebar .nav-link:hover {
  color: #fff;
  background-color: #4b4b5c;
  transform: translateX(3px);
}
.sidebar .nav-link.active {
  background: linear-gradient(135deg, #d1abf8, #5146c8);
  color: #fff !important;
}
.sidebar-logo {
  width: 70px;
  height: auto;
  border-radius: 8px;
}
.text-purple {
    color: #faaef4;
    text-shadow:2px 0 12px #a346c8;
}
</style>
