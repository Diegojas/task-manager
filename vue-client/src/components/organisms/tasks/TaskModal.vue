<template>
  <div v-if="show" class="fixed inset-0 bg-gray-500 bg-opacity-50 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3 text-center">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
          {{ task.id ? 'Edit Task' : 'New Task' }}
        </h3>
        <div class="mt-2">
          <TaskForm :initialTask="task" @create-task="handleSubmit" @update-task="handleSubmit" @cancel="handleCancel" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
import TaskForm from '@/components/molecules/tasks/TaskForm.vue';
import { useTaskStore } from '@/stores/tasks';
import { useNotificationStore } from '@/stores/notification';

const taskStore = useTaskStore();
const notificationStore = useNotificationStore();

const props = defineProps({
  show: Boolean,
  task: {
    type: Object,
    default: () => ({})
  }
});

const emits = defineEmits(['close']);

const handleSubmit = (taskData) => {
  if (taskData.id) {
    taskStore.updateTask(taskData)
      .then(() => {
        emits('close');
        notificationStore.notify({ message: 'Task updated successfully!' });
      })
      .catch(() => {
        notificationStore.notify({ message: 'Task update failed' });
      })
  } else {
    taskStore.createTask(taskData)
      .then(() => {
        emits('close');
        notificationStore.notify({ message: 'Task created successfully!' });
      })
      .catch(() => {
        notificationStore.notify({ message: 'Task creation failed' });
      })
  }
};

const handleCancel = () => {
  emits('close');
};
</script>