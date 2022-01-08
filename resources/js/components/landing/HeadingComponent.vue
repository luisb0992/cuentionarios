<template>
    <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <title-component :title="title"></title-component>
                    <video-component :video="video"></video-component>
                    <p class="lead text-muted py-lg-3">{{ subtitle }}</p>
                    <p>
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <input
                                    type="password"
                                    name="password"
                                    v-model="password"
                                    class="form-control form-control-lg"
                                    :placeholder="passwordPlaceholder"
                                />
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </section>
</template>

<script>

import TitleComponent from './TitleComponent';
import VideoComponent from './VideoComponent';

export default {
    name: 'Heading',
    components: {
        TitleComponent,
        VideoComponent,
    },
    data() {
        return {
            password: null,
        };
    },
    props: {
        title: {
            type: String,
            default: 'Título',
            description: 'Título de la app en el landing',
        },
        video: {
            type: String,
            default: 'video',
            description: 'Video descriptivo de la app en el landing',
        },
        subtitle: {
            type: String,
            default: 'Sitio',
            description: 'Subtitulo informativo para el landing',
        },
        passwordPlaceholder: {
            type: String,
            default: '---',
            description: 'Placeholder para el input tipo password',
        }
    },
};
</script>
