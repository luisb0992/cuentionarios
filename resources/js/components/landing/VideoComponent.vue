<template>
    <div class="py-2">
        <div class="ratio ratio-16x9">
            <iframe
                src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0"
                title="YouTube video"
                allowfullscreen
            ></iframe>
        </div>
    </div>
</template>

<script>
export default {
    name: "VideoLanding",
    props: {
        video: {
            type: String,
            default: "video",
            description: "Video descriptivo de la app en el landing",
        },
    },
};
</script>
