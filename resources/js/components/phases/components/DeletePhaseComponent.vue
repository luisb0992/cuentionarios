<template>
    <Dialog
        :header="labels.confirmationTitle"
        :visible.sync="displayDeleteConfirmation"
        :style="{ width: '350px' }"
        :modal="true"
    >
        <div class="confirmation-content">
            <i class="fas fa-exclamation-triangle" />
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
                @click="$emit('confirm-delete-process')"
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
        Button,
    },
    props: {
        labels: {
            required: true,
        },
        displayDeleteConfirmation: {
            required: true,
        },
    },
};
</script>
