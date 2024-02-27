<template>
    <div>
        <v-row>
            <v-col cols="2">
                <v-list>
                    <template v-for="f in files">
                        <v-list-item :to="f.to">{{ f.name }}</v-list-item>
                    </template>
                </v-list>
            </v-col>
            <v-col cols="10">
                <nuxt-page></nuxt-page>
            </v-col>
        </v-row>
    </div>
</template>

<script setup>
const files = [
    { to: '/test', name: 'index' },
    ...Object.keys(import.meta.glob('./index/**')).map((file) => {
        const name = file.split('/').pop().split('.').at(0);
        return { to: `/test/${name}`, name };
    })
];
</script>