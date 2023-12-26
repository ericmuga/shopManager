

<script>
import { Link } from '@inertiajs/vue3';

export default {
  props: {
    breadcrumbs: {
      type: Array,
      required: true,
    },
  },
  components: {
    Link,
  },
};
</script>
<!-- resources/js/Components/Breadcrumbs.vue -->

<template>
  <nav class="breadcrumbs">
    {{ $page.props.auth.user.email }}
    <ul>

      <li v-for="(crumb, index) in $page.props.breadcrumbs" :key="index">
        <Link :href="crumb.url">{{ crumb.title }}</Link>
      </li>
    </ul>
  </nav>
</template>
<style scoped>
/* Add your custom styles for breadcrumbs here */
</style>
