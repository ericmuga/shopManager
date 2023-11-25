
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
import {watch, ref} from 'vue';


const props=  defineProps({
    orders:Object,
    customers:Object,
    posting_groups:Object,
  })

const form= useForm({
  posting_date:''
})





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
    <Head title="Orders"/>

    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Orders</h2>
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




                                             <SearchBox :model="route('orders.index')" />
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
                                                          <Drop  :drop-route="route('orders.destroy',{'order':order.id})"/>
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

        <div  class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> {{mode.state}} order</div>
        <!-- <div v-else class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> Update order</div> -->

          <form  @submit.prevent="createOrUpdateorder()">

<div class="flex flex-col justify-center gap-3">

        <label >Posting Date</label>
        <input type="date" placeholder="Posting Pate" v-model="form.posting_date"/>

        <Dropdown
          v-model="form.customer_id"
          :options="props.customers"
        />

        <InputText

           placeholder="Sales UOM"
           v-model="form.sales_uom"

        />

         <InputText

           placeholder="base_uom"
           v-model="form.base_uom"

        />
         <InputNumber

           placeholder="Unit Cost"
           v-model="form.unit_cost"

        />
         <InputNumber

           placeholder="Unit Price"
           v-model="form.unit_price"

        />
         <Dropdown
            filter
           placeholder="Posting Group"
           v-model="form.posting_group_id"
           :options="props.posting_groups.data"
           optionValue="id"
           optionLabel="code"

        />

        <Dropdown
            filter
           placeholder="Tax Group"
           v-model="form.posting_group_id"
           :options="props.posting_groups.data"
           optionValue="id"
           optionLabel="code"

        />

        <InputText
           hidden
           placeholder="id"
           v-model="form.id"

        />

        <label>Blocked?</label>
        <input type="checkbox" v-model="form.blocked" />

        <Button
          severity="info"
          type="submit"
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
