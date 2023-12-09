<template>
  <div>
    <TaskList :tasks="tasks" @edit-task="handleEdit" @delete-task="handleDelete" />
  </div>
</template>

<script setup>
import { useTaskStore } from '@/stores/tasks';
import { storeToRefs } from 'pinia';
import TaskList from '@/components/molecules/tasks/TaskList.vue';
import { useNotificationStore } from '@/stores/notification';

const taskStore = useTaskStore();
const emit = defineEmits(['edit-task']);
const { tasks } = storeToRefs(useTaskStore());
const notificationStore = useNotificationStore();

const handleEdit = (task) => {
  emit('edit-task', task);
};

const handleDelete = async (task) => {
  if (window.confirm(`Are you sure you want to delete the task "${task.title}"?`)) {
    try {
      await taskStore.deleteTask(task.id);
      notificationStore.notify({ message: 'Task deleted successfully!' });
    } catch (error) {
      notificationStore.notify({ message: 'Task deletion failed' });
    }
  }
}

taskStore.fetchTasks();
</script>