<script setup>
    import { ref, reactive,onMounted } from 'vue';
    import SearchBox from '@/Components/SearchBox.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Toolbar from 'primevue/toolbar';

import Pagination from '@/Components/Pagination.vue'
import Swal from 'sweetalert2'
import Modal from '@/Components/Modal.vue'
import Drop from '@/Components/Drop.vue'
import InputError from '@/Components/InputError.vue'
import Document from '@/Pages/InventoryAdjustments/Document.vue'

  const props= defineProps(['inventoryAdjustment']);
  let showModal=ref(true);
</script>

<template>
     <Head title="Inventory Adjustments"/>

    <AuthenticatedLayout >
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-center text-gray-800">Inventory Adjustments</h2>
        </template>
        <Modal  :show="showModal" @close="showModal=false" class="h-48">
        <Document/>
    </Modal>
    </AuthenticatedLayout>
</template>




<style lang="scss" scoped>

</style>
