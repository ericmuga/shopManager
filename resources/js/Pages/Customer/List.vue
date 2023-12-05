



<script setup>
import SearchBox from '@/Components/SearchBox.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Toolbar from 'primevue/toolbar';
import { useForm } from '@inertiajs/vue3'
// import { Inertia } from '@inertiajs/inertia';

import debounce from 'lodash/debounce';
import {watch, ref} from 'vue';
import Pagination from '@/Components/Pagination.vue'
import Swal from 'sweetalert2'
import Modal from '@/Components/Modal.vue'
import Drop from '@/Components/Drop.vue'


const form= useForm({
    customer_name:'',
    email:'',
    id_no:'',
    dob:'',
    guardian_id_no:'',
   phone_number:'',
   address:'',
   physical_address:'',
   tax_posting_group_id:'',
   bus_posting_group_id:'',
})





const createOrUpdateCustomer=()=>{
    if (mode.state=='Create')
          form.post(route('customers.store'),
                    { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Customer ${mode.state}d Successfully!`,'','success');
                                    }
                    }
                   )
        else
     form.patch(route('customers.update',form.email),
                { preserveScroll: true,
                      onSuccess: () =>{ form.reset()
                                      Swal.fire(`Customer ${mode.state}d Successfully!`,'','success');
                                    }
                    })
      showModal.value=false;


}


let mode= { state: 'Create' };

const props=  defineProps({
       customers:Object,
       tax_pgs:Object,
       bus_pgs:Object,
    //    roles:Object,
    //    permissions:Object,
  })

  let showModal=ref(false);


const showCreateModal=()=>{
    form.reset();
    mode.state='Create'

    showModal.value=true

}

const showUpdateModal=(customer)=>{

    mode.state='Update'
    form.customer_name=customer.customer_name
    form.email=customer.email
    form.address=customer.address
    form.id_no=customer.id_no
    form.phone_number=customer.phone_number
    form.physical_address=customer.physical_address
    form.guardian_id_no=customer.guardian_id_no
    form.dob=customer.dob
    form.tax_posting_group_id=customer.tax_posting_group_id
    form.bus_posting_group_id=customer.bus_posting_group_id



    showModal.value=true
}
</script>


<template>
    <Head title="Customers"/>

    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Customers</h2>
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
                                        <!-- <SplitButton label="Save" icon="pi pi-check" :model="customers" class="p-button-warning"></SplitButton> -->
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
                                        <Pagination :links="customers.meta.links" />
                                    </div>
                                    <!-- <Modal :show="showModal.value">
                                        <FilterPane :propsData="columnListing" />
                                    </Modal> -->
                                      <!-- <FilterPane :propsData="columnListing" /> -->

                                </template>

                                    <template #end>


                                        <!-- <a :href="route('customers.download')" class="">
                                            <Button icon="pi pi-download" severity="primary" text raised rounded label="customers"/>
                                        </a> -->




                                             <SearchBox :model="route('customers.index')" />
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
                                                           Name
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                            Email
                                                        </th>

                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            Phone No.
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           Address
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            Physical Address
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            DOB
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                            Guardian ID No.
                                                        </th>

                                                        <th scope="col" class="px-6 py-3">
                                                           Actions
                                                        </th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="customer in customers.data" :key="customer.id"
                                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">

                                                    <td class="px-3 py-2 text-xs">
                                                        {{ customer.customer_name }}
                                                    </td>

                                                    <td class="px-3 py-2 text-xs font-bold text-center ">
                                                        {{ customer.email }}
                                                    </td>
                                                    <th scope="col" class="px-6 py-3 text-center">
                                                        {{ customer.phone_number }}
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                          {{customer.address}}
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                           {{ customer.physical_address}}
                                                        </th>
                                                         <th scope="col" class="px-6 py-3 text-center">
                                                            {{customer.dob}}
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-center">
                                                            {{customer.guardian_id_no}}
                                                        </th>

                                                    <td>
                                                       <div class="flex flex-row">
                                                          <Drop  :drop-route="route('customers.destroy',{'customer':customer.id})"/>
                                                            <Button
                                                                      icon="pi pi-pencil"
                                                                      severity="info"
                                                                      text


                                                                      @click="showUpdateModal(customer)"
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
                                <Pagination :links="customers.meta.links" />
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

        <div  class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> {{mode.state}} Customer</div>
        <!-- <div v-else class="w-full p-2 mb-2 tracking-wide text-center text-white rounded-sm bg-slate-500"> Update customer</div> -->

          <form  @submit.prevent="createOrUpdateCustomer()">

<div class="flex flex-col justify-center gap-3">


        <InputText
           placeholder="Name"

           v-model="form.customer_name"
        />
        <InputText

           placeholder="email"
           v-model="form.email"

        />
        <InputText

           placeholder="Phone No."
           v-model="form.phone_number"

        />

        <InputText

           placeholder="id_no"
           v-model="form.id_no"

        />

        <InputText

           placeholder="Guardian ID No."
           v-model="form.guardian_id_no"

        />

        <InputText

           placeholder="Address"
           v-model="form.address"

        />

        <InputText

           placeholder="Physical Address"
           v-model="form.physical_address"

        />

       <div class="flex flex-col items-center justify-center gap-3 p-1">
        <label>D.O.B.</label>
        <input type="date" v-model="form.dob"/>
        <Dropdown
         v-model="form.tax_posting_group_id"
         :options="props.tax_pgs"
         optionValue="id"
         optionLabel="code"
         placeholder="Tax Posting Group"
         filter

        />
         <Dropdown
         v-model="form.bus_posting_group_id"
         :options="props.bus_pgs"
         optionValue="id"
         optionLabel="code"
         placeholder="Bus Posting Group"
         filter

        />
       </div>
        <!-- <Password v-model="form.Password" :feedback="true" /> -->


     <div class="flex flex-row items-center justify-center gap-3 p-1 text-center ">
        <Button

          type="submit"
          :label=mode.state
          :disabled="form.processing"
          icon="pi pi-send"
          severity="success"
          class="w-1/2"

        />


        <Button label="Cancel" severity="warning" icon="pi pi-cancel" @click="showModal=false" class="w-1/2" />
        </div>
</div>

    </form>

     </div>

  </Modal>
</AuthenticatedLayout>

</template>
<style lang="scss" scoped>

</style>
