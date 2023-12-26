
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
import axios from 'axios';
import moment from 'moment';
import jsPDF from 'jspdf';
import 'jspdf-autotable';

const totalQuantity = computed(() => {
  return orderLines.value.reduce((total, orderLine) => total + orderLine.quantity, 0);
});

const currentDate = moment().format('DD/MM/YYYY');

const generatePDF = async () => {


  const lineItems = orderLines.value;
  try {
    const response = await axios.get(route('convertLogo'));
    const logo = response.data.dataUrl;

    const totalRow = ['', '', 'Total Amount', ` Ksh.${formatNumber(calculateTotal(lineItems))}`];
    const vatAmountRow = ['', '', 'VAT Amount', `Ksh.${formatNumber(calculateVATAmount(lineItems))}`];

    const grandTotalRow = ['', '', 'Amt. Inc VAT', `Ksh.${formatNumber(calculateTotal(lineItems)+calculateVATAmount(lineItems))}`];

    const doc = new jsPDF();

    // Add company information with reduced font size
   const companyInfoText = [
  `Email: ${props.companyInfo.email}`,
  `Phone: ${props.companyInfo.phone}`,
  `PIN: ${props.companyInfo.pin}`,
];

// Set the font size for company information
doc.setFontSize(8);

// Add each line of company information


    // Add the company information at the top right corner
    companyInfoText.forEach((info, index) => {
      doc.text(info.text, doc.internal.pageSize.width - 10, 10 + index * 10, { align: 'right', fontSize: info.fontSize });
    });

    // Add Batian Optical Centre and Sales Invoice headings
    doc.text('Batian Optical Centre', doc.internal.pageSize.width / 2, 20, { align: 'center' });
    doc.text('Sales Invoice', doc.internal.pageSize.width / 2, 30, { align: 'center' });

    // Add date and serial number with reduced font size
    doc.text(`Date: ${currentDate}`, 10, 20, { fontSize: 8 });
    doc.text(`Invoice No.: ${props.lastSerialNo}`, 10, 30, { fontSize: 8 });

    // Calculate the width and height for the centered logo
    const logoWidth = 15; // Adjust as needed
    const logoHeight = (logoWidth * 50) / 50; // Maintain the aspect ratio
    const xPosition = (doc.internal.pageSize.width - logoWidth) / 2;
    const yPosition = 40; // Adjust as needed

    // Add the logo in the center
    doc.addImage(logo, 'JPEG', xPosition, yPosition, logoWidth, logoHeight);

    const columns = ['Item Name', 'Quantity', 'Unit Price', 'Total Amount'];
    const tableBody = lineItems.map(item => [item.itemName + '-' + item.description, item.quantity, `Ksh.${item.price}`, `Ksh.${formatNumber(item.quantity * item.price)}`]);
    tableBody.push(vatAmountRow, totalRow);
    const rows = [columns, ...tableBody];


    // Adjust startY to position the table below the logo and company information
    const tableYPosition = yPosition + logoHeight + 10; // Adjust as needed

// Set the font size for the table
const tableFontSize = 8; // Adjust as needed

doc.autoTable({
  head: [columns],
  body: tableBody,
  theme: 'grid',
  startY: tableYPosition,
  margin: { top: 10 },
  styles: {
    fontSize: tableFontSize,
  },
});

    // Add the totalRow and vatAmountRow manually
    const totalRowYPosition = tableYPosition + (tableBody.length + 1) * 10; // Adjust as needed
    const vatAmountRowYPosition = totalRowYPosition + 10; // Adjust as needed

    // doc.text(totalRow[2], doc.internal.pageSize.width - 10, totalRowYPosition, { align: 'right', fontSize: 8 });
    // doc.text(totalRow[3], doc.internal.pageSize.width - 10, totalRowYPosition + 10, { align: 'right', fontSize: 8 });
    // doc.text(vatAmountRow[2], doc.internal.pageSize.width - 10, vatAmountRowYPosition, { align: 'right', fontSize: 8 });
    // doc.text(vatAmountRow[3], doc.internal.pageSize.width - 10, vatAmountRowYPosition + 10, { align: 'right', fontSize: 8 });

    doc.save('sales_invoice.pdf');
  } catch (error) {
    console.error('Error fetching image data URL', error);
  }
};


const calculateTotal = (lineItems) => {
  return lineItems.reduce((total, item) => total + item.quantity * item.price, 0) * 1.16.toFixed(2);
};

const removeOrderLine = (index) => {
  orderLines.value.splice(index, 1);
};

