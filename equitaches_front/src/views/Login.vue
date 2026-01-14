<template>
  <div class="auth-page">
    <div class="auth-card">
      <div class="auth-header">
        <h2 class="auth-title">Connexion</h2>
      </div>

      <form @submit.prevent="loginUser">
        <div class="form-group">
          <i class="bi bi-envelope"></i>
          <input
            v-model="email"
            type="email"
            placeholder="Email"
            required
          />
        </div>

        <div class="form-group">
          <i class="bi bi-lock"></i>
          <input
            v-model="mot_de_passe"
            type="password"
            placeholder="Mot de passe"
            required
          />
        </div>

        <button class="btn-auth" type="submit">Se connecter</button>

        <div class="auth-error">{{ message }}</div>

        <div class="auth-footer">
          Pas encore de compte ?
          <router-link to="/register">Créer un compte</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { login } from "../services/api";
import router from "../router";

export default {
  data() {
    return {
      email: "",
      mot_de_passe: "",
      message: ""
    };
  },
  methods: {
    async loginUser() {
      try {
        const res = await login({ email: this.email, mot_de_passe: this.mot_de_passe });
        console.log("Réponse API :", res.data);
        if (res.data.success) {
          const role = res.data.user.role;

          // Redirection selon le rôle
          if (role === "admin") {
            router.push("/admin");
          } else if (role === "membre") {
            router.push("/member");
          } else {
            this.message = "Rôle inconnu, impossible de se connecter";
          }
        } else {
          // Erreur d'email ou mot de passe
          this.message = res.data.message;
        }
      } catch (err) {
        console.error("Erreur Axios :", err.response || err);
        this.message = "Erreur serveur, réessayez plus tard.";
      }
    }
  }
};
</script>
