<template>
    <Dialog
        :header="labels.confirmationTitle"
        :visible.sync="displayDeleteConfirmation"
        :style="{ width: '350px' }"
        :modal="true"
    >
        <div class="confirmation-content">
            <i
                class="pi pi-exclamation-triangle p-mr-3"
                style="font-size: 2rem"
            />
            <span>{{ labels.confirmationText }}</span>
        </div>
        <template #footer>
            <Button
                :label="labels.no"
                icon="pi pi-times"
                @click="$emit('close-delete-confirmation')"
                class="p-button-danger p-button-raised"
            />
            <Button
                :label="labels.yes"
                icon="pi pi-check"
                @click="$emit('delete-phase')"
                class="p-button-success p-button-raised"
                autofocus
            />
        </template>
    </Dialog>
</template>

<script>
// imports
import Dialog from "primevue/dialog";
import Button from "primevue/button";

export default {
    name: "Deletephasecomponent",
    components: {
        Dialog,
        Button
    },
    props: {
        labels: {
            required: true,
        },
        displayDeleteConfirmation: {
            required: true,
        },
        selectedPhase: {
            required: true,
        },
    },
};
</script>
