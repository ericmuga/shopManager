
<script setup>
import SearchBox from '@/Components/SearchBox.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Toolbar from 'primevue/toolbar';
import { useForm } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import Swal from 'sweetalert2'
import Modal from '@/Components/Modal.vue'
import Drop from '@/Components/Drop.vue'
import {watch, ref,computed} from 'vue';
import { format } from 'date-fns';

const removeOrderLine = (index) => {
  orderLines.value.splice(index, 1);
};

const orderLines = ref([
  {
    itemName: '',
    quantity: 0,
    price: 0
  }
]);

const addOrderLine = () => {
  orderLines.value.push({
    itemName: '',
    quantity: 0,
    price: 0
  });
};

const addItem = (index) => {
  // Add your logic here to handle the submission of the form data,
  // for example, you can send the data to the server or perform
  // any necessary operations.
  console.log('Item added:', orderLines.value[index]);

  // Optional: Clear the form fields after adding the item
  orderLines.value[index] = {
    itemName: '',
    quantity: 0,
    price: 0
  };
};


const props=  defineProps({
    orders:Object,
    customers:Object,
    items:Object,
  })

const form= useForm({
  posting_date:new Date(),
  customer_id:'',
  orderLines:'',
})

const submit=()=>
{
    console.log(orderLines.value);
  form.orderLines=orderLines.value
  form.post(route('salesOrder.store'))
}


const updateUnitPrice = (index) => {
    // alert(orderLines.value[index].itemName)
  const selectedItem = props.items.find(item => item.code === orderLines.value[index].itemName);
  if (selectedItem) {
    orderLines.value[index].price = selectedItem.unit_price;
  }
};

const lineAmount = (index) => {
  return orderLines.value[index].quantity * orderLines.value[index].price;
};

const orderTotal = computed(() => {
  return orderLines.value.reduce((total, line) => total + lineAmount(orderLines.value.indexOf(line)), 0);
});


const createOrUpdateorder=()=>{
    if (mode.state=='Create')
          form.post(route('salesOrder.store'),
                    { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Order ${mode.state}d Successfully!`,'','success');
                                    }
                    }
                   )
        else
     form.patch(route('salesOrder.update',form.id),
                { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Order ${mode.state}d Successfully!`,'','success');
                                    }
                    })
      showModal.value=false;


}


let mode= { state: 'Create' };



  let showModal=ref(false);


const showCreateModal=()=>{
    form.reset();
    mode.state='Create'

    showModal.value=true

}

const showUpdateModal=(order)=>{

    mode.state='Update'
    // form.code=order.code
    // form.description=order.description
    // form.id=order.id
    // form.posting_group_id=order.posting_group_id
    // form.base_uom=order.base_uom
    // form.sales_uom=order.sales_uom
    // form.blocked=order.blocked
    // form.unit_cost=order.unit_cost
    // form.unit_price=order.unit_price


    showModal.value=true
}
</script>


<template>
    <Head title="Sales-Orders"/>
