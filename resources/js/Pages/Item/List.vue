
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
    items:Object,
    posting_groups:Object,
  })

const form= useForm({
   code:'',
   description:'',
   base_uom:'',
   sales_uom:'',
   unit_cost:'',
   unit_price:'',
   posting_group_id:'',
   blocked:false,
   id:null
})





const createOrUpdateitem=()=>{
    if (mode.state=='Create')
          form.post(route('itemPostingGroups.store'),
                    { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`item ${mode.state}d Successfully!`,'','success');
                                    }
                    }
                   )
        else
     form.patch(route('itemPostingGroups.update',form.id),
                { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`item ${mode.state}d Successfully!`,'','success');
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

const showUpdateModal=(item)=>{

    mode.state='Update'
    form.code=item.code
    form.description=item.description
    form.id=item.id
    form.posting_group_id=item.posting_group_id
    form.base_uom=item.base_uom
    form.sales_uom=item.sales_uom
    form.blocked=item.blocked
    form.unit_cost=item.unit_cost
    form.unit_price=item.unit_price


    showModal.value=true
}
</script>


<template>
    <Head title="Items"/>

    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Items</h2>
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
                                        <!-- <SplitButton label="Save" icon="pi pi-check" :model="items" class="p-button-warning"></SplitButton> -->
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
                                        <Pagination :links="items.meta.links" />
                                    </div>
                                    <!-- <Modal :show="showModal.value">
                                        <FilterPane :propsData="columnListing" />
                                    </Modal> -->
                                      <!-- <FilterPane :propsData="columnListing" /> -->

                                </template>

                                    <template #end>


                                        <!-- <a :href="route('itemPostingGroups.download')" class="">
                                            <Button icon="pi pi-download" severity="primary" text raised rounded label="items"/>
                                        </a> -->




                                             <SearchBox :model="route('items.index')" />
                                    </template>
                                        </Toolbar>

                                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                                                    <tr class="bg-slate-300">
                                                        <!-- <th scope="col" class="px-6 py-3">
                                                            Barcode
                                                        </th> -->
                                                        <th scope="col" class="px-6 py-3">
                                                           Code
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                           Description
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                            Unit Cost
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            Unit Price
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           Posting Group
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           Sales UOM
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            Base UOM
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                          Blocked
                                                        </th>


                                                        <th scope="col" class="px-6 py-3">
                                                           Actions
                                                        </th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in items.data" :key="item.id"
                                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

                                                    <td class="px-3 py-2 text-xs">
                                                        {{ item.code }}
                                                    </td>

                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.description }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.unit_cost}}
                                                    </td>
                                                     <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.unit_price}}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.posting_group.code }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.sales_uom }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.base_uom }}
                                                    </td>


                                                    <td>
                                                       <div class="flex flex-row">
                                                          <Drop  :drop-route="route('items.destroy',{'item':item.id})"/>
                                                            <Button
                                                                      icon="pi pi-pencil"
                                                                      severity="info"
                                                                      text


                                                                      @click="showUpdateModal(item)"
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
                                <Pagination :links="items.meta.links" />
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

        <div  class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> {{mode.state}} Item</div>
        <!-- <div v-else class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> Update item</div> -->

          <form  @submit.prevent="createOrUpdateitem()">

<div class="flex flex-col justify-center gap-3">


        <InputText
           placeholder="Code"

           v-model="form.code"
        />
        <InputText

           placeholder="Description"
           v-model="form.description"

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
