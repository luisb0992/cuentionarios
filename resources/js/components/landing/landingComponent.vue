<template>
    <div class="bg-white">
        <heading-component
            :title="title"
            :video="video"
            :subtitle="subtitle"
            :password-placeholder="passwordPlaceholder"
        ></heading-component>

        <phase-grouping-component :phases="phases"></phase-grouping-component>
    </div>
</template>

<script>

// Sección para la fase y su información
import PhaseGroupingComponent from "./PhaseGroupingComponent";

// Sección para el título, video y texto de la app
import HeadingComponent from "./HeadingComponent";

export default {
    name: "Landing",
    components: {
        HeadingComponent,
        PhaseGroupingComponent,
    },
    props: {
        title: {
            type: String,
            default: "Título",
            description: "Título de la app en el landing",
        },
        video: {
            type: String,
            default: "video",
            description: "Video descriptivo de la app en el landing",
        },
        subtitle: {
            type: String,
            default: "Sitio",
            description: "Subtitulo informativo para el landing",
        },
        passwordPlaceholder: {
            type: String,
            default: "**********",
            description: "Placeholder para el input tipo password",
        },
        phases: {
            description:
                "Fase con su respectiva información (videos y cuestionarios)",
        },
    },
};
</script>