n
    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Sales Orders</h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!--stats bar -->

                        <div>
                            <Toolbar>
                                <template #start>
                                    <!-- <Button label="New" icon="pi pi-plus" class="mr-2" />
                                        <Button label="Upload" icon="pi pi-upload" class="p-button-success" /> -->
                                        <!-- <i class="mr-2 pi pi-bars p-toolbar-separator" /> -->
                                        <!-- <SplitButton label="Save" icon="pi pi-check" :model="orders" class="p-button-warning"></SplitButton> -->
                                    <Button
                                         label="Add"
                                         icon="pi pi-plus"

                                         severity="success"
                                         @click="showCreateModal()"
                                         rounded
                                    ></Button>
                                </template>
                                <template #center>
                                    <div>
                                        <Pagination :links="orders.meta.links" />
                                    </div>
                                    <!-- <Modal :show="showModal.value">
                                        <FilterPane :propsData="columnListing" />
                                    </Modal> -->
                                      <!-- <FilterPane :propsData="columnListing" /> -->

                                </template>

                                    <template #end>


                                        <!-- <a :href="route('orderPostingGroups.download')" class="">
                                            <Button icon="pi pi-download" severity="primary" text raised rounded label="orders"/>
                                        </a> -->




                                             <SearchBox :model="route('salesOrder.index')" />
                                    </template>
                                        </Toolbar>

                                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                                                    <tr class="bg-slate-300">
                                                        <th scope="col" class="px-6 py-3">
                                                            Order No.
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                           Customer No.
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                           Customer Name
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                          External Document No.
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                            Tax UUID
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            Posting Date
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           Value
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           Status
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                           Actions
                                                        </th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="order in orders.data" :key="order.id"
                                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

                                                    <td class="px-3 py-2 text-xs">
                                                        {{ order.id }}
                                                    </td>

                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ order.customer_no }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ order.customer_name}}
                                                    </td>
                                                     <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ order.ext_doc_no}}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ order.tax_uuid }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ order.posting_date }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ order.value }}
                                                    </td>


                                                    <td>
                                                       <div class="flex flex-row">
                                                          <Drop  :drop-route="route('salesOrder.destroy',{'order':order.id})"/>
                                                            <Button
                                                                      icon="pi pi-pencil"
                                                                      severity="info"
                                                                      text


                                                                      @click="showUpdateModal(order)"
                                                                      />
                                                       </div>
                                                    </td>

                                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <Toolbar>
                        <template #center>
                            <div >
                                <Pagination :links="orders.meta.links" />
                            </div>
                        </template>
                    </Toolbar>


                </div>




                <!--end of stats bar-->

            </div>
        </div>
    </div>
</div>

   <Modal :show="showModal" @close="showModal=false" >

     <div class="flex flex-col p-4 rounded-sm">

        <div  class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> {{mode.state}} Sales Order</div>
        <!-- <div v-else class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> Update order</div> -->

          <form  @submit.prevent="createOrUpdateorder()">

<div class="flex flex-col justify-center gap-3">
        <div class="flex flex-row items-center justify-center gap-2 p-1">

          <Calendar v-model="form.posting_date" dateFormat="dd/mm/yy" />
        </div>

        <div class="flex flex-row items-center justify-center gap-2 p-1">

            <Dropdown
            v-model="form.customer_id"
            :options="props.customers"
            optionValue="id"
            optionLabel="customer_name"
            placeholder="Select Customer"
            />
        </div>





       <div>
            <h2 class="text-center">Items</h2>
            <div v-for="(orderLine, index) in orderLines" :key="index" >

            <div class="flex flex-col items-center justify-between w-full space-x-3">
                <p>
            <form @submit.prevent="addItem(index)">
                <div class="my-2">
                 {{ index + 1 }}

                <Dropdown
                 v-model="orderLine.itemName"
                 :options="props.items"
                 option-label="code"
                 option-value="code"
                 style="width:100px;"
                 filter
                 @change="updateUnitPrice(index)"

                />

                <label for="quantity">Qty:</label>
                <InputText v-model="orderLine.quantity" type="number" class="small" required style="width:100px;"/>

                <label for="price">Price:</label>
                <InputText v-model="orderLine.price" type="number" required style="width:100px;"/>

                 <span>{{ lineAmount(index) }}</span>

            <Button @click="addOrderLine" icon="pi pi-add" severity="success" label="+" />
            <Button  @click="removeOrderLine(index)" severity="danger" label="-" :disabled="orderLines.length==1"/>
                <!-- <button type="submit">Add Item</button> -->
                </div>

            </form>
            </p>
            </div>
            </div>


        </div>

<div class="flex justify-end p-3 text-center rounded bg-slate-400 md">
      <h3>Total Order Amount:</h3>
      <span>{{ orderTotal }}</span>
    </div>





        <Button
          severity="info"
         @click="submit"
          :label=mode.state
          :disabled="form.processing"

        />


        <Button label="Cancel" severity="warning" icon="pi pi-cancel" @click="showModal=false"/>
</div>

    </form>

     </div>

  </Modal>
</AuthenticatedLayout>

</template>
<style lang="scss" scoped>

</style>
