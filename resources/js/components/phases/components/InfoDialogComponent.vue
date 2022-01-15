<template>
    <div v-if="isObject(phase)">
        <Dialog
            :visible.sync="displayShowDialog"
            :header="labels.showPhase"
            :style="{ width: '50vw' }"
            :maximizable="true"
        >
            <div class="p-field">
                <label for="title" class="fw-bold">{{ labels.title }}</label>
                <span class="">{{ phase.title }}</span>
            </div>
            <div class="p-field">
                <label for="number" class="fw-bold">{{ labels.number }}</label>
                <span class="">{{ phase.number }}</span>
            </div>
            <div class="p-field">
                <label for="created" class="fw-bold">{{ labels.created }}</label>
                <span class="">{{ phase.created_at | date }}</span>
            </div>
            <div class="p-field">
                <label for="updated" class="fw-bold">{{ labels.updated }}</label>
                <span class="">{{ phase.updated_at | date }}</span>
            </div>
            <div class="p-field">
                <OrderList
                    v-model="videos"
                    dataKey="id"
                >
                    <template #header> {{ labels.videos }} </template>
                    <template #item="slotProps">
                        <div class="d-flex flex-column">
                            <div>
                                <div v-if="slotProps.item.url">
                                    <video-embed
                                        :src="slotProps.item.url"
                                        class="embed-responsive-item"
                                    ></video-embed>
                                </div>
                                <div v-else-if="slotProps.item.data">
                                    <video
                                        :src="
                                            'data:video/*;base64,' +
                                            slotProps.item.data
                                        "
                                        controls
                                        class="embed-responsive-item"
                                        style="width: 30vw; height: 20vw;"
                                    ></video>
                                </div>
                            </div>
                            <div class="p-caritem-vin">
                                <h5 class="p-mb-2">
                                    {{ slotProps.item.name }}
                                </h5>
                                <div v-if="slotProps.item.size">
                                    <i class="fas fa-arrow-right"></i>
                                    <span class="product-category">{{
                                        slotProps.item.size | megabytes
                                    }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-arrow-right"></i>
                                    <span class="product-category">{{
                                        slotProps.item.created_at | date
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </template>
                </OrderList>
            </div>
            <template #footer>
                <Button
                    :label="labels.close"
                    icon="pi pi-times"
                    class="p-button-success"
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
import OrderList from "primevue/orderlist";

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
        OrderList,
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

    mounted() {
        // this.phase = this.phase || {};
        console.log(this.phase);
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
