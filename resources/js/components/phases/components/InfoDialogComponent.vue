<template>
    <div v-if="isObject(phase)">
        <Dialog :visible.sync="displayShowDialog" :closable="false">
            <template #header>
                <div
                    class="d-flex justify-content-between bg-primary bg-opacity-75 w-100 py-3 px-2 align-items-center rounded"
                >
                    <div>
                        <h3 class="text-white">
                            <i class="fas fa-info-circle"></i>
                            {{ labels.showPhase }}
                        </h3>
                    </div>
                    <div>
                        <Button
                            icon="pi pi-times"
                            class="p-button-sm text-white p-button-link"
                            @click="$emit('close-show-dialog', false)"
                        />
                    </div>
                </div>
            </template>
            <Fieldset :legend="phase.title" :toggleable="true">
                <p>
                    <i class="pi pi-arrow-circle-right"></i>
                    <label for="title" class="fw-bold">{{
                        labels.number
                    }}</label>
                    <span class="">{{ phase.number }}</span>
                </p>
                <p>
                    <i class="pi pi-arrow-circle-right"></i>
                    <label for="title" class="fw-bold">{{
                        labels.created
                    }}</label>
                    <span class="">{{ phase.created_at | date }}</span>
                </p>
                <p>
                    <i class="pi pi-arrow-circle-right"></i>
                    <label for="title" class="fw-bold">{{
                        labels.updated
                    }}</label>
                    <span class="">{{ phase.updated_at | date }}</span>
                </p>

                <DataView
                    :value="videos"
                    layout="list"
                    :paginator="true"
                    :rows="1"
                >
                    <template #list="props">
                        <div class="mt-2">
                            <div
                                class="d-flex flex-column p-2 justify-content-center"
                            >
                                <div>
                                    <div v-if="props.data.url">
                                        <video-embed
                                            :src="props.data.url"
                                            class="embed-responsive-item text-center"
                                        ></video-embed>
                                    </div>
                                    <div v-else-if="props.data.data">
                                        <video
                                            :src="
                                                'data:video/*;base64,' +
                                                props.data.data
                                            "
                                            controls
                                            class="embed-responsive-item text-center"
                                            style="width: 30vw; height: 20vw"
                                        ></video>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h5 class="fw-bold">
                                        {{ props.data.name }}
                                    </h5>
                                    <div v-if="props.data.size">
                                        <i class="pi pi-arrow-circle-right"></i>
                                        <span class="product-category">{{
                                            props.data.size | megabytes
                                        }}</span>
                                    </div>
                                    <div>
                                        <i class="pi pi-arrow-circle-right"></i>
                                        <span class="product-category">{{
                                            props.data.created_at | date
                                        }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </DataView>
            </Fieldset>
            <template #footer>
                <Button
                    :label="labels.close"
                    icon="pi pi-times"
                    class="p-button-danger"
                    @click="$emit('close-show-dialog', false)"
                />
            </template>
        </Dialog>
    </div>
</template>

<script>
// imports
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import DataView from "primevue/dataview";
import Fieldset from "primevue/fieldset";

// utilizar el componente de vue para la  reproducción de videos
import Embed from "v-video-embed";
Vue.use(Embed);

// importar moment.js
import moment from "moment";
Vue.prototype.moment = moment;

export default {
    name: "InfoDialog",
    components: {
        Dialog,
        Button,
        DataView,
        Fieldset,
    },

    props: {
        phase: {
            default: null,
            required: false,
        },
        labels: {
            required: true,
        },
        displayShowDialog: {
            type: Boolean,
            default: false,
        },
    },

    methods: {
        /**
         * Verificar si la phase es un objeto valido
         */
        isObject(obj) {
            return obj && typeof obj === "object";
        },
    },

    computed: {
        videos() {
            return this.isObject(this.phase) ? this.phase.videos : [];
        },
    },

    filters: {
        /**
         * filtro para el campo de fecha
         */
        date(value) {
            if (value) {
                return moment(String(value)).format("DD/MM/YYYY");
            }
        },

        /**
         * filtro para el campo de tamaño de archivo
         */
        megabytes(value) {
            if (value) {
                return `${parseFloat(value / 1048576).toFixed(2)} MB`;
            }
        },
    },
};
</script>
