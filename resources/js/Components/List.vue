

<script setup>
import { ref, onMounted } from 'vue';
// import { useInertia } from '@inertiajs/inertia-vue3';

// Data
const columns = ['id', 'name', 'email'];
const visibleColumns = ref(columns);
const searchQuery = ref('');
const list = ref([]);

// Fetch initial list
onMounted(() => {
  fetchData();
});

// Methods
const fetchData = async () => {
  // Fetch data from the backend using Inertia
  const { data } =await {'name':'Eric','email':'eric@email.com'};

//   await useInertia.get('/api/your-endpoint');
  list.value = data;
};

const updateVisibleColumns = () => {
  // Handle column visibility changes
};

const search = () => {
  // Fetch data based on search query
  fetchData();
};

const addItem = () => {
  // Logic to add an item
};

const editItem = (item) => {
  // Logic to edit an item
};

const deleteItem = (item) => {
  // Logic to delete an item
};

// Computed property for filtered list
const filteredList = computed(() => {
  return list.value.filter(item => {
    // Filter logic based on search query
    return item.name.toLowerCase().includes(searchQuery.value.toLowerCase());
  });
});

</script>


<template>
  <div>

    <!-- Column selection dropdown -->
    <label>Visible Columns:</label>
    <select v-model="visibleColumns" multiple @change="updateVisibleColumns">
      <option v-for="column in columns" :key="column" :value="column">{{ column }}</option>
    </select>

    <!-- Search input -->
    <label>Search:</label>
    <input v-model="searchQuery" @input="search" />

    <!-- Add button -->
    <button @click="addItem">Add Item</button>

    <!-- Table -->
    <table>
      <thead>
        <tr>
          <th v-for="column in visibleColumns" :key="column">
            <!-- Clickable headers with sorting -->
            <span @click="sort(column)">
              {{ column }}
              <span v-if="sortColumn === column">
                {{ sortDirection === 'asc' ? '↑' : '↓' }}
              </span>
            </span>
          </th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in filteredList" :key="item.id">
          <td v-for="column in visibleColumns" :key="column">
            {{ item[column] }}
          </td>
          <td>
            <button @click="editItem(item)">Edit</button>
            <button @click="deleteItem(item)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
