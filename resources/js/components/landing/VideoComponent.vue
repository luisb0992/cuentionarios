<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-body">
                    <p class="text-center">{{ video }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "VideoLanding",
    props: {
        video: {
            type: String,
            default: 'video',
            description: "Video descriptivo de la app en el landing",
        },
    },
};
</script>
