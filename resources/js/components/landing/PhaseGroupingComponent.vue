<template>
    <div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-12">
                <h2 class="text-center">{{ phase.title }}</h2>
            </div>
            <div class="d-flex">
                <div class="flex-grow-1">{{ phase.number }}</div>
                <div v-for="(video, index) in phase.videos" :key="index">
                    {{ video.data }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "PhaseGrouping",

    data() {
        return {};
    },
    props: {
        phase: {
            description:
                "Fase con su respectiva información (videos y cuestionarios)",
        },
    },

    methods: {},
};
</script>
