
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
import MobileTable from '@/Components/MobileTable.vue'
import ItemList from '@/Components/ItemList.vue';
import { XMarkIcon } from '@heroicons/vue/16/solid'

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

const shoppingCart = ref([]);

const totalAmount = computed(() => {
  return shoppingCart.value.reduce((total, cartItem) => {
    return total + cartItem.quantity * cartItem.unit_price;
  }, 0).toFixed(2); // Ensure two decimal places
});

// Emitting events
const addToCartHandler = (item) => {
  updateShoppingCart(item);
};

// Method to update the shopping cart
const updateShoppingCart = (item) => {
  const existingCartItemIndex = shoppingCart.value.findIndex(cartItem => cartItem.id === item.id);

  if (existingCartItemIndex === -1) {
    // Item is not in the cart, add it with quantity 1
    shoppingCart.value.push({
      id: item.id,
      code: item.code,
      description: item.description,
      unit_price: parseFloat(item.unit_price), // Convert unit_price to a number
      quantity: 1,
    });
  } else {
    // Item is already in the cart, increment the quantity
    shoppingCart.value[existingCartItemIndex].quantity += 1;
  }

  // Recalculate the total amount
  calculateTotalAmount();
};

// Computed properties
const calculateLineAmount = (cartItem) => {
  return (cartItem.quantity * cartItem.unit_price).toFixed(2); // Ensure two decimal places
};

const removeFromCart = (item) => {
  const existingCartItemIndex = shoppingCart.value.findIndex(cartItem => cartItem.id === item.id);

  if (existingCartItemIndex !== -1) {
    const cartItem = shoppingCart.value[existingCartItemIndex];

    if (cartItem.quantity > 1) {
      // Decrease quantity if greater than 1
      cartItem.quantity -= 1;
    } else {
      // Remove from cart if quantity is 1
      shoppingCart.value.splice(existingCartItemIndex, 1);
    }

    // Recalculate the total amount
    calculateTotalAmount();
  }
};

const updateCart = (item) => {
  // Ensure quantity and unit_price are positive numbers
  item.quantity = Math.max(0, item.quantity);
  item.unit_price = Math.max(0, item.unit_price);

  // Recalculate the line amount and total amount
  calculateTotalAmount();
};
</script>


<template>
    <Head title="Sales-Orders"/>

    <AuthenticatedLayout @add="showModal=true">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-center text-gray-800">Sales Orders</h2>
        </template>

        <div class="grid m-3 border-t-2 sm:grid-cols-1 md:grid-cols-3">
            <div>
                <ItemList :items="items.data" @addToCart="addToCartHandler"/>
            </div>
             <!--cart-->
             <div>
                <h2>Shopping Cart</h2>
                <table class="text-xs">
                <thead>
                    <tr>
                    <th class="p-1 mx-2">Code</th>
                    <th class="p-1 mx-2">Description</th>
                    <th class="p-1 mx-2">Quantity</th>
                    <th class="p-1 mx-2">Unit Price</th>
                    <th class="p-1 mx-2">Line Amount</th>
                    <th class="p-1 mx-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(cartItem, index) in shoppingCart" :key="index" class="-my-1">
                    <td class="mx-2">{{ cartItem.code }}</td>
                    <td class="mx-2">{{ cartItem.description }}</td>
                    <td class="mx-2">
                        <input type="number" v-model="cartItem.quantity" class="w-12 text-xs text-blue-500 bg-transparent border-none outline-none "  @input="updateCart(item)" />
                    </td>
                    <td class="mx-2">
                        <input type="number" v-model="cartItem.unit_price" class="w-24 text-xs text-blue-500 bg-transparent border-none outline-none "  @input="updateCart(item)" />
                    </td>
                    <td class="mx-2"><strong>{{ calculateLineAmount(cartItem) }}</strong></td>
                    <td class="mx-2">
                        <XMarkIcon @click="removeFromCart(cartItem)" class="w-5 h-5" />
                    </td>
                    </tr>
                    <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><strong>{{ totalAmount }}</strong></td>
                    <td></td>
                    </tr>
                </tbody>
                </table>
            </div>
            <div v-if="orders.data.length>0">

                 <div class="p-3 mt-2 text-xs text-center bg-gray-300 rounded-lg shadow-sm " >
                    <Toolbar class="bg-gray-300 ">
                    <template #center>
                      <div class="flex flex-row items-center justify-between">
                        <SearchBox :model="route('salesOrder.index')" class="bg-gray-300"/>
                     <Button icon="pi pi-download" severity="success" text rounded aria-label="Favorite" class="w-3 h-3 p-1 text-xs" />
                      </div>

                    </template>
                    </Toolbar>
                     <table>
                        <thead>
                            <th class="p-1 font-bold text-center">Order No</th>
                            <!-- <th class="p-1 font-bold text-center">External Ref</th> -->
                            <th class="p-1 font-bold text-center">Posting Date</th>
                            <th class="p-1 font-bold text-center">Status</th>
                            <th class="p-1 font-bold text-center">Customer</th>
                            <th class="p-1 font-bold text-center">Value</th>
                            <th class="p-1 font-bold text-center">Actions</th>
                        </thead>
                        <tbody class="px-1">
                            <tr v-for="order in orders.data" :key="order.id" class="px-2 rounded-md hover:bg-slate-400 hover:text-white">
                              <td>{{order.document_no}}</td>
                              <!-- <td>{{order.ext_doc_no}}</td> -->
                              <td>{{order.posting_date}}</td>
                              <td>{{order.status}}</td>
                              <td>{{order.customer.customer_name}}</td>
                              <td>{{formatNumber(order.value)}}</td>
                              <td class="flex flex-row">
                                 <Button icon="pi pi-pencil" severity="help" text rounded aria-label="Favorite" class="w-3 h-3 p-1 text-xs" />
                                    <Button icon="pi pi-times" severity="danger" text rounded aria-label="delete" class="w-3 h-3 p-1 text-xs" />
                              </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination class="w-full text-center" :links="orders.meta.links"/>
                 </div>
            </div>
            <div v-else> No Orders to display</div>
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
