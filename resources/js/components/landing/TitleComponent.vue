<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-body">
                    <h1 class="text-center">{{ title }}</h1>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TitleLanding",
    props: {
        title: {
            type: String,
            default: 'Título',
            description: "Título de la app en el landing",
        },
    },
};
</script>
