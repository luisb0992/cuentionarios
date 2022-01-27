<template>
    <section>
        <div class="py-5 bg-light" v-if="phases.length">
            <div class="container">
                <h2 class="text-center py-2">{{ phase.title }}</h2>
                <div
                    class="d-flex justify-content-center mb-3 border-1 border-bottom pb-2"
                >
                    <div class="flex-grow-1">
                        <p class="text-muted h5">
                            {{ "Fase " + phase.number }}
                        </p>
                    </div>
                    <div
                        v-for="(video, index) in phase.videos"
                        :key="index"
                        class="list-group"
                    >
                        <div>
                            <span
                                class="d-inline-block"
                                tabindex="0"
                                v-tooltip.top="video.name"
                            >
                                <button
                                    class="list-group-item list-group-item-action list-group-item-primary"
                                    @click="loadVideo(video)"
                                >
                                    {{ "Video " + parseInt(index + 1) }}
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div v-show="loadTypeVideo === 'upload'">
                        <video-player
                            class="vjs-big-play-centered"
                            ref="videoPlayer"
                            :playsinline="true"
                            :options="playerOptions"
                            @play="onPlayerPlay($event)"
                            @pause="onPlayerPause($event)"
                            @ended="onPlayerEnded($event)"
                            @playing="onPlayerPlaying($event)"
                            @timeupdate="onPlayerTimeupdate($event)"
                            @canplay="onPlayerCanplay($event)"
                            @canplaythrough="onPlayerCanplaythrough($event)"
                            @statechanged="playerStateChanged($event)"
                            @ready="playerReadied"
                        ></video-player>
                    </div>
                    <div v-show="loadTypeVideo === 'url'" class="border border-2 border-primary">
                        <video-embed
                            :src="urlOptions.src"
                            ref="urlVideo"
                            class=""
                            style="min-height: 400px; min-width: 600px"
                            allowfullscreen
                            @ended="onEnd()"
                        ></video-embed>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
// directiva del tooltip de primevue
import Tooltip from "primevue/tooltip";
Vue.directive("tooltip", Tooltip);

// utilizar el componente de vue para la  reproducción de videos
import Embed from "v-video-embed";
Vue.use(Embed);

