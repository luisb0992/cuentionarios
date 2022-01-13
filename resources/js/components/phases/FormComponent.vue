<template>
    <div>
        <form @submit.prevent="createPhase()">
            <!-- numero de la fase -->
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
            <!-- /numero de la fase -->

            <!-- titulo de la fase -->
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
            <!-- /titulo de la fase -->

            <!-- carga de videos -->
            <div class="form-group py-2">
                <i class="fas fa-file-video"></i>
                <label for="addFiles">{{ labels.addFiles }}</label>
                <p class="lead">
                    <small>{{ labels.selectMethod }}</small>
                </p>

                <!-- botones para seleccionar por subida o url -->
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
                <!-- /botones para seleccionar por subida o url -->

                <!-- videos subidos -->
                <div v-if="isFiles" class="mt-2">
                    <b-form-file
                        v-model="videosFile"
                        :placeholder="placeholders.videos"
                        :drop-placeholder="placeholders.drop"
                        :browse-text="placeholders.browseInput"
                        multiple
                        accept=".mp4, .flv, .avi"
                        size="lg"
                        :file-name-formatter="formatNames"
                        @input="checkVideoFile()"
                    ></b-form-file>
                    <div
                        class="row align-items-center mt-3"
                        v-for="(video, index) in videosFile"
                        :key="index"
                    >
                        <div class="col-md-3">
                            <video
                                :src="video.preview"
                                controls
                                class="col-md-12"
                            ></video>
                        </div>
                        <div class="col-md-9">
                            <div class="text-primary">{{ video.name }}</div>
                            <div class="text-muted">{{ video.type }}</div>
                            <div class="text-muted">{{ video.sizeMB }} MB</div>
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

                <!-- botón para cargar videos en la tabla -->
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
                <!-- /botón para cargar videos en la tabla -->
            </div>
            <!-- /carga de videos -->

            <!-- tabla de videos cargados por url o upload -->
            <div class="form-group py-2 shadow">
                <label for="uploadFiles">
                    <i class="fas fa-table"></i>
                    {{ labels.uploadFiles }}
                </label>
                <div class="table-responsive">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ labels.videoName }}</th>
                                <th>{{ labels.videoType }}</th>
                                <th>{{ labels.videoSize }}</th>
                                <th>{{ labels.videoVia }}</th>
                                <th>{{ labels.videoActions }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!videos.length">
                                <td colspan="6">
                                    <strong>{{ labels.noLoadVideos }}</strong>
                                </td>
                            </tr>
                            <tr
                                v-for="(video, index) in videos"
                                :key="index"
                                v-else
                            >
                                <td>{{ index + 1 }}</td>
                                <td>{{ video.name }}</td>
                                <td>{{ video.type }}</td>
                                <td>
                                    {{
                                        video.sizeMB ? video.sizeMB + "MB" : ""
                                    }}
                                </td>
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
                                        @click="deleteVideoToTable(index)"
                                    >
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /tabla de videos cargados por url o upload -->

            <!-- submit del formulario -->
            <div class="py-2 text-right">
                <button type="submit" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-save"></i>
                    {{ labels.submit }}
                </button>
            </div>
            <!-- /submit del formulario -->
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

            // mensajes de la app
            appMessages: [],

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

        // cargar mensajes de la app a la propiedad
        this.appMessages = document.querySelector("#appMessages").dataset;
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
                url: "",
            });
        },

        /**
         * Limpiar el array de videos por url
         */
        clearUrlVIdeos() {
            this.videosUrl = [
                {
                    url: "",
                },
            ];
        },

        /**
         * Limpiar el array de videos subidos
         */
        clearUploadVideos() {
            this.videosFile = [];
        },

        /**
         * Limpiar el formulario
         */
        clearForm() {
            this.form = {
                title: "",
            };
        },

        /**
         * evaluar si el archivo subido es un video valido
         */
        isValidFileVideo(file) {
            const videoTypes = ["video/mp4", "video/x-msvideo", "video/x-flv"];
            return file && videoTypes.includes(file["type"]);
        },

        /**
         * evaluar si el o los archivos seleccionados son validos
         */
        checkVideoFile() {
            // prevenir cualquier error
            if (!this.videosFile.length) {
                return;
            }

            let continuar = true;

            // Comprueba si es un archivo de video aceptado
            // sino se muestra el mensaje
            this.videosFile.forEach((file) => {
                if (!this.isValidFileVideo(file) && continuar) {
                    continuar = false;
                }

                // precargar el video para previsualizar
                if (continuar) {
                    file.preview = URL.createObjectURL(file);
                    file.sizeMB = parseFloat(file.size / 1048576).toFixed(2);
                }
            });

            // Si no ha pasado la validación, se muestra el mensaje
            if (!continuar) {
                this.clearUploadVideos();
                this.$toast.error(this.appMessages.invalidUploadFiles);
            }
        },

        /**
         * eliminar un input de url
         */
        deleteUrlInput(index) {
            this.videosUrl.splice(index, 1);
        },

        /**
         * eliminar un video de la tabla
         */
        deleteVideoToTable(index) {
            this.videos.splice(index, 1);
            this.$toast.info(this.appMessages.deleteVideo);
        },

        /**
         * Agregar o cargar videos a la tabla
         */
        loadVideosToTable() {
            const notUrlVideo = this.videosUrl.every(
                (video) => !video.url.length
            );
            const notUploadVideo = !this.videosFile.length;

            // verificar que las urls sean validas
            if (notUrlVideo && notUploadVideo) {
                this.$toast.warning(this.appMessages.emptyVideos);
                return;
            }

            if (this.isUrl) {
                this.videosUrl.forEach((video) => {
                    if (video.url.length > 5) {
                        this.videos.push({
                            name: video.url,
                            type: null,
                            size: null,
                            sizeMB: null,
                            via: this.TYPE_UPLOAD.url,
                            url: video.url,
                        });
                    }
                });
            } else {
                this.videosFile.forEach((video) => {
                    this.videos.push({
                        name: video.name,
                        type: video.type,
                        size: video.size,
                        sizeMB: video.sizeMB,
                        via: this.TYPE_UPLOAD.file,
                        video: video,
                    });
                });
            }

            // limpiar array de videos por url
            this.clearUrlVIdeos();

            // limpiar array de videos por archivos
            this.clearUploadVideos();
        },

        /**
         * Obtener los datos formateados del formulario
         */
        getFormData() {
            const formData = new FormData();
            formData.append("title", this.form.title);

            this.videos.forEach((video, index) => {
                if (video.via === this.TYPE_UPLOAD.file) {
                    formData.append(`videos[file][${index}]`, video.video);
                } else {
                    formData.append(`videos[url][${index}]`, video.url);
                }
            });

            return formData;
        },

        /**
         * Guardar los datos y crear la nueva fase
         */
        createPhase() {
            // verificar que existan videos agregados
            if (!this.videos.length) {
                this.$toast.warning(this.appMessages.requiredVideos);
                return;
            }

            // verificar el título
            if (!this.form.title.length) {
                this.$toast.warning(this.appMessages.requiredTitle);
                return;
            }

            // formatear la data
            const formData = this.getFormData();

            // iniciar el loader
            let loader = this.$loading.show();

            axios
                .post(route("phases.store"), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    if (response.status === 201) {
                        this.videos = [];
                        this.clearForm();
                        this.clearUrlVIdeos();
                        this.clearUploadVideos();
                        this.$toast.success(response.data.message);
                    }
                })
                .catch((error) => {
                    console.log(error);
                    this.$toast.error(this.appMessages.errorPhase);
                })
                .finally(() => {
                    loader.hide();
                });
        },
    },
};
</script>
