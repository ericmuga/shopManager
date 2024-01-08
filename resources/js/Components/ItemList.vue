<template>
  <div >
    <!-- Search input -->
    <div class="p-3 mb-4 text-center">
      <input v-model="searchTerm" type="text" placeholder="Search" class="p-2 border border-gray-300 rounded" />
    </div>
   <div class="scrollable-container">

    <!-- Display filtered items with scrolling -->
    <div v-for="(item, index) in filteredItems" :key="index" class="card">
      <!-- Display item details -->
      <div class="card-content">
        <div class="flex flex-row justify-between">
           <h3 class="text-lg font-bold">{{ item.code }}</h3>
         <HeartIcon class="w-5 h-5" v-if="item.selected" />
        </div>

        <p>{{ item.description }}</p>
      </div>

      <!-- Button to add item to cart -->
      <Button @click="addToCart(item)" class="w-full p-2 text-white bg-blue-500" :severity="item.selected?'success':'primary'">
        <span v-if="!item.selected">Add to Cart</span>
        <span v-else >Added to Cart</span>
      </Button>

      <!-- Heart icon to mark as selected and show quantity -->
      <div class="flex items-center justify-between mt-2">
        <button @click="toggleSelection(item)" class="text-red-500">

        </button>
        <span v-if="item.selected" class="p-1 text-xs bg-gray-200 rounded">{{ item.quantityInCart }}</span>
      </div>
    </div>
  </div>

   </div>
</template>

<script setup>
import { ref, defineProps, defineEmits,watch } from 'vue';
import { debounce } from 'lodash';
import { HeartIcon } from '@heroicons/vue/16/solid';

// Props
const props = defineProps(['items']);

// State
const searchTerm = ref('');
const filteredItems = ref(props.items);

// Emitting events
const emit = defineEmits();

// Method to add item to cart and emit an event
const addToCart = (item) => {
  item.selected = !item.selected; // Toggle selected state

  if (item.selected) {
    item.quantityInCart = (item.quantityInCart || 0) + 1; // Increment quantity
  } else {
    item.quantityInCart = 0; // Reset quantity
  }

  emit('addToCart', item); // Emit event with the clicked item
};

// Method to filter items by description
const filterItems = () => {
  filteredItems.value = props.items.filter(item => item.description.toLowerCase().includes(searchTerm.value.toLowerCase()));
};

// Method to toggle selection state
const toggleSelection = (item) => {
  item.selected = true; // Always mark as selected
  item.quantityInCart = (item.quantityInCart || 0) + 1; // Increment quantity
};

// Watcher for the search term with debounce
const watchSearchTerm = debounce(() => {
  filterItems();
}, 200);

// Watch for changes in search term
watch(searchTerm, watchSearchTerm);
</script>

<style scoped>
.scrollable-container {
  max-height: 400px; /* Adjust the height as needed */
  overflow-y: auto;
}

.card {
  border: 1px solid #ccc;
  border-radius: 8px;
  margin: 10px;
  padding: 10px;
}

.card-content {
  margin-bottom: 10px;
}
</style>
