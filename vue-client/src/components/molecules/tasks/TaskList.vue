<template>
  <div class="mt-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200 shadow sm:rounded-lg">
        <thead class="bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Title
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Description
            </th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Status
            </th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
              Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="task in paginatedTasks" :key="task.id">
            <TaskListItem :task="task" @edit-task="editTask" @delete-task="deleteTask" />
          </tr>
          <tr v-if="tasks.length === 0">
            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
              No tasks found.
            </td>
          </tr>
        </tbody>
        <tfoot v-if="tasks.length > perPage">
          <tr>
            <td colspan="4" class="px-6 py-3">
              <div class="flex justify-between items-center">
                <button
                  @click="goToPage(currentPage - 1)"
                  :disabled="currentPage === 1"
                  class="p-2"
                >
                  Previous
                </button>
                <span>Page {{ currentPage }} of {{ totalPages }}</span>
                <button
                  @click="goToPage(currentPage + 1)"
                  :disabled="currentPage >= totalPages"
                  class="p-2"
                >
                  Next
                </button>
              </div>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import TaskListItem from '@/components/molecules/tasks/TaskListItem.vue';

const emit = defineEmits(['edit-task', 'delete-task']);
const props = defineProps({
  tasks: {
    type: Array,
    default: () => [],
  },
});

const editTask = (task) => {
  emit('edit-task', task);
};

const deleteTask = (task) => {
  emit('delete-task', task);
};

const perPage = 25;
const currentPage = ref(1);

// Compute the paginated tasks based on the current page
const paginatedTasks = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return props.tasks.slice(start, start + perPage);
});

// Compute the total number of pages
const totalPages = computed(() => {
  return Math.ceil(props.tasks.length / perPage);
});

// Navigate to another page
const goToPage = (page) => {
  currentPage.value = page;
};
</script>