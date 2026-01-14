<template>
  <div class="stats-container">
    <div class="stats-grid">
      <div 
        v-for="(stat, index) in statsArray" 
        :key="index"
        class="stat-card"
        :class="stat.className"
      >
        <div class="stat-label">{{ stat.label }}</div>
        <div class="stat-value">{{ stat.value }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      stats: {}
    }
  },
  computed: {
    statsArray() {
      return [
        {
          label: "Tâches totales",
          value: this.stats.total || 0,
          className: "total"
        },
        {
          label: "En cours",
          value: this.stats.en_cours || 0,
          className: "en-cours"
        },
        {
          label: "En retard",
          value: this.stats.retard || 0,
          className: "retard"
        },
        {
          label: "Terminées",
          value: this.stats.terminees || 0,
          className: "terminees"
        }
      ]
    }
  },
  mounted() {
    fetch("/api/tableau_bord.php", { credentials: "include" })
      .then(res => res.json())
      .then(data => {
        this.stats = {
          total: data.total,
          en_cours: data.en_cours,
          retard: data.retard,
          terminees: data.terminees
        }
      })
      .catch(err => console.error("Erreur chargement stats:", err))
  }
}
</script>

<style scoped>
.stats-container {
  padding: 0;
  margin: 0;
  width: 100%;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin: 0;
  max-width: 1400px;
  margin-left: auto;
  margin-right: auto;
}

.stat-card {
  background: linear-gradient(135deg, #1e2437 0%, #2e2e3a 100%);
  padding: 20px 24px;
  border-radius: 12px;
  min-height: 110px;
  box-shadow: 
    0 8px 32px rgba(0, 0, 0, 0.3),
    0 2px 8px rgba(0, 0, 0, 0.2),
    inset 0 1px 0 rgba(255, 255, 255, 0.05);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, var(--card-accent), transparent);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.stat-card:hover::before {
  opacity: 1;
}

.stat-card:hover {
  transform: translateY(-8px) scale(1.02);
  box-shadow: 
    0 16px 48px rgba(0, 0, 0, 0.4),
    0 8px 16px rgba(0, 0, 0, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.stat-label {
  font-size: 12px;
  font-weight: 500;
  margin-bottom: 8px;
  color: #9ca3af;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.stat-value {
  font-size: 32px;
  font-weight: 700;
  line-height: 1;
  background: linear-gradient(135deg, var(--value-color-1), var(--value-color-2));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
}

/* Couleurs spécifiques avec dégradés */
.stat-card.total {
  --card-accent: #60a5fa;
  --value-color-1: #ffffff;
  --value-color-2: #e0e7ff;
}

.stat-card.en-cours {
  --card-accent: #fbbf24;
  --value-color-1: #fbbf24;
  --value-color-2: #f59e0b;
}

.stat-card.retard {
  --card-accent: #f87171;
  --value-color-1: #f87171;
  --value-color-2: #ef4444;
}

.stat-card.terminees {
  --card-accent: #34d399;
  --value-color-1: #34d399;
  --value-color-2: #10b981;
}

/* Effet de lueur subtile */
.stat-card.total:hover {
  box-shadow: 
    0 16px 48px rgba(96, 165, 250, 0.25),
    0 8px 16px rgba(0, 0, 0, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.stat-card.en-cours:hover {
  box-shadow: 
    0 16px 48px rgba(251, 191, 36, 0.25),
    0 8px 16px rgba(0, 0, 0, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.stat-card.retard:hover {
  box-shadow: 
    0 16px 48px rgba(248, 113, 113, 0.25),
    0 8px 16px rgba(0, 0, 0, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.stat-card.terminees:hover {
  box-shadow: 
    0 16px 48px rgba(52, 211, 153, 0.25),
    0 8px 16px rgba(0, 0, 0, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

/* Responsive */
@media (max-width: 1200px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
}

@media (max-width: 768px) {
  .stats-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  
  .stat-value {
    font-size: 36px;
  }
}
</style>