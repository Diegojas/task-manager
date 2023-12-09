<template>
  <PageComponent title="Dashboard">
    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 text-gray-700"
    >
      <DashboardCard class="order-1 lg:order-2" style="animation-delay: 0.1s">
        <template v-slot:title>Total Task</template>
        <div
          class="text-8xl pb-4 font-semibold flex-1 flex items-center justify-center"
        >
          {{ taskStats.totalTasks }}
        </div>
      </DashboardCard>

      <DashboardCard class="order-1 lg:order-2" style="animation-delay: 0.1s">
        <template v-slot:title>Total New Tasks</template>
        <div
          class="text-8xl pb-4 font-semibold flex-1 flex items-center justify-center"
        >
          {{ taskStats.newTasks }}
        </div>
      </DashboardCard>

      <DashboardCard class="order-1 lg:order-2" style="animation-delay: 0.1s">
        <template v-slot:title>Total Pending tasks</template>
        <div
          class="text-8xl pb-4 font-semibold flex-1 flex items-center justify-center"
        >
          {{ taskStats.pendingTasks }}
        </div>
      </DashboardCard>

      <DashboardCard class="order-1 lg:order-2" style="animation-delay: 0.1s">
        <template v-slot:title>Total Completed Tasks</template>
        <div
          class="text-8xl pb-4 font-semibold flex-1 flex items-center justify-center"
        >
          {{ taskStats.completedTasks }}
        </div>
      </DashboardCard>
      
    </div>
  </PageComponent>
</template>
<script setup>
import PageComponent from "@/components/PageComponent.vue";
import { useTaskStore } from "@/stores/tasks";
import DashboardCard from "@/components/atoms/DashboardCard.vue";
import { reactive } from "vue";

const taskStore = useTaskStore();

const taskStats = reactive({
  totalTasks: 0,
  pendingTasks: 0,
  newTasks: 0,
  completedTasks: 0
});

taskStore.fetchTaskStats()
  .then((resp) => {
    taskStats.totalTasks = resp.totalTasks;
    taskStats.pendingTasks = resp.pendingTasks;
    taskStats.newTasks = resp.newTasks;
    taskStats.completedTasks = resp.completedTasks;
  })


</script>