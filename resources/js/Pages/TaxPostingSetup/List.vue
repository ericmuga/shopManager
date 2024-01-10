
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
import InputError from '@/Components/InputError.vue'

const props=  defineProps({
    setups:Object,
    bus_tax_groups:Object,
    item_tax_groups:Object,
  })

const form= useForm({
   item_tax_group_id:'',
   bus_tax_group_id:'',
   tax_identifier:'',
   tax_rate:'',
   id:null,
})





const createOrUpdateSetup=()=>{
    if (mode.state=='Create')
          form.post(route('taxPostingSetups.store'),
                    { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Setup ${mode.state}d Successfully!`,'','success');
                                      showModal.value=false;
                                    }
                    }
                   )
        else
     form.patch(route('taxPostingSetups.update',form.id),
                { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Setup ${mode.state}d Successfully!`,'','success');
                                      showModal.value=false;
                                    }
                    })



}


let mode= { state: 'Create' };



  let showModal=ref(false);


const showCreateModal=()=>{
    form.reset();
    mode.state='Create'

    showModal.value=true

}

const showUpdateModal=(setup)=>{

    mode.state='Update'
    form.item_tax_group_id=setup.item_tax_group_id
    form.bus_tax_group_id=setup.bus_tax_group_id
    form.tax_identifier=setup.tax_identifier
    form.tax_rate=setup.tax_rate
    form.id=setup.id
    showModal.value=true
}
</script>


<template>
    <Head title="Tax Setups"/>

    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-center text-gray-800">Tax Posting Setups</h2>
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
                                        <Pagination :links="setups.meta.links" />
                                    </div>
                                    <!-- <Modal :show="showModal.value">
                                        <FilterPane :propsData="columnListing" />
                                    </Modal> -->
                                      <!-- <FilterPane :propsData="columnListing" /> -->

                                </template>

                                    <template #end>


                                        <!-- <a :href="route('items.download')" class="">
                                            <Button icon="pi pi-download" severity="primary" text raised rounded label="items"/>
                                        </a> -->




                                             <SearchBox :model="route('taxPostingSetups.index')" />
                                    </template>
                                        </Toolbar>

                                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                                                    <tr class="bg-slate-300">
                                                        <!-- <th scope="col" class="px-6 py-3">
                                                            Barcode
                                                        </th> -->
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                           Item Tax Group
                                                        </th>
                                                        <th scope="col" class="px-6 py-3">
                                                           Business Tax Group
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                            Identifier
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            Tax Rate %
                                                        </th>


                                                        <th scope="col" class="px-6 py-3">
                                                           Actions
                                                        </th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="setup in setups.data" :key="setup.id"
                                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

                                                    <td class="px-3 py-2 text-xs text-center">
                                                        {{ setup.itemTaxGroup.code }}
                                                    </td>

                                                    <td class="px-3 py-2 text-xs text-center ">
                                                        {{ setup.busTaxGroup.code }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs text-center ">
                                                        {{ setup.tax_identifier}}
                                                    </td>
                                                     <td class="px-3 py-2 text-xs text-center ">
                                                        {{ setup.tax_rate}}
                                                    </td>




                                                    <td>
                                                       <div class="flex flex-row">
                                                          <Drop  :drop-route="route('taxPostingSetups.destroy',{'taxPostingSetup':setup.id})"/>
                                                            <Button
                                                                      icon="pi pi-pencil"
                                                                      severity="info"
                                                                      text


                                                                      @click="showUpdateModal(setup)"
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
                                <Pagination :links="setups.meta.links" />
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

        <div  class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> {{mode.state}} Setup </div>
        <!-- <div v-else class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> Update item</div> -->

          <form  @submit.prevent="createOrUpdateSetup()">

<div class="grid grid-cols-2 gap-3">






        <div>
            <Dropdown
                   filter
                    placeholder="Item Posting Group"
                    v-model="form.item_tax_group_id"
                    :options="props.item_tax_groups"
                    option-value="id"
                    option-label="code"
            />
            <InputError class="mt-2" :message="form.errors.item_tax_group_id" />
        </div>
        <div>
            <Dropdown
                        filter
                    placeholder="Business Posting Group"
                    v-model="form.bus_tax_group_id"
                    :options="props.bus_tax_groups"
                    option-value="id"
                    option-label="code"
            />
            <InputError class="mt-2" :message="form.errors.bus_tax_group_id" />
        </div>

         <span class="mt-4 p-float-label">
            <InputNumber id="tax_rate" v-model="form.tax_rate" />
            <label for="tax_rate">Tax Rate  %</label>
            <InputError class="mt-2" :message="form.errors.tax_rate" />
        </span>

         <span class="mt-4 p-float-label">
            <InputText id="code" v-model="form.tax_identifier" class="w-15" />
            <label for="code">Identifier (unique)</label>
            <InputError class="mt-2" :message="form.errors.tax_identifier" />
        </span>

 <div>


        <InputText
           hidden
           placeholder="id"
           v-model="form.id"

        />
    </div>
</div>
        <div class="flex justify-center gap-3 my-2">


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
