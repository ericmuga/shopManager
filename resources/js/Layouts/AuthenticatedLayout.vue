
<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Breadcrumbs from '@/Components/Breadcrumbs.vue';

import 	{ChevronDoubleRightIcon} from '@heroicons/vue/16/solid';
const sidebarOpen = ref(window.innerWidth >= 768);
const handleResize = () => {
  sidebarOpen.value = window.innerWidth >= 768;
};

onMounted(() => {
  window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize);
});
// const sidebarOpen = ref(true);
const subMenuOpen = ref({
  dashboard: false,
  sales: false,
  purchases: false,
  inventory:false,
  administration:false,
  // Add more submenu states as needed
});

const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;

  // Ensure that the sidebar is visible on small screens when the button is clicked
  if (window.innerWidth < 768) {
    const sidebar = document.querySelector('.w-64');
    sidebar.style.width = sidebarOpen.value ? '200px' : '0';
  }
};


const toggleSubMenu = (menuKey) => {
  subMenuOpen.value[menuKey] = !subMenuOpen.value[menuKey];
};
</script>
<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Collapsible Sidebar -->
    <div class="w-64 overflow-hidden bg-red-600" :class="{ 'hidden': !sidebarOpen }">
      <!-- Sidebar Header -->
      <div class="p-4">
        <button @click="toggleSidebar" class="text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
          </svg>
        </button>
      </div>

      <!-- Main Navigation -->
      <nav>
        <div @click="toggleSubMenu('dashboard')" class="px-4 py-2 cursor-pointer">
          <NavLink :href="route('dashboard')" :active="route().current('dashboard')"> Dashboard </NavLink>
          <span v-if="subMenuOpen['dashboard']" class="ml-2 text-white">&#9660;</span>
          <span v-else class="ml-2 text-white">&#9654;</span>
        </div>
        <div v-show="subMenuOpen['dashboard']">
          <!-- sss -->
        </div>

        <div @click="toggleSubMenu('sales')" class="px-4 py-2 cursor-pointer">
          <span class="text-black">Sales</span>
          <span v-if="subMenuOpen['sales']" class="ml-2 text-white">&#9660;</span>
          <span v-else class="ml-2 text-white">&#9654;</span>
        </div>
        <div v-show="subMenuOpen['sales']">
            <div class="py-2 pl-8 text-black" ><Link :href="route('sales.summary')" :active="route().current('sales.summary')">Summary </Link></div>
            <div class="py-2 pl-8 text-black" ><Link :href="route('salesOrder.index')" :active="route().current('salesOrder.index')">Quotes & Orders </Link></div>
            <div class="py-2 pl-8 text-black" ><Link :href="route('customers.index')" :active="route().current('customers.index')">Customers </Link></div>
          <!-- <div class="py-2 pl-8 cursor-pointer">Submenu 2</div> -->
        </div>

        <div @click="toggleSubMenu('purchases')" class="px-4 py-2 cursor-pointer">
          <span class="text-black">Purchases</span>
          <span v-if="subMenuOpen['purchases']" class="ml-2 text-white">&#9660;</span>
          <span v-else class="ml-2 text-white">&#9654;</span>
        </div>
        <div v-show="subMenuOpen['purchases']">
            <div class="py-2 pl-8 text-black cursor-pointer" ><Link :href="route('salesOrder.index')" :active="route().current('salesOrder.index')">Orders </Link></div>
            <div class="py-2 pl-8 text-black cursor-pointer" ><Link :href="route('customers.index')" :active="route().current('customers.index')">Vendors </Link></div>
        </div>



        <div @click="toggleSubMenu('inventory')" class="px-4 py-2 cursor-pointer">
          <span class="text-black">Inventory</span>
          <span v-if="subMenuOpen['inventory']" class="ml-2 text-white">&#9660;</span>
          <span v-else class="ml-2 text-white">&#9654;</span>
        </div>
        <div v-show="subMenuOpen['inventory']">
            <div class="py-2 pl-8 text-black" ><Link :href="route('items.index')" :active="route().current('items.index')">Items </Link></div>
            <div class="py-2 pl-8 text-black" ><Link :href="route('itemPostingGroups.index')" :active="route().current('customers.index')">Setups </Link></div>
        </div>


        <div @click="toggleSubMenu('administration')" class="px-4 py-2 cursor-pointer">
          <span class="text-black">Administration</span>
          <span v-if="subMenuOpen['administration']" class="ml-2 text-white">&#9660;</span>
          <span v-else class="ml-2 text-white">&#9654;</span>
        </div>
        <div v-show="subMenuOpen['administration']">
            <div class="py-2 pl-8 text-black" ><Link :href="route('administration.index')" :active="route().current('administration.index')" class="block px-2 py-1 rounded hover:bg-gray-600 ">Setups</Link></div>
            <div class="py-2 pl-8 text-black" ><Link :href="route('administration.posting-groups')" :active="route().current('administration.posting-groups')" class="block px-2 py-1 rounded hover:bg-gray-600 ">Posting Groups </Link></div>
            <div class="py-2 pl-8 text-black" ><Link :href="route('taxPostingSetups.index')" :active="route().current('taxPostingSetups.index')"  class="block px-2 py-1 rounded hover:bg-gray-600 ">Tax Posting Setup </Link></div>
            <div class="py-2 pl-8 text-black"><Link :href="route('users.index')" :active="route().current('users.index')" class="block px-2 py-1 rounded hover:bg-gray-600 ">Users</Link></div>
            <div class="py-2 pl-8 text-black"><Link :href="route('permissions.index')" :active="route().current('permissions.index')"  class="block px-2 py-1 rounded hover:bg-gray-600 ">Permissions</Link></div>
            <div class="py-2 pl-8 text-black"><Link :href="route('roles.index')" :active="route().current('roles.index')"  class="block px-2 py-1 rounded hover:bg-gray-600 ">Roles</Link></div>
            </div>





        <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
        <!-- Add more main navigation items as needed -->
      </nav>
    </div>

    <!-- Main Content Area -->
    <div class="flex flex-col flex-1 overflow-hidden">
      <!-- Top Navigation Bar -->
      <header class="flex flex-row justify-start gap-3 p-4 bg-red-400">

        <button @click="toggleSidebar" class="text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
          </svg>
        </button>
     <ul class="">
        <li v-for="(crumb, index) in $page.props.breadcrumbs" :key="index" class="flex items-center" style="list-style: none;">
            <ChevronDoubleRightIcon class="w-6 h-6 mr-1 text-blue-500" /><Link :href="crumb.url">

            {{ crumb.title }}
            </Link>
        </li>
        </ul>

      </header>

      <!-- Page Content -->
      <main class="flex-1 p-4 overflow-x-hidden overflow-y-auto bg-gray-100">
        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
          <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <slot name="header" />
          </div>
        </header>

        <!-- Page Content -->
        <slot />
      </main>
    </div>
  </div>
</template>



<style scoped>
/* Add styles for the sidebar, transition, etc. here */
/* Example styles: */
.w-64 {
  transition: width 0.3s ease-in-out;
}

.hidden {
  width: 0;
  overflow: hidden;
}

.cursor-pointer:hover {
  background-color: gray;
}

@media (max-width: 767px) {
  .w-64 {
    width: 0;
    overflow: hidden;
  }

  .hidden {
    width: 0;
    overflow: hidden;
  }

  /* Explicitly set display to block for the button */
  header button {
    display: block !important;
  }

  /* Adjust any other styles for small screens if needed */
}
</style>
