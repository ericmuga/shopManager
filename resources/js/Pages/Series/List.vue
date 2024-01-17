
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
import { ref} from 'vue';
import InputError from '@/Components/InputError.vue'

const props=  defineProps({
    series:Object,

    // posting_groups:Object,
    // tax_groups:Object,
  })

const form= useForm({
   series_code:'',
   type:'',
   last_no_used:'',
   last_date_used:'',
   characters:'',
//    id:''

})





const createOrUpdateitem=()=>{
    if (mode.state=='Create')
          form.post(route('series.store'),
                    { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Series ${mode.state}d Successfully!`,'','success');
                                      showModal.value=false;
                                    }
                    }
                   )
        else
     form.patch(route('series.update',form.id),
                { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Series ${mode.state}d Successfully!`,'','success');
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

const showUpdateModal=(item)=>{

    mode.state='Update'
    form.series_code=item.series_code
    form.type=item.type
    form.last_date_used=item.last_date_used
    form.last_no_used=item.last_no_used
    form.characters=item.characters
    form.id=item.id
    showModal.value=true
}
</script>


<template>
    <Head title="Series Codes"/>

    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Series</h2>
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
                                        <Pagination :links="series.meta.links" />
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




                                             <SearchBox :model="route('series.index')" />
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
                                                           Document Type
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                            Last No. Used
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           Last Date Used
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           Characters
                                                        </th>


                                                        <th scope="col" class="px-6 py-3">
                                                           Actions
                                                        </th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in series.data" :key="item.id"
                                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

                                                    <td class="px-3 py-2 text-xs">
                                                        {{ item.series_code }}
                                                    </td>

                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.type }}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.last_no_used}}
                                                    </td>
                                                     <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.last_date_used}}
                                                    </td>
                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ item.characters }}
                                                    </td>




                                                    <td>
                                                       <div class="flex flex-row">
                                                          <Drop  :drop-route="route('series.destroy',{'series':item.id})"/>
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
                                <Pagination :links="series.meta.links" />
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

        <div  class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> {{mode.state}} Series</div>
        <!-- <div v-else class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> Update item</div> -->

          <form  @submit.prevent="createOrUpdateitem()">

<div class="grid grid-cols-2 ">


       <span class="mt-2 p-float-label">
            <InputText id="code" v-model="form.series_code" />
            <label for="code">Code</label>
            <InputError class="mt-2" :message="form.errors.series_code" />
        </span>
       <span class="mt-4 p-float-label">
            <Dropdown
             id="description"
             v-model="form.type"
             :options="['Sales Invoice','Purchase Invoice','Purchase Order','Sales Order','Purchase Quote','Sales Quote','Item','Customer','Vendor']"
             placeholder="Type"
             filter
             />
                <InputError class="mt-2" :message="form.errors.type" />
        </span>

       <span class="flex flex-col mx-2 mt-2">
            <label for="last_date_used">Last Date Used</label>
            <input  type="date" id="last_date_used" v-model="form.last_date_used" />
            <InputError class="mt-2" :message="form.errors.last_date_used" />
        </span>

         <span class="flex flex-col mt-2">
            <label for="last_no_used">Last No. Used</label>
            <InputText id="last_no_used" v-model="form.last_no_used" />
            <InputError class="mt-2" :message="form.errors.last_no_used" />
        </span>

        <span class="flex flex-col mt-2">
            <label for="characters">No. Of Characters</label>
            <InputText id="characters" v-model="form.characters" />
            <InputError class="mt-2" :message="form.errors.characters" />
        </span>


        <InputText
           hidden
           placeholder="id"
           v-model="form.id"

        />

       <div class="flex flex-row justify-center col-span-2 space-x-3">
         <Button
          severity="info"
          type="submit"
          :label=mode.state
          :disabled="form.processing"

        />
        <Button label="Cancel" severity="warning" icon="pi pi-cancel" @click="showModal=false"/>
</div>


</div>

    </form>

     </div>

  </Modal>
</AuthenticatedLayout>

</template>
<style lang="scss" scoped>

</style>
