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
                                <a
                                    href="#"
                                    class="list-group-item list-group-item-action list-group-item-primary"
                                    >{{ "Video " + parseInt(index + 1) }}</a
                                >
                            </span>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div class="">
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
                </div>
            </div>
        </div>
    </section>
</template>

<script>
// directiva del tooltip de primevue
import Tooltip from "primevue/tooltip";
Vue.directive("tooltip", Tooltip);

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
            playerOptions: {
                // Tasas de reproducción: [0.7, 1.0, 1.5, 2.0], // velocidad de reproducción
                playbackRates: [0.7, 1.0, 1.5, 2.0],
                autoplay: false, // Si es verdadero, inicia la reproducción cuando el navegador esté listo.
                muted: false, // Cualquier audio será eliminado por defecto.
                loop: false, // Provoca que el video se reinicie tan pronto como termine.
                preload: "auto", // Se recomienda que el navegador comience a descargar datos de video después de cargar el elemento <video>.
                // El navegador automático elige el mejor comportamiento y comienza a cargar el video inmediatamente (si es compatible con el navegador)
                fluid: false, // Cuando es verdadero, el reproductor Video.js tendrá un tamaño fluido. En otras palabras,
                // se escalará proporcionalmente para adaptarse a su contenedor.
                sources: [],
                // cartel: "../../static/images/test.jpg", // Tu dirección de portada
                // width: document.documentElement.clientWidth,
                notSupportedMessage:
                    "Este video no está disponible temporalmente. Vuelve a intentarlo más tarde", // Permitir anular la información predeterminada que se muestra
                // cuando Video.js no puede reproducir la fuente multimedia.
                // controlBar: false,
                controlBar: {
                    // Muestra alguna configuración de la barra de control
                    timeDivider: true,
                    durationDisplay: true,
                    remainingTimeDisplay: false,
                    fullscreenToggle: true, // botón de pantalla completa
                },
                height: "400",
            },

            pathVideos: null,
        };
    },

    async mounted() {
        // path para los videos
        await this.getPathVideos();

        // ajustar tamaño del video
        await this.onResize();

        // Si existe alguna fase con videos
        if (this.phases.length) {
            // video a ser mostrado de primero
            const video = this.phase.videos[1];

            // opciones para cargar el video
            this.playerOptions.sources = [
                {
                    src: this.pathVideos + video.data,
                    type: video.type,
                },
            ];
        }

    },

    methods: {
        /**
         * Verificar si la phase es un objeto valido
         */
        // isObject(obj) {
        //     return obj && typeof obj === "object";
        // },

        /**
         * Determinar el tamaño del video según
         * el tamaño de la pantalla
         */
        onResize() {
            if (window.innerWidth > 500) {
                this.playerOptions.height = "400";
            } else {
                this.playerOptions.height = "200";
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

        player() {
            return this.$refs.videoPlayer.player;
        },
    },
};
</script>

<style scoped>
/* Por debajo de 700px */
/* @media screen and (max-width: 700px) {
    .vue_video {
        height: 300px !important;
        max-height: 300px !important;
        padding: 100px;
    }
} */

/* Por debajo de 500px */
/* @media screen and (max-width: 400px) {
    .vue_video {
        height: 200px !important;
        max-height: 200px !important;
        padding: 150px;
    }
} */
</style>