const calculateVATAmount = (lineItems) => {
  const vatRate = 0.16;
  const totalAmount = calculateTotal(lineItems) / 1.16;
  return (totalAmount * vatRate).toFixed(2);
};

const orderLines = ref([
  {
    itemName: '',
    quantity: 0,
    price: 0,
    description: '',
  },
]);

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-US').format(number);
};

const addOrderLine = () => {
  orderLines.value.push({
    itemName: '',
    quantity: 0,
    price: 0,
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
    lastSerialNo:String,
    companyInfo:Object,
})

const form= useForm({
    posting_date:new Date(),
    customer_id:'',
    orderLines:'',
    document_no:props.lastSerialNo,
})

const submit=()=>
{
    // console.log(orderLines.value);
    generatePDF()
    form.orderLines=orderLines.value
    form.post(route('salesOrder.store'),{
        onSuccess:()=>{

            Swal.fire('Success!','Order Posted Successfully!','success')

        }
    });
    form.reset();
    showModal.value=false;
}


const updateUnitPrice = (index) => {
    // alert(orderLines.value[index].itemName)
    const selectedItem = props.items.data.find(item => item.code === orderLines.value[index].itemName);
    if (selectedItem) {
        orderLines.value[index].price = selectedItem.unit_price;
        orderLines.value[index].description = selectedItem.description;
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
    { preserveScroll: true},

    )
    else
    form.patch(route('salesOrder.update',form.id),
    { preserveScroll: true,
        onSuccess: () =>{
            Swal.fire(`Order ${mode.state}d Successfully!`,'','success');


        }
    })
    showModal.value=false;
    form.reset();

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
                                                {{ order.document_no }}
                                            </td>

                                            <td class="px-3 py-2 text-xs font-bold text-center ">
                                                {{ order.customer.id }}
                                            </td>
                                            <td class="px-3 py-2 text-xs font-bold text-center ">
                                                {{ order.customer.customer_name}}
                                            </td>
                                            <td class="px-3 py-2 text-xs font-bold text-center ">
                                                {{ order.ext_doc_no}}
                                            </td>

                                            <td class="px-3 py-2 text-xs font-bold text-center ">
                                                {{ order.posting_date }}
                                            </td>
                                            <td class="px-3 py-2 text-xs font-bold text-center ">
                                                {{ order.value }}
                                            </td>
                                            <td class="px-3 py-2 text-xs font-bold text-center ">
                                                {{ order.status }}
                                            </td>


                                            <td>
                                                <div class="flex flex-row">
                                                    <!-- <Drop  :drop-route="route('salesOrder.destroy'),{'order':order.id})"/> -->
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

        <Modal :show="showModal" @close="showModal=false" :max-width="'3xl'" :closeable="true" >

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

                                <div class="flex flex-col items-center justify-between w-full space-x-3 text-xs">
                                    <p>
                                        <form @submit.prevent="addItem(index)">
                                            <div class="my-2 space-x-4 text-xs">
                                                {{ index + 1 }}

                                                <Dropdown
                                                v-model="orderLine.itemName"
                                                :options="props.items.data"
                                                option-label="search_name"
                                                option-value="code"
                                                style="width:100px;"
                                                class="text-xs"
                                                filter
                                                @change="updateUnitPrice(index)"

                                                />

                                                {{ orderLine.description }}
                                                <InputText v-model="orderLine.quantity" type="number" class="text-xs small" required style="width:100px;"/>

                                                <label for="price">Price:</label>
                                                <InputText v-model="orderLine.price" type="number" class="text-xs" required style="width:100px;"/>

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

                        <div class="flex flex-col items-center rounded bg-slate-400 md" v-show="totalQuantity>0">
                            <div class="grid grid-cols-2">
                                <h3 class="m-4 font-bold">Amount</h3>
                                <span class="w-24 p-3 font-bold text-right rounded-lg bg-slate-300">{{ formatNumber(orderTotal) }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <h3 class="m-4 font-bold">VAT</h3>
                                <span class="w-24 p-3 font-bold text-right rounded-lg bg-slate-300">{{ 0 }}</span>
                            </div>
                            <div class="grid grid-cols-2">
                                <h3 class="m-4 font-bold ">Total</h3>
                                <span class="w-24 p-3 font-bold text-right rounded-lg bg-slate-300">{{ formatNumber(orderTotal) }}</span>
                            </div>

                        </div>





                        <Button
                        severity="success"
                        @click="submit"
                        label="Post"
                        icon="pi pi-send"
                        class="icon-left"

                        :disabled="form.processing||form.customer_id==''||(totalQuantity==0)"

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
