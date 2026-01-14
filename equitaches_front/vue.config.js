const { defineConfig } = require("@vue/cli-service");

module.exports = defineConfig({
  transpileDependencies: true,

  devServer: {
    port: 8080,  // Port fixe
    open: true   // Ouvre automatiquement le navigateur
  }
});
