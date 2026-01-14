<template>
<div class="auth-page">
  <div class="auth-card">
    <h2 class="auth-title">Inscription</h2>

    <form @submit.prevent="submit">
      <div class="form-group">
        <i class="bi bi-person"></i>
        <input v-model="nom" placeholder="Nom complet" required />
      </div>

      <div class="form-group">
        <i class="bi bi-envelope"></i>
        <input v-model="email" type="email" placeholder="Email" required />
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

      <button class="btn-auth">Créer le compte</button>

      <div class="auth-error">{{ message }}</div>

      <div class="auth-footer">
        Déjà un compte ?
        <router-link to="/login">Se connecter</router-link>
      </div>
    </form>
  </div>
  </div>
</template>

<script>
import { register } from "../services/api";

export default {
  data() {
    return {
      nom: "",
      email: "",
      mot_de_passe: "",
      message: "",
    };
  },
  methods: {
    async submit() {
      // Crée un objet avec seulement les champs nécessaires
      const userData = {
        nom: this.nom,
        email: this.email,
        mot_de_passe: this.mot_de_passe,
      };

      try {
        const res = await register(userData);
        // Vérifie le succès et affiche le message
        this.message = res.data.message;
        if (res.data.success) {
          this.$router.push("/login");
        }
      } catch (error) {
        // Affiche le message d'erreur du serveur si disponible
        this.message =
          error.response?.data?.message || "Erreur serveur, réessaye plus tard.";
      }
    },
  },
};
</script>
