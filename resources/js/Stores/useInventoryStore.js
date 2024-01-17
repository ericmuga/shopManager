// inventoryStore.js
import { defineStore } from 'pinia';
import axios from 'axios';

export const useInventoryStore = defineStore('inventory', {
  state: () => ({
    locations: [],
    items: [],
    isFetching: false, // Add this property
  }),

  actions: {
    async fetchLocations() {
      this.isFetching = true; // Set isFetching to true before the request
      try {
        const response = await axios.get('cachedLocations'); // Laravel endpoint
        this.locations = response.data.data;
      } catch (error) {
        console.error('Error fetching locations:', error);
      } finally {
        this.isFetching = false; // Set isFetching to false after the request, whether successful or not
      }
    },

    async fetchItems() {
      this.isFetching = true;
      try {
        const response = await axios.get('cachedItems'); // Laravel endpoint
        this.items = response.data.data;
      } catch (error) {
        console.error('Error fetching items:', error);
      } finally {
        this.isFetching = false;
      }
    },
  },
});
