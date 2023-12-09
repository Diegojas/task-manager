<template>
  <PageComponent title="Tasks">
    <Button @click="openModal">Add New Task</Button>
    <TaskListContainer @edit-task="handleEdit"/>
    <TaskModal
      :show="isModalOpen"
      :task="currentTask"
      @close="closeModal"
    />
  </PageComponent>
</template>
<script setup>
import PageComponent from "../components/PageComponent.vue";
import Button from '@/components/atoms/Button.vue';
import TaskListContainer from '@/components/organisms/tasks/TaskListContainer.vue';
import TaskModal from '@/components/organisms/tasks/TaskModal.vue';
import { ref } from 'vue';
import { useTaskStore } from '@/stores/tasks';

const isModalOpen = ref(false);
const currentTask = ref({});

const store = useTaskStore();

const openModal = () => {
  currentTask.value = {}; 
  isModalOpen.value = true;
};

const handleEdit = (task) => {
  currentTask.value = task;
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};
</script>