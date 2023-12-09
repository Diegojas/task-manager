<template>
  <span :class="badgeClass">
    <slot>{{ statusText }}</slot>
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  status: {
    type: String,
    required: true,
    validator(value) {
      return ['new', 'pending', 'in_progress', 'completed'].includes(value);
    }
  }
});

const badgeClass = computed(() => {
  const baseClasses = 'px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full';
  const statusClasses = {
    new: 'bg-blue-100 text-blue-800',
    pending: 'bg-yellow-100 text-yellow-800',
    in_progress: 'bg-purple-100 text-purple-800',
    completed: 'bg-green-100 text-green-800',
  };

  return `${baseClasses} ${statusClasses[props.status]}`;
});

const statusText = computed(() => {
  return props.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
});
</script>