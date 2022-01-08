<template>
    <div class="justify-content-center bg-white">
        <title-component :title="title"></title-component>
        <video-component :video="video"></video-component>

        <p class="text-center">
            {{ subtitle }}
        </p>

        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <input
                    type="password"
                    name="password"
                    v-model="password"
                    class="form-control form-control-lg"
                    :placeholder="passwordPlaceholder"
                />
            </div>
        </div>

        <phase-grouping-component :phase="phase"></phase-grouping-component>
    </div>
</template>

<script>
// Imports necesarios para el landing
import TitleComponent from "./TitleComponent";
import VideoComponent from "./VideoComponent";
import PhaseGroupingComponent from "./PhaseGroupingComponent";

export default {
    name: "Landing",
    components: {
        TitleComponent,
        VideoComponent,
        PhaseGroupingComponent
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
            default: "---",
            description: "Placeholder para el input tipo password",
        },
        phase: {
            description: "Fase con su respectiva información (videos y cuestionarios)",
        }
    },
    data() {
        return {
            password: null,
        };
    },
};
</script>
