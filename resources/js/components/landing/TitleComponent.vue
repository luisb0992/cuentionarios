<template>
    <h1 class="fw-light">{{ title }}</h1>
</template>

<script>
export default {
    name: "TitleLanding",
    props: {
        title: {
            type: String,
            default: "Título",
            description: "Título de la app en el landing",
        },
    },
};
</script>
