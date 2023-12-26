

<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'


import { ref, onMounted, computed } from 'vue';
import gsap from 'gsap';
import { usePage } from '@inertiajs/vue3';
import SalesTrendsChart from '@/Components/SalesTrendsChart.vue';


</script>

<!-- resources/js/Pages/SalesSummary.vue -->
<template>
    <Head title="Sales Dashboard" />

    <AuthenticatedLayout>
 <div class="flex flex-wrap items-center justify-around text-center">
    <!-- Sales Today Card -->
    <div class="flex flex-col justify-between p-4 mx-2 my-4 bg-white rounded-md shadow-md">
      <div>
        <h2 class="mb-2 text-xl font-semibold">Sales Today</h2>
        <!-- Your sales today data goes here -->
        <div class="text-3xl font-bold">123</div>
      </div>
      <div class="mt-4 text-sm text-gray-500">+5% from yesterday</div>
    </div>

    <!-- Top 10 Items Card -->
    <div class="flex flex-col justify-between p-4 mx-2 my-4 bg-white rounded-md shadow-md">
      <div>
        <h2 class="mb-2 text-xl font-semibold">Top 10 Items</h2>
        <!-- Your top 10 items data goes here -->
        <div class="text-3xl font-bold">10</div>
      </div>
      <div class="mt-4 text-sm text-gray-500">Best-selling items</div>
    </div>

    <!-- Top 10 Customers Card -->
    <div class="flex flex-col justify-between p-4 mx-2 my-4 bg-white rounded-md shadow-md">
      <div>
        <h2 class="mb-2 text-xl font-semibold">Top 10 Customers</h2>
        <!-- Your top 10 customers data goes here -->
        <div class="text-3xl font-bold">5</div>
      </div>
      <div class="mt-4 text-sm text-gray-500">Loyal customers</div>
    </div>

    <!-- Setups Card -->
    <div class="flex flex-col justify-between p-4 mx-2 my-4 bg-white rounded-md shadow-md">
      <div>
        <h2 class="mb-2 text-xl font-semibold">Setups</h2>
        <!-- Your setups data goes here -->
        <div class="text-3xl font-bold">8</div>
      </div>
      <div class="mt-4 text-sm text-gray-500">Currently active setups</div>
    </div>

  </div>
  <SalesTrendsChart />
  </AuthenticatedLayout>

</template>
