<template>
    <div>
        <!-- botón para crear nueva fase -->
        <div class="mb-2">
            <a
                class="btn btn-outline-success"
                :href="getRoutes().create"
                role="button"
            >
                <i class="fas fa-plus"></i>
                {{ labels.createPhase }}
            </a>
        </div>
        <!-- /botón para crear nueva fase -->

        <!-- tabla de fases - datatables -->
        <DataTable
            :value="data"
            :paginator="true"
            class="p-datatable-customers"
            :rows="10"
            dataKey="id"
            :rowHover="true"
            filterDisplay="menu"
            :loading="loading"
            :selection.sync="selectedPhases"
            :filters.sync="filters"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[10, 25, 50]"
            currentPageReportTemplate="Mostrando {first} a {last} de {totalRecords} entradas"
            :globalFilterFields="globalFilterFields()"
            responsiveLayout="scroll"
        >
            <template #header>
                <div
                    class="d-flex flex-sm-row flex-column justify-content-between align-items-center"
                >
                    <h5 class="fw-bold">{{ labels.phase }}</h5>
                    <span class="p-input-icon-left">
                        <i class="pi pi-search" />
                        <InputText
                            v-model="filters['global'].value"
                            :placeholder="labels.search"
                        />
                    </span>
                </div>
            </template>
            <template #empty>{{ labels.notFound }}</template>
            <template #loading>{{ labels.loading }}</template>

            <Column
                selectionMode="multiple"
                :styles="{ 'min-width': '3rem' }"
            ></Column>
            <Column
                :header="labels.title"
                field="title"
                sortable
                :styles="{ 'min-width': '14rem' }"
            >
                <template #body="{ data }">
                    {{ data.title }}
                </template>
            </Column>
            <Column
                :header="labels.number"
                field="number"
                sortable
                :styles="{ 'min-width': '14rem' }"
            >
                <template #body="{ data }">
                    <span class="image-text">{{ data.number }}</span>
                </template>
            </Column>
            <Column
                :header="labels.videos"
                field="videos"
                sortable
                :styles="{ 'min-width': '14rem' }"
            >
                <template #body="{ data }">
                    <Tree :value="getTreeVideos(data.videos)"></Tree>
                </template>
            </Column>
            <Column
                :header="labels.created"
                field="created_at"
                sortable
                dataType="date"
                :styles="{ 'min-width': '8rem' }"
            >
                <template #body="{ data }">
                    {{ data.created_at | date }}
                </template>
            </Column>
            <Column
                :header="labels.updated"
                field="updated_at"
                sortable
                dataType="date"
                :styles="{ 'min-width': '8rem' }"
            >
                <template #body="{ data }">
                    {{ data.updated_at | date }}
                </template>
            </Column>
            <Column
                :header="labels.actions"
                :headerStyle="{ 'min-width': '4rem', 'text-align': 'center' }"
                :bodyStyle="{ 'text-align': 'center', overflow: 'visible' }"
            >
                <template #body="{ data }">
                    <a :href="getRoutes(data.id).show">
                        <Button
                            icon="fas fa-eye"
                            v-tooltip.top="labels.tooltipShow"
                            class="p-button-info p-button-raised p-button-rounded"
                        />
                    </a>

                    <a :href="getRoutes(data.id).edit">
                        <Button
                            icon="fas fa-edit"
                            v-tooltip.top="labels.tooltipEdit"
                            class="p-button-warning p-button-raised p-button-rounded"
                        />
                    </a>

                    <a>
                        <Button
                            icon="fas fa-times"
                            v-tooltip.top="labels.tooltipDelete"
                            class="p-button-danger p-button-raised p-button-rounded"
                            @click="openDeleteConfirmation(data.id)"
                        />
                    </a>
                </template>
            </Column>
        </DataTable>
        <!-- /tabla de fases - datatables -->

        <!-- Dialog de confirmación para eliminar fase -->
        <delete-phase-component
            :labels="labels"
            :selected-phase="selectedPhase"
            :display-delete-confirmation="displayDeleteConfirmation"
            @close-delete-confirmation="closeDeleteConfirmation()"
            @delete-phase="deletePhase()"
        ></delete-phase-component>
        <!-- /Dialog de confirmación para eliminar fase -->
    </div>
