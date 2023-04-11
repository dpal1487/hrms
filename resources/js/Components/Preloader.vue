<template>
  <div>
    <div v-if="loading" class="overlay">
      <div class="loader"></div>
    </div>
  </div>
</template>
<style>
.overlay {
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader {
  border: 16px solid #f3f3f3;
  border-top: 16px solid #007bff;
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<script>
export default {
    props:['loading'],
    mounted(){
        document.getElementById('kt_app_body').classList.add('fixed')
    }
}
</script>
