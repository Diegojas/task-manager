<template>
  <td class="px-6 py-4 whitespace-nowrap">
    <div class="text-sm text-gray-900">{{ task.title }}</div>
  </td>
  <td class="px-6 py-4">
    <div class="text-sm text-gray-500">{{ task.description }}</div>
  </td>
  <td class="px-6 py-4">
    <Badge :status="task.status" />
  </td>
  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <button @click="edit" class="text-indigo-600 hover:text-indigo-900 p-1">
      Edit
    </button>
    <button @click="remove" class="text-red-600 hover:text-red-900 p-1 ml-4">
      Delete
    </button>
  </td>
</template>

<script setup>
import { defineProps } from 'vue';
import Badge from '@/components/atoms/Badge.vue';

const emit = defineEmits(['edit-task', 'delete-task']);
const props = defineProps({
  task: {
    type: Object,
    required: true,
  },
});

const edit = () => {
  emit('edit-task', props.task);
};

const remove = () => {
  emit('delete-task', props.task);
};
</script>