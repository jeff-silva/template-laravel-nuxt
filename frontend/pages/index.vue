<template>
    <div>
        <pre>app: {{ app }}</pre>
    </div>
</template>

<script setup>
import useApp from '@/composables/useApp';
const app = useApp();
</script>