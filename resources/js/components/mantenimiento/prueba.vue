<template>
    <div>
      {{ propData }}
      <button type="button" @click="sendDataToParent">Enviar Datos al Padre</button>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      propData: String
    },
    methods: {
      sendDataToParent() { 
        // Enviar datos al padre a través de un evento personalizado
        this.$emit('propData', 'nuevo dato del hijo');
      }
    }
  };
  </script>