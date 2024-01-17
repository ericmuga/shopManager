<script setup>
import { ref, reactive,onMounted,computed,watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useInventoryStore } from '@/Stores/useInventoryStore';
import moment from 'moment';
import { XMarkIcon } from '@heroicons/vue/16/solid'



const inventoryStore = useInventoryStore();
const loading = ref(true);
onMounted(() => {

   inventoryStore.fetchItems();
   inventoryStore.fetchLocations();
});
const itemOptions = computed(() => inventoryStore.items);
const locationOptions = computed(() => inventoryStore.locations);

const currentDate = moment().format('DD/MM/YYYY');
const form = reactive({
  status: 'Open',
  posting_date: currentDate,
  document_no: '',
  ext_doc_no: '',
  entry_type:'',
  lines: [
    {
    //   entry_type: '',
      location: null,
      item: null,
      unit_cost: null,
      quantity:0,
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


watch(() => form.lines.map(line => line.item), async (newItems, oldItems) => {
  for (let i = 0; i < newItems.length; i++) {
    const newItem = newItems[i];
    const oldItem = oldItems[i];

    // Check if the item has changed
    if (newItem !== oldItem) {
      // Fetch the selected item's details, assuming it has a property 'unit_cost'
      const selectedItem = inventoryStore.items.find(item => item.id === newItem);

      // Update the line's unit cost with the selected item's unit cost
      if (selectedItem) {
        form.lines[i].unit_cost = selectedItem.unit_cost;
      }
    }
  }
});

</script>


<template>
  <div>
    <div class="w-full p-2 text-center bg-teal-200 rounded-md">Inventory Adjustment</div>
    <form @submit.prevent="saveAdjustment" class="items-center text-center">
      <!-- Adjustment Header Fields -->
      <div class="grid items-center w-full grid-cols-3 p-3 mt-3">
        <span class="flex flex-col items-center mt-1 place-items-center ">
            <label for="status">Status</label>
            <InputText id="status" v-model="form.status" class="w-32 h-5" disabled/>
        </span>

        <span class="flex flex-col items-center mt-1 place-items-center">
           <label>Posting Date:</label>
            <Calendar v-model="form.posting_date" class="w-32 h-5" />

        </span>

        <span class="flex flex-col items-center mt-1 place-items-center">
            <label>Document No.</label>
            <InputText v-model="form.document_no" class="w-32 h-5" />

        </span>
        <span class="flex flex-col items-center mt-1 place-items-center">
            <label>Entry Type</label>
             <select v-model="entry_types" class="w-32 h-10 text-xs text-blue-500 bg-transparent border-none rounded-md outline-none">
                <option v-for="entry_type in entry_types" :key="entry_type.id" :value="entry_type.id">{{ entry_type.type }}</option>
            </select>

        </span>
        <span class="flex flex-col items-center mt-1 place-items-center">
            <label>External Document No.</label>
            <InputText v-model="form.ext_doc_no" class="w-32 h-5" />

        </span>
      </div>
       <div class="w-full p-4">
            <hr>
        </div>
    <div class="table-wrapper">


      <!-- Adjustment Line Fields -->
      <table class="p-1 mx-2">
        <thead>
            <tr class="relative overflow-x-auto text-left wrap ">
                <th>#</th>
                <th>Item</th>
                <th>Location</th>
                <th class="w-20">Quantity</th>
                <th>Unit Cost</th>
                <th>Line Cost</th>
            </tr>
        </thead>

       <tbody>
      <tr v-for="(line, index) in form.lines" :key="index" class="items-center -my-1 text-center " >
         <td>{{ index+1 }}</td>
         <td>  <select v-model="line.item" class="h-10 text-xs text-blue-500 bg-transparent border-none rounded-md outline-none w-42">
                    <option v-for="item in itemOptions" :key="item.id" :value="item.id">{{ item.search_name }}</option>
                </select>
        </td>
        <td>
            <select v-model="line.location" class="h-10 text-xs text-blue-500 bg-transparent border-none rounded-md outline-none w-28">
                <option v-for="location in locationOptions" :key="location.id" :value="location.id">{{ location.code }}</option>
            </select>
        </td>
        <td><input v-model="line.quantity" class="w-20 text-xs text-blue-500 bg-transparent border-none rounded-md outline-none " /></td>
         <td><input v-model="line.unit_cost" class="w-20 text-xs text-blue-500 bg-transparent border-none rounded-md outline-none " /></td>
         <td>{{line.unit_cost*line.quantity}}</td>
         <td class="flex flex-row gap-2 mt-2 place-items-center">
             <button @click.prevent="addLine" type="button" class="btn btn-primary">+</button>
             <XMarkIcon @click="removeLine(cartItem)" class="w-5 h-5" />
        </td>

      </tr>
      </tbody>
    </table>
    </div>
      <div class="flex justify-center gap-2 m-3">
        <Button type="submit" severity="info" class="h-10">Save</button>
        <Button @click.prevent="postAdjustment" severity="success" class="h-10">Post</button>
      </div>
    </form>
  </div>

</template>

<style>
.table-wrapper {
    overflow-x: auto;
  }

  table {
    width: 80%;
    border-collapse: collapse;
  }

  th, td {
    padding: 4px;
    text-align: left;
  }

  th {
    white-space: nowrap;
  }
</style>
