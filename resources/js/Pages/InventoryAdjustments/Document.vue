<script setup>
import { ref, reactive,onMounted,computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useInventoryStore } from '@/Stores/useInventoryStore';

const inventoryStore = useInventoryStore();
const loading = ref(true);
onMounted(() => {

   inventoryStore.fetchItems();
});
const itemOptions = computed(() => inventoryStore.items);
const locationOptions = computed(() => inventoryStore.locations);

const form = reactive({
  status: '',
  posting_date: null,
  document_no: '',
  ext_doc_no: '',
  lines: [
    {
      entry_type: '',
      location: null,
      item: null,
      unit_cost: null,
    },
  ],
});

const { data, post, processing } = useForm(form);

const entry_types=[{'id':1,'type':'+ve Adjustment'},{'id':2,'type':'-ve Adjustments'},{'id':3,'type':'Transfer'},{'id':4,'type':'Stock Take'}]

const addLine = () => {
  form.lines.push({
    entry_type: '',
    location: null,
    item: null,
    unit_cost: null,
  });
};

const removeLine = (index) => {
  form.lines.splice(index, 1);
};

const saveAdjustment = () => {
  post(route('adjustment.store'));
};

const postAdjustment = () => {
  // Logic to post adjustment
};

</script>


<template>
  <div>
    <h2>Create Inventory Adjustment</h2>
    <form @submit.prevent="saveAdjustment" class="p-4 space-y-4">
      <!-- Adjustment Header Fields -->
      <div class="flex space-x-4">
        <div class="w-1/2">
          <label>Status:</label>
          <InputText v-model="form.status" />
        </div>
        <div class="w-1/2">
          <label>Posting Date:</label>
          <Calendar v-model="form.posting_date" />
        </div>
      </div>
      <div class="flex space-x-4">
        <div class="w-1/2">
          <label>Document No:</label>
          <InputText v-model="form.document_no" />
        </div>
        <div class="w-1/2">
          <label>External Doc No:</label>
          <InputText v-model="form.ext_doc_no" />
        </div>
      </div>

      <!-- Adjustment Line Fields -->
      <div v-for="(line, index) in form.lines" :key="index" class="flex space-x-4">
        <div class="w-1/4">
          <label>Entry Type:</label>
          <InputText v-model="line.entry_type" />
        </div>
        <div class="w-1/4">
          <label>Location:</label>
          <Dropdown v-model="line.location" :options="locationOptions" />
        </div>
        <div class="w-1/4">
          <label>Item:</label>
          <Dropdown v-model="line.item" :options="itemOptions" />
        </div>
        <div class="w-1/4">
          <label>Unit Cost:</label>
          <InputText v-model="line.unit_cost" />
        </div>
        <div>
          <button @click.prevent="removeLine(index)" type="button" class="btn btn-danger">Remove Line</button>
        </div>
      </div>

      <!-- Add Line Button -->
      <div>
        <button @click.prevent="addLine" type="button" class="btn btn-primary">Add Line</button>
      </div>

      <!-- Save and Post Buttons -->
      <div>
        <button type="submit" class="btn btn-success">Save</button>
        <button @click.prevent="postAdjustment" class="btn btn-primary">Post</button>
      </div>
    </form>
  </div>
</template>

