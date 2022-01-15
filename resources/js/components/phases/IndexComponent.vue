<template>
    <div class="mt-4">
        <!-- botones de configuración -->
        <div
            class="d-flex flex-row justify-content-between align-items-center bg-light px-3 py-2"
        >
            <div>
                <a :href="getRoutes().create">
                    <Button
                        :label="labels.createPhase"
                        icon="fas fa-plus"
                        class="p-button-primary p-button-raised"
                    />
                </a>
                <Button
                    :label="labels.deletePhases"
                    icon="fas fa-trash"
                    class="p-button-danger p-button-raised"
                    @click="confirmDeleteSelected()"
                    :disabled="!selectedPhases || !selectedPhases.length"
                />
            </div>
            <div>
                <Button
                    :label="labels.export"
                    icon="pi pi-upload"
                    class="p-button-help p-button-raised"
                    @click="exportCSV()"
                />
            </div>
        </div>
        <!-- /botones de configuración -->

        <!-- tabla de fases - datatables -->
        <DataTable
            :value="data"
            :paginator="true"
            class="p-datatable-customers"
            :rows="10"
            ref="dt"
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

            <!-- multiple -->
            <Column
                selectionMode="multiple"
                :exportable="false"
                :styles="{ 'min-width': '3rem' }"
            ></Column>

            <!-- título -->
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

            <!-- número -->
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

            <!-- videos -->
            <Column
                :header="labels.videos"
                field="videos"
                sortable
                :styles="{ 'min-width': '14rem' }"
                :exportable="false"
            >
                <template #body="{ data }">
                    <Tree :value="getTreeVideos(data.videos)"></Tree>
                </template>
            </Column>

            <!-- created -->
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

            <!-- updated -->
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

            <!-- acciones -->
            <Column
                :header="labels.actions"
                :headerStyle="{ 'min-width': '4rem', 'text-align': 'center' }"
                :bodyStyle="{ 'text-align': 'center', overflow: 'visible' }"
            >
                <template #body="{ data }">
                    <Button
                        icon="fas fa-eye"
                        v-tooltip.top="labels.tooltipShow"
                        class="p-button-info p-button-sm"
                        @click="showPhase(data)"
                    />

                    <a :href="getRoutes(data.id).edit">
                        <!-- <Button
                            icon="fas fa-edit"
                            v-tooltip.top="labels.tooltipEdit"
                            class="p-button-warning p-button-raised p-button-sm"
                        /> -->
                        <Button
                            icon="pi pi-pencil"
                            v-tooltip.top="labels.tooltipEdit"
                            class="p-button-warning p-button-sm"
                        />
                    </a>

                    <Button
                        icon="fas fa-times"
                        v-tooltip.top="labels.tooltipDelete"
                        class="p-button-danger p-button-sm"
                        @click="openDeleteConfirmation(data.id)"
                    />
                </template>
            </Column>
        </DataTable>
        <!-- /tabla de fases - datatables -->

        <!-- Dialogos - modales -->
        <div>
            <!-- Dialog de confirmación para eliminar fase -->
            <DeletePhase
                :labels="labels"
                :display-delete-confirmation="displayDeleteConfirmation"
                @close-delete-confirmation="closeDeleteConfirmation()"
                @confirm-delete-process="deletePhase()"
            />
            <!-- /Dialog de confirmación para eliminar fase -->

            <!-- Dialog de confirmación para eliminar las fases seleccionadas -->
            <DeletePhase
                :labels="labels"
                :display-delete-confirmation="displayDeletePhases"
                @close-delete-confirmation="closeDeleteConfirmation()"
                @confirm-delete-process="deleteSelectedPhases()"
            />
            <!-- /Dialog de confirmación para eliminar las fases seleccionadas -->

            <!-- info de la fase seleccionada -->
            <InfoDialog
                :labels="labels"
                :phase="selectedPhase"
                :display-show-dialog="displayShowDialog"
                @close-show-dialog="displayShowDialog = false"
            />
            <!-- /info de la fase seleccionada -->
        </div>
        <!-- /Dialogos - modales -->
    </div>
</template>

<script>
// import dataTable primevue
import { FilterMatchMode } from "primevue/api";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import DeletePhase from "./components/DeletePhaseComponent.vue";
import InfoDialog from "./components/InfoDialogComponent.vue";

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
        DeletePhase,
        InfoDialog,
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
            selectedPhase: [],

            // mostrar o no el dialog de confirmación de eliminación
            displayDeleteConfirmation: false,

            // mostrar o no el dialog de eliminación de multiples fases
            displayDeletePhases: false,

            // mostrar o no el dialog de info de fase
            displayShowDialog: false,

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
            this.displayDeletePhases = false;
            this.selectedPhase = [];
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
                    this.data = this.data.filter(
                        (phase) => phase.id !== this.selectedPhase
                    );
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.closeDeleteConfirmation();
                    loader.hide();
                });
        },

        /**
         * Exporta los datos de la tabla fases a csvs
         */
        exportCSV() {
            this.$refs.dt.exportCSV();
        },

        /**
         * Abre el diálogo de confirmación de eliminación de multiples fases
         */
        confirmDeleteSelected() {
            this.displayDeletePhases = true;
        },

        /**
         * Elimina las fases seleccionadas
         */
        async deleteSelectedPhases() {
            const loader = this.$loading.show();

            const ids = this.selectedPhases.map((phase) => phase.id);

            await axios
                .post(route("phases.destroySelected"), ids)
                .then((response) => {
                    this.$toast.success(response.data.message);
                    this.data = this.data.filter(
                        (phase) => !ids.includes(phase.id)
                    );
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.closeDeleteConfirmation();
                    loader.hide();
                });
        },

        /**
         * Abre el diálogo de info de fase
         *
         * @param {object} phase    La fase completa
         */
        showPhase(phase) {
            this.selectedPhase = { ...phase };
            this.displayShowDialog = true;
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
