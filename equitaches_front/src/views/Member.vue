<template>
  <div class="page">
    <h1>🗂️ Mes Tâches</h1>

    <!-- Formulaire Ajouter / Modifier -->
    <div class="form">
      <input v-model="form.titre" placeholder="Titre de la tâche" />
      <textarea v-model="form.description" placeholder="Description"></textarea>

      <select v-model="form.statut">
        <option>À faire</option>
        <option>En cours</option>
        <option>Terminé</option>
      </select>

      <select v-model="form.priorite">
        <option>Haute</option>
        <option>Moyenne</option>
        <option>Basse</option>
      </select>

      <button @click="save">
        {{ form.id ? "Modifier" : "Ajouter" }}
      </button>
    </div>

    <!-- Liste des tâches -->
    <div v-if="taches.length > 0" class="tasks">
      <div class="task" v-for="t in taches" :key="t.id" v-if="t">
        <div class="task-header">
          <h3>{{ t.titre }}</h3>
          <div class="actions">
            <span @click="edit(t)">✏️</span>
            <span @click="remove(t.id)">🗑️</span>
          </div>
        </div>
        <p>{{ t.description }}</p>
        <div class="meta">
          <span class="statut">{{ t.statut }}</span>
          <span class="priorite">{{ t.priorite }}</span>
        </div>
      </div>
    </div>

    <!-- Message si aucune tâche -->
    <div v-else>
      <p style="text-align:center; color:#777; margin-top:20px;">
        Aucune tâche pour le moment
      </p>
    </div>
  </div>
</template>

<script>
import { getTaches, addTache, updateTache, deleteTache } from "../services/api";

export default {
  data() {
    return {
      taches: [], // ✅ toujours initialisé
      form: {
        id: null,
        titre: "",
        description: "",
        statut: "À faire",
        priorite: "Moyenne",
      },
    };
  },
  methods: {
    // Charger les tâches depuis l'API
    async load() {
      try {
        const res = await getTaches();
        this.taches = res.data && Array.isArray(res.data) ? res.data : [];
      } catch (err) {
        console.error(err);
        this.taches = [];
      }
    },

    // Ajouter ou modifier une tâche
    async save() {
      if (!this.form.titre) return;

      try {
        if (this.form.id) {
          await updateTache(this.form); // Modifier
        } else {
          await addTache(this.form); // Ajouter
        }
        this.reset();
        await this.load();
      } catch (err) {
        console.error(err);
      }
    },

    // Préparer une tâche pour édition
    edit(t) {
      if (!t) return;
      this.form = { ...t };
      window.scrollTo({ top: 0, behavior: "smooth" });
    },

    // Supprimer une tâche
    async remove(id) {
      if (!id) return;
      if (confirm("Supprimer cette tâche ?")) {
        try {
          await deleteTache(id);
          await this.load();
        } catch (err) {
          console.error(err);
        }
      }
    },

    // Réinitialiser le formulaire
    reset() {
      this.form = {
        id: null,
        titre: "",
        description: "",
        statut: "À faire",
        priorite: "Moyenne",
      };
    },
  },

  // Charger les tâches au montage
  mounted() {
    this.load();
  },
};
</script>

<style scoped>
.page {
  max-width: 900px;
  margin: auto;
  padding: 20px;
  font-family: Arial, sans-serif;
}

h1 {
  margin-bottom: 20px;
}

/* Formulaire */
.form {
  background: #ffffff;
  padding: 20px;
  border-radius: 8px;
  margin-bottom: 30px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.form input,
.form textarea,
.form select {
  width: 100%;
  margin-bottom: 10px;
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ddd;
}

.form button {
  background: #2563eb;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 6px;
  cursor: pointer;
}

.form button:hover {
  background: #1e40af;
}

/* Liste des tâches */
.tasks {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 15px;
}

.task {
  background: #f9fafb;
  padding: 15px;
  border-radius: 8px;
  border: 1px solid #e5e7eb;
}

.task-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.actions span {
  cursor: pointer;
  margin-left: 8px;
}

.actions span:hover {
  opacity: 0.7;
}

.meta {
  margin-top: 10px;
  font-size: 13px;
}

.statut {
  margin-right: 10px;
}

.priorite {
  font-weight: bold;
}
</style>