export default {
    name: "PhaseGrouping",
    props: {
        phases: {
            description:
                "Fases con su respectiva información (videos y cuestionarios)",
        },
    },

    data() {
        return {
            // opciones de configuración para los videos subidos
            playerOptions: {
                // velocidad de reproducción
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                // Si es verdadero, inicia la reproducción cuando el navegador esté listo.
                autoplay: false,
                // Cualquier audio será eliminado por defecto.
                muted: false,
                // Provoca que el video se reinicie tan pronto como termine.
                loop: false,
                // Se recomienda que el navegador comience a descargar datos de video después de cargar el elemento <video>.
                // El navegador automático elige el mejor comportamiento y comienza a cargar el video inmediatamente (si es compatible con el navegador)
                preload: "auto",
                // Cuando es verdadero, el reproductor Video.js tendrá un tamaño fluido. En otras palabras,
                // se escalará proporcionalmente para adaptarse a su contenedor.
                fluid: false,

                // recurso de video (src, type)
                sources: [],
                // cartel: "../../static/images/test.jpg", // Tu dirección de portada
                // width: document.documentElement.clientWidth,
                height: '',

                // Permitir anular la información predeterminada que se muestra
                notSupportedMessage:
                    "Este video no está disponible temporalmente. Vuelve a intentarlo más tarde",

                // cuando Video.js no puede reproducir la fuente multimedia.
                // controlBar: false,
                controlBar: {
                    // Muestra alguna configuración de la barra de control
                    timeDivider: true,
                    durationDisplay: true,
                    remainingTimeDisplay: false,
                    fullscreenToggle: true, // botón de pantalla completa
                },
            },

            // opciones de configuración para los videos por url
            urlOptions: {
                src: "",
            },

            // definir el path donde se encuentran los videos almacenados en la app
            pathVideos: null,

            // definir el tipo de reproducción del video cargado
            loadTypeVideo: "upload",
        };
    },

    async mounted() {
        // path para los videos
        await this.getPathVideos();

        // Si existe alguna fase con videos
        if (this.phases.length) {
            // video a ser mostrado de primero
            const video = this.phase.videos[0];

            this.loadVideo(video);
        }

        // ajustar tamaño del video
        await this.onResize();
        window.onresize = this.onResize;
    },

    methods: {

        onEnd() {
            // si el video terminó, se carga el siguiente
            // if (this.phase.videos.length > 1) {
            //     // video a ser mostrado de primero
            //     const video = this.phase.videos[1];

            //     this.loadVideo(video);
            // }
            console.log("el video finalizo");
        },

        /**
         * Carga el video para ser visualizado
         * en el DOM
         *
         * @param {Object} video    Video a ser cargado
         */
        loadVideo(video) {
            console.log(video);

            const data = {
                data: video.data ? this.pathVideos + video.data : video.url,
                type: video.type ?? "video/mp4",
            };

            if (video.data) {
                this.loadTypeVideo = "upload";

                // opciones para cargar el video
                this.playerOptions.sources = [
                    {
                        src: data.data,
                        type: data.type,
                    },
                ];
            } else {
                this.loadTypeVideo = "url";

                this.urlOptions.src = data.data;
            }
        },

        /**
         * Determinar el tamaño del video según
         * el tamaño de la pantalla
         */
        onResize() {
            if (window.innerWidth > 500) {
                this.playerOptions.height = "350";
            } else {
                this.playerOptions.height = parseInt(window.innerWidth / 1.95);
            }
        },

        /**
         * Obtiene la ruta de los videos
         */
        async getPathVideos() {
            await axios.get(route("getPathVideos")).then((response) => {
                this.pathVideos = response.data;
            });
        },

        /**
         * Evento que se ejecuta cuando el video comienza a reproducirse
         */
        onPlayerPlay(player) {
            console.log("Ha comenzado!", player);
        },

        /**
         * Evento que se ejecuta cuando el video pausa
         */
        onPlayerPause(player) {
            console.log("Se ha pausado!", player);
        },

        /**
         * Evento que se ejecuta cuando el video termina
         */
        onPlayerEnded(player) {
            console.log("Ha terminado!", player);
        },

        /**
         * Evento que se ejecuta cuando el video está en espera
         */
        // onPlayerLoadeddata(player) {
        //     console.log("player Loadeddata!", player);
        // },

        /**
         * Evento que se ejecuta cuando el video está en espera
         */
        // onPlayerWaiting(player) {
        //     console.log("player Waiting!", player);
        // },

        /**
         * Cuando el video está en reproducción
         */
        onPlayerPlaying(player) {
            console.log("Se esta reproduciendo!", player);
        },

        /**
         * Actualización de tiempo cuando el video está en reproducción
         */
        onPlayerTimeupdate(player) {
            // console.log('player Timeupdate!', player.currentTime())
            console.log("Actualizacion de tiempo: ", player.currentTime());
        },

        /**
         * Cunado el video ha sido adelantado
         */
        onPlayerCanplay(player) {
            console.log("Ha sido adelantado!", player);
        },

        /**
         * Cuando el video ha sido adelantado y se puede
         * seguir reproduciendo
         */
        onPlayerCanplaythrough(player) {
            console.log("Se puede seguir viendo!", player);
        },
        // or listen state event

        /**
         * Evento que se ejecuta mientras el video está en reproducción
         */
        playerStateChanged(playerCurrentState) {
            console.log("actualización de estado: ", playerCurrentState);
        },

        /**
         * Evento que se ejecuta cuando el video está listo para reproducirse
         */
        playerReadied(player) {
            console.log("Listo para ser reproducido", player);
            // player.currentTime(10);
            // player.currentTime(10);
            // console.log('example 01: the player is readied', player)
        },
    },

    computed: {
        /**
         * devuelve solo una de las fases
         */
        phase() {
            return this.phases[0];
        },

        /**
         * devuelve solo un video de la fase
         */
        player() {
            return this.$refs.videoPlayer.player;
        },
    },
};
</script>
