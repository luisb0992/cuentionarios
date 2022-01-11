<template>
    <div>
        <form @submit.prevent="createPhase()">
            <div class="form-group py-2">
                <i class="fas fa-list-alt"></i>
                <label for="phase">{{ labels.phase }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="phase"
                    :value="labels.number"
                    disabled
                />
            </div>
            <div class="form-group py-2">
                <i class="fas fa-heading"></i>
                <label for="title">{{ labels.title }}</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    :placeholder="placeholders.title"
                    v-model="form.title"
                />
            </div>
            <div class="form-group py-2">
                <i class="fas fa-file-video"></i>
                <label for="addFiles">{{ labels.addFiles }}</label>
                <p class="lead">
                    <small>{{ labels.selectMethod }}</small>
                </p>
                <div>
                    <button
                        type="button"
                        class="btn btn-info"
                        @click="viaFile()"
                    >
                        <i class="fas fa-upload"></i>
                        {{ labels.viaFile }}
                    </button>
                    <button
                        type="button"
                        class="btn btn-success"
                        @click="viaUrl()"
                    >
                        <i class="fas fa-link"></i>
                        {{ labels.viaUrl }}
                    </button>
                </div>

                <!-- videos subidos -->
                <div v-if="isFiles" class="mt-2">
                    <b-form-file
                        v-model="videosFile"
                        :state="Boolean(videosFile)"
                        :placeholder="placeholders.videos"
                        :drop-placeholder="placeholders.drop"
                        :browse-text="placeholders.browseInput"
                        multiple
                        accept=".mp4, .mov, .avi"
                        size="lg"
                        :file-name-formatter="formatNames"
                    ></b-form-file>
                    <div v-if="videosFile.length" class="mt-1">
                        <div>{{ labels.selectedVideos }}</div>
                        <div
                            class="text-muted"
                            v-for="(video, index) in videosFile"
                            :key="index"
                        >
                            <small>{{ video.name }}</small>
                        </div>
                    </div>
                </div>
                <!-- /videos subidos -->

                <!-- videos cargados por url -->
                <div v-else-if="isUrl" class="mt-2">
                    <div
                        class="d-flex flex-column flex-sm-row align-items-center mb-2"
                        v-for="(video, index) in videosUrl"
                        :key="index"
                    >
                        <!-- visible para modo sm -->
                        <div
                            v-if="video.url"
                            class="w-25 d-none d-sm-block me-2"
                        >
                            <video-embed :src="video.url"></video-embed>
                        </div>

                        <!-- visible solo para modo xs -->
                        <div v-if="video.url" class="w-100 d-block d-sm-none">
                            <video-embed :src="video.url"></video-embed>
                        </div>
                        <div class="flex-grow-0 flex-sm-grow-1 my-2 w-100">
                            <input
                                type="text"
                                class="form-control"
                                v-model="video.url"
                            />
                        </div>
                        <div v-if="videosUrl.length > 1" class="my-1">
                            <button
                                type="button"
                                class="btn btn-danger"
                                @click="deleteUrlInput(index)"
                            >
                                <span class="d-block d-sm-none">
                                    <i class="fas fa-times"></i>
                                    {{ labels.deleteButton }}
                                </span>
                                <span class="d-none d-sm-block">
                                    <i class="fas fa-times"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="btn btn-primary mt-1"
                        @click="addUrlInput()"
                    >
                        <i class="fas fa-plus"></i>
                        {{ labels.addInputUrl }}
                    </button>
                </div>
                <!-- /videos cargados por url -->
                <hr />
                <div>
                    <button
                        type="button"
                        class="btn btn-outline-warning"
                        @click="loadVideosToTable()"
                    >
                        <i class="fas fa-file-import"></i>
                        {{ labels.loadVideosButton }}
                    </button>
                </div>
            </div>

            <!-- tabla de videos cargados por url o upload -->
            <div class="form-group py-2">
                <label for="uploadFiles">{{ labels.uploadFiles }}</label>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ labels.videoName }}</th>
                                <th>{{ labels.videoType }}</th>
                                <th>{{ labels.videoSize }}</th>
                                <th>{{ labels.videoVia }}</th>
                                <th>{{ labels.videoActions }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!videos.length">
                                <td colspan="5">
                                    <div class="alert alert-info" role="alert">
                                        <strong>{{
                                            labels.noLoadVideos
                                        }}</strong>
                                    </div>
                                </td>
                            </tr>
                            <tr
                                v-for="(video, index) in videos"
                                :key="index"
                                v-else
                            >
                                <td>{{ video.name }}</td>
                                <td>{{ video.type }}</td>
                                <td>{{ video.size }}</td>
                                <td>
                                    <b-badge
                                        :variant="
                                            video.via === TYPE_UPLOAD.url
                                                ? 'success'
                                                : 'info'
                                        "
                                    >
                                        {{
                                            video.via === TYPE_UPLOAD.url
                                                ? labels.url
                                                : labels.upload
                                        }}
                                    </b-badge>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-danger"
                                        @click="deleteVideo(index)"
                                    >
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="py-2 text-right">
                <button type="submit" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-save"></i>
                    {{ labels.submit }}
                </button>
            </div>
        </form>
    </div>
</template>

<script>
// utilizar el componente de vue para la  reproducción de videos
import Embed from "v-video-embed";
Vue.use(Embed);

export default {
    name: "Form",

    data() {
        return {
            // labels para el formulario
            labels: {},

            // Placeholders para los campos del formulario
            placeholders: {},

            // objeto con los datos del formulario
            form: {
                title: "",
            },

            // array de videos seleccionados
            videosFile: [],

            // array de videos por URL
            videosUrl: [
                {
                    url: "",
                },
            ],

            // Videos cargados en la tabla
            videos: [],

            // si se selecciono subida por archivos
            isFiles: false,

            // si se selecciono subida por url
            isUrl: false,

            // tipo de carga de videos
            TYPE_UPLOAD: {
                file: 1,
                url: 2,
            },
        };
    },

    mounted() {
        // tomar los textos para los labels del formulario
        this.labels = document.querySelector("#textLabels").dataset;

        // tomar los textos para los placeholders del formulario
        this.placeholders = document.querySelector("#textPlaceholders").dataset;
    },

    methods: {
        /**
         * dar formato al input de nombre de archivos
         */
        formatNames(files) {
            return files.length === 1
                ? files[0].name
                : `${files.length} ${this.labels.nameFiles}`;
        },

        /**
         * subir videos por archivos
         */
        viaFile() {
            this.isFiles = true;
            this.isUrl = false;
        },

        /**
         * subir videos por url
         */
        viaUrl() {
            this.isFiles = false;
            this.isUrl = true;
        },

        /**
         * agregar un input de url
         */
        addUrlInput() {
            this.videosUrl.push({
                url: null,
            });
        },

        /**
         * evaluar si la url es valida
         */
        evaluateUrl(index) {
            if (this.videosUrl[index].url.length > 0) {
                console.log(
                    "se esta escribiendo algo",
                    this.videosUrl[index].url
                );
            }
        },

        /**
         * eliminar un input de url
         */
        deleteUrlInput(index) {
            this.videosUrl.splice(index, 1);
        },

        /**
         * Agregar o cargar videos a la tabla
         */
        loadVideosToTable() {
            if (this.isUrl) {
                this.videosUrl.forEach((video) => {
                    if (video.url.length > 5) {
                        this.videos.push({
                            name: video.url,
                            type: null,
                            size: null,
                            via: this.TYPE_UPLOAD.url,
                        });
                    } else {
                        console.log("no se puede agregar el video");
                        return;
                    }
                });
            }

            // limpiar array de videos por url
            this.videosUrl = [{url: null}];

            // limpiar array de videos por archivos
            this.videosFile = [];
        },

        createPhase() {
            // crear la fase
            // this.$store.dispatch('createPhase', this.form);
            // // limpiar el formulario
            // this.form = {
            //     title: '',
            // };
        },
    },
};
</script>
