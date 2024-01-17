
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
import SalesTrendsChart from '@/Components/SalesTrendsChart.vue';

const props=  defineProps({
    locations:Object,

  })

const form= useForm({
   code:'',
   description:'',
   email:'',
   address:'',
   phone:'',
   id:null,
   blocked:false,

})





const createOrUpdateitem=()=>{
    if (mode.state=='Create')
          form.post(route('locations.store'),
                    { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Location ${mode.state}d Successfully!`,'','success');
                                      showModal.value=false;
                                    }
                    }
                   )
        else
     form.patch(route('locations.update',form.id),
                { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Location ${mode.state}d Successfully!`,'','success');
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

const showUpdateModal=(location)=>{
    mode.state='Update'
    form.code=location.code
    form.description=location.description
    form.email=location.email
    form.phone=location.phone
    form.address=location.address
    form.blocked=(location.blocked=='Yes')?true:false
    form.id=location.id
    showModal.value=true
}
</script>


<template>
    <Head title="Locations"/>

    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Locations</h2>
        </template>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <!--stats bar -->

                        <div>
                            <Toolbar>
                                <template #start>


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
                                        <Pagination :links="locations.meta.links" />
                                    </div>


                                </template>

                                    <template #end>
                                         <SearchBox :model="route('locations.index')" />
                                    </template>
                                   </Toolbar>
                                       <div class="grid sm:grid-cols-1 md:grid-cols-2">

                                        <div v-if="locations.data.length>0" class="relative w-full overflow-x-auto shadow-md sm:rounded-lg">
                                           <table class="text-xs">
                                            <thead>
                                                <tr>
                                                <th class="p-1 mx-3">Code</th>
                                                <th class="p-1 mx-3">Description</th>
                                                <th class="p-1 mx-3">E-mail</th>
                                                <th class="p-1 mx-3">Address</th>
                                                <th class="p-1 mx-3">Phone</th>
                                                <th class="p-1 mx-3">Blocked</th>
                                                <th class="p-1 mx-3">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(location, index) in locations.data" :key="index" class="-my-1">
                                                <td class="mx-3 text-center">{{ location.code }}</td>
                                                <td class="mx-3 text-center">{{ location.description }}</td>
                                                <td class="mx-3 text-center">{{ location.email }}</td>
                                                <td class="mx-3 text-center">{{ location.address }}</td>
                                                <td class="mx-3 text-center">{{ location.phone }}</td>
                                                <td class="mx-3 text-center">{{ location.blocked }}</td>
                                                <td>
                                                    <div class="flex flex-col items-center w-10 h-10 p-1">
                                                          <Drop  :drop-route="route('locations.destroy',{'location':location.id})" class="items-center w-3 h-3 p-1 text-xs"/>
                                                            <Button
                                                                      icon="pi pi-pencil"
                                                                      severity="info"
                                                                      text
                                                                      class="items-center w-3 h-3 p-1 text-xs"


                                                                      @click="showUpdateModal(location)"
                                                                      />
                                                       </div>
                                                </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>


                                        <div v-else class="text-center">
                                          <p>No Locations were found</p>
                                        </div>
                                        <div class="w-full ">
                                           <SalesTrendsChart class="flex overflow-x-auto shadow-md sm:rounded-lg"/>
                                        </div>
                                     </div>
                                    <Toolbar>
                                        <template #center>
                                            <div >
                                                <Pagination :links="locations.meta.links" />
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

        <div  class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> {{mode.state}} Location</div>
        <!-- <div v-else class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> Update item</div> -->

          <form  @submit.prevent="createOrUpdateitem()">

<div class="grid grid-cols-2 gap-3">


       <span class="mt-4 p-float-label">
            <InputText id="code" v-model="form.code" class="w-15" />
            <label for="code">Code</label>
            <InputError class="mt-2" :message="form.errors.code" />
        </span>
       <span class="mt-4 p-float-label">
            <InputText id="description" v-model="form.description" />
            <label for="description">Description</label>
            <InputError class="mt-2" :message="form.errors.description" />
        </span>

       <span class="mt-4 p-float-label">
            <InputText id="email" v-model="form.email" />
            <label for="email">email</label>
            <InputError class="mt-2" :message="form.errors.email" />
        </span>

         <span class="mt-4 p-float-label">
            <InputText id="phone" v-model="form.phone" />
            <label for="phone">Phone</label>
            <InputError class="mt-2" :message="form.errors.phone" />
        </span>
         <span class="mt-4 p-float-label">
            <InputText id="address" v-model="form.address" />
            <label for="address">Address</label>
            <InputError class="mt-2" :message="form.errors.address" />
        </span>
         <InputText
           hidden
           placeholder="id"
           v-model="form.id"

        />
       <div class="space-x-3">
              <label>Blocked?</label>
        <input type="checkbox" v-model="form.blocked" />
        </div>


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
