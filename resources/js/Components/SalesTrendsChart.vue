<script setup>
import { onMounted, ref } from 'vue';
import Chart from 'chart.js/auto'; // Import Chart.js

const chartRef = ref(null);

onMounted(() => {
  const ctx = chartRef.value.getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Label 1', 'Label 2', 'Label 3'],
      datasets: [
        {
          label: 'Data Set 1',
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
          data: [65, 59, 80],
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
  });
});

</script>

<template>
  <div>
    <canvas ref="chartRef" width="400" height="400"></canvas>
  </div>
</template>
