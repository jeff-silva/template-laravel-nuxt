<template>
  <div>
    <NuxtWelcome />
  </div>
</template>

<script setup>
import axios from 'axios';

onMounted(async () => {
  const resp = await axios.get('/api/test');
  console.log(resp);
});
</script>