</template>

<script>
// import dataTable primevue
import { FilterMatchMode } from "primevue/api";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import DeletePhaseComponent from "./components/DeletePhaseComponent.vue";

// imports form primevue
import InputText from "primevue/inputtext";
import Button from "primevue/button";

// importar moment.js
import moment from "moment";
Vue.prototype.moment = moment;

// importar directiva tooltip de primevue
import Tooltip from "primevue/tooltip";
Vue.directive("tooltip", Tooltip);

// importar árbol de expansion de primevue
import Tree from "primevue/tree";

export default {
    name: "Indexcomponent",
    components: {
        DataTable,
        Column,
        InputText,
        Button,
        Tree,
        DeletePhaseComponent,
    },

    data() {
        return {
            // textos para vue
            labels: [],

            // datos de la tabla de fases
            data: [],

            // elementos seleccionados
            selectedPhases: null,

            // fase actual seleccionada
            selectedPhase: null,

            // mostrar o no el dialog de confirmación de eliminación
            displayDeleteConfirmation: false,

            // loading de búsqueda de la tabla de fases
            loading: false,

            // filtros de búsqueda de la tabla de fases
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
            },
        };
    },

    mounted() {
        // cargar los labels necesarios
        this.labels = document.getElementById("labels").dataset;

        // cargar los de las fases
        this.getPhases();
    },

    methods: {
        /**
         * Devuelve las rutas utilizadas para acceder a los métodos
         *
         * @param {number|null} id      id de la fase
         */
        getRoutes(id = null) {
            if (id) {
                return {
                    edit: route("phases.edit", id),
                    show: route("phases.show", id),
                    delete: route("phases.destroy", id),
                };
            }

            // rutas sin parámetros
            return {
                create: route("phases.create"),
            };
        },

        /**
         * devuelve el listado de fases
         */
        async getPhases() {
            let loader = this.$loading.show();
            await axios
                .get(route("phases.getPhases"))
                .then((response) => {
                    this.data = response.data;
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    loader.hide();
                });
        },

        /**
         * Array de datos a ser filtrados
         */
        globalFilterFields() {
            return ["title", "number", "videos", "created_at", "updated_at"];
        },

        /**
         * Devuelve el árbol de videos
         *
         * @param {array} data    array de videos
         */
        getTreeVideos(data) {
            const videos = [
                {
                    key: "0",
                    label: `(${data.length}) videos`,
                    children: [],
                },
            ];

            data.forEach((video, index) => {
                videos[0].children.push({
                    key: `0-${index}`,
                    label: video.name,
                    icon: "fas fa-arrow-right",
                });
            });

            return videos;
        },

        /**
         * Abre el diálogo de confirmación de eliminación
         *
         * @param {number} id    id de la fase
         */
        openDeleteConfirmation(id) {
            if (!id) {
                this.$toast.danger("No se ha seleccionado ninguna fase");
                return;
            }

            this.displayDeleteConfirmation = true;
            this.selectedPhase = id;
        },

        /**
         * Cierra el diálogo de confirmación de eliminación
         */
        closeDeleteConfirmation() {
            this.displayDeleteConfirmation = false;
            this.selectedPhase = null;
        },

        /**
         * Elimina la fase seleccionada
         */
        async deletePhase() {
            const loader = this.$loading.show();
            await axios
                .delete(route("phases.destroy", this.selectedPhase))
                .then((response) => {
                    this.$toast.success(response.data.message);
                    this.getPhases();
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.closeDeleteConfirmation();
                    loader.hide();
                });
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
    },
};
</script>
