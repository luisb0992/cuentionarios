<template>
    <section>
        <div class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center py-2">{{ phase.title }}</h2>
                <div class="d-flex justify-content-center">
                    <div class="flex-grow-1">
                        <p class="text-muted">
                            {{ "Fase " + phase.number }}
                        </p>
                    </div>
                    <div
                        v-for="(video, index) in phase.videos"
                        :key="index"
                        class="list-group"
                    >
                        <div>
                            <a
                                href="#"
                                class="list-group-item list-group-item-action"
                                >{{ video.name }}</a
                            >
                        </div>
                    </div>
                </div>
                <div class="text-center w-50">
                    <video-player
                        class="video-player"
                        ref="videoPlayer"
                        :playsinline="true"
                        :options="playerOptions"
                        @play="onPlayerPlay()"
                        @pause="onPlayerPause()"
                        @ended="onPlayerEnded()"
                        @waiting="onPlayerWaiting()"
                        @playing="onPlayerPlaying()"
                        @loadeddata="onPlayerLoadeddata()"
                        @timeupdate="onPlayerTimeupdate()"
                        @canplay="onPlayerCanplay()"
                        @canplaythrough="onPlayerCanplaythrough()"
                        @statechanged="playerStateChanged()"
                        @ready="playerReadied"
                    ></video-player>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
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
                sources: [
                    // {
                    //     src: "http://video.jishiyoo.com/161b9562c780479c95bbdec1a9fbebcc/8d63913b46634b069e13188b03073c09-d25c062412ee3c4a0758b1c48fc8c642-ld.mp4", // camino
                    //     type: "video/mp4", // Tipos de
                    // },
                ],
                // cartel: "../../static/images/test.jpg", // Tu dirección de portada
                width: document.documentElement.clientWidth,
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
        };
    },

    mounted() {
        const video = this.phase.videos[0];

        // const file = new File([video.data], "video.mp4", {
        //     type: video.type,
        // });

        // console.log(file);
        // console.log(URL.createObjectURL(file));
        // console.log(`${URL.createObjectURL(file)}.mp4`);

        // const finalVideo = URL.createObjectURL(file).replace('blob:', '') + '.mp4';

        // console.log(finalVideo);

        this.playerOptions.sources = [
            {
                src: "data:video/*;base64," + video.data, //'https://www.youtube.com/watch?v=cNqwyLhyVkw&ab_channel=SarahD.Cloutier',
                type: video.type,
            },
        ];

        // this.finalVideo = 'data:video/*;base64,' + video.data;
    },

    methods: {
        // listen event
        onPlayerPlay(player) {
            console.log("player play!", player);
        },
        onPlayerPause(player) {
            console.log("player pause!", player);
        },
        onPlayerEnded(player) {
            console.log("player ended!", player);
        },
        onPlayerLoadeddata(player) {
            console.log("player Loadeddata!", player);
        },
        onPlayerWaiting(player) {
            console.log("player Waiting!", player);
        },
        onPlayerPlaying(player) {
            console.log("player Playing!", player);
        },
        onPlayerTimeupdate(player) {
            // console.log('player Timeupdate!', player.currentTime())
            console.log("player Timeupdate!", player);
        },
        onPlayerCanplay(player) {
            console.log("player Canplay!", player);
        },
        onPlayerCanplaythrough(player) {
            console.log("player Canplaythrough!", player);
        },
        // or listen state event
        playerStateChanged(playerCurrentState) {
            console.log("player current update state", playerCurrentState);
        },
        // player is ready
        playerReadied(player) {
            // seek to 10s
            console.log("example player 1 readied", player);
            player.currentTime(10);
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
