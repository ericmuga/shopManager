<script setup>
   // import {  } from 'vue';
 const props=defineProps({
    data:Object,
 });

</script>

<template>
    <div class="flex items-center justify-center">
        <!-- component -->

	<!-- <div class="container"> -->
		<table class="flex flex-row flex-no-wrap w-full my-5 overflow-hidden rounded-lg sm:bg-white sm:shadow-lg">
			<thead >
				<tr class="flex flex-col mb-2 bg-teal-400 rounded-l-lg flex-no wrap sm:table-row sm:rounded-none sm:mb-0">
					<th class="p-3 text-left">Name</th>
					<th class="p-3 text-left">Email</th>
					<th class="p-3 text-left" width="110px">Actions</th>
				</tr>

			</thead>
			<tbody class="flex-1 sm:flex-none">
				<tr class="flex flex-col mb-2 flex-no wrap sm:table-row sm:mb-0">
					<td class="p-3 border border-grey-light hover:bg-gray-100">John Covv</td>
					<td class="p-3 truncate border border-grey-light hover:bg-gray-100">contato@johncovv.com</td>
					<td class="p-3 text-red-400 border cursor-pointer border-grey-light hover:bg-gray-100 hover:text-red-600 hover:font-medium">Delete</td>
				</tr>
				<tr class="flex flex-col mb-2 flex-no wrap sm:table-row sm:mb-0">
					<td class="p-3 border border-grey-light hover:bg-gray-100">Michael Jackson</td>
					<td class="p-3 truncate border border-grey-light hover:bg-gray-100">m_jackson@mail.com</td>
					<td class="p-3 text-red-400 border cursor-pointer border-grey-light hover:bg-gray-100 hover:text-red-600 hover:font-medium">Delete</td>
				</tr>
                <tr class="flex flex-col mb-2 flex-no wrap sm:table-row sm:mb-0">
                    <td class="p-3 border border-grey-light hover:bg-gray-100">Julia</td>
                    <td class="p-3 truncate border border-grey-light hover:bg-gray-100">julia@mail.com</td>
                    <td class="p-3 text-red-400 border cursor-pointer border-grey-light hover:bg-gray-100 hover:text-red-600 hover:font-medium">Delete</td>
                </tr>
                <tr class="flex flex-col mb-2 flex-no wrap sm:table-row sm:mb-0">
                  <td class="p-3 border border-grey-light hover:bg-gray-100">Martin Madrazo</td>
                  <td class="p-3 truncate border border-grey-light hover:bg-gray-100">martin.madrazo@mail.com</td>
                  <td class="p-3 text-red-400 border cursor-pointer border-grey-light hover:bg-gray-100 hover:text-red-600 hover:font-medium">Delete</td>
                </tr>
			</tbody>
		</table>
	</div>



    <!-- </div> -->
</template>



<style scoped>
body {
    height: 100%;
  }

  @media (min-width: 640px) {
    table {
      display: inline-table !important;
    }

    thead tr:not(:first-child) {
      display: none;
    }
  }

  td:not(:last-child) {
    border-bottom: 0;
  }

  th:not(:last-child) {
    border-bottom: 2px solid rgba(0, 0, 0, .1);
  }
</style>
