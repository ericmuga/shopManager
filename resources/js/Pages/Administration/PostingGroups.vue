<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'


import { ref, onMounted, computed } from 'vue';
import gsap from 'gsap';

const itemPostingGroupCard = ref(null);
const userCard = ref(null);
const postingCard = ref(null);
const administrationCard = ref(null);

const isMobile = computed(() => {
  return window.innerWidth <= 640; // Adjust the breakpoint as needed
});

const navigateTo = (component) => {
  router.visit(route(component));
};

onMounted(() => {
  // Use GSAP to fade in the cards on component mount
  gsap.from([itemPostingGroupCard.value, userCard.value, postingCard.value], {
    opacity: 0,
    duration: 1,
    stagger: 0.2, // Stagger the animations for a more dynamic effect
  });
});

// Update the layout on window resize
window.addEventListener('resize', () => {
  isMobile.value = window.innerWidth <= 640; // Adjust the breakpoint as needed
});
</script>

<template>
    <Head title="Posting Groups" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template> -->


  <div class="mt-2 dashboard">
    <!-- Stats Bar at the Top -->
    <div class="p-4 text-white bg-blue-500 stats-bar">
      <h2 class="text-2xl font-semibold">Posting Groups</h2>
      <!-- Add any other stats or information you want to display here -->
    </div>

    <!-- Cards in the Middle -->
     <div :class="{'flex-col': isMobile, 'flex-row': !isMobile}" class="items-center mt-8">
      <!-- Customer Card -->
      <div ref="itemPostingGroupCard" class="mb-4 card" @click="router.get(route('itemPostingGroups.index'))">
        <h3 class="mb-2 text-xl font-semibold">Items Posting Groups</h3>
        <!-- Add content for the Customers card -->
      </div>

      <div ref="taxPostingGroupCard" class="mb-4 card" @click="router.get(route('taxPostingGroups.index'))">
        <h3 class="mb-2 text-xl font-semibold">Tax Posting Groups</h3>
        <!-- Add content for the Customers card -->
      </div>

      <div ref="busPostingGroupCard" class="mb-4 card" @click="router.get(route('busPostingGroups.index'))">
        <h3 class="mb-2 text-xl font-semibold">Business Posting Groups</h3>
        <!-- Add content for the Customers card -->
      </div>


    </div>


  </div>
</AuthenticatedLayout>
</template>

<!-- </template> -->

<style scoped>
/* Add any additional styling specific to this component */
.dashboard {
  max-width: 1200px;
  margin: 0 auto;
}

.stats-bar {
  /* Customize styles for the stats bar */
}

.card {
  /* Customize styles for the cards */
  width: 100%; /* Make all cards have the same width */
  border: 1px solid #ddd;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease-in-out;
}

.card:hover {
  cursor: pointer;
}
</style>
