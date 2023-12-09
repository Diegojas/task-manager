<template>
  <div
    v-if="show"
    class="fixed w-[300px] left-4 bottom-4 py-2 px-4 text-white animate-fade-in-down"
    :class="[type === 'success' ? 'bg-emerald-500' : 'bg-red-500']"
  >
    {{ message }}
  </div>
</template>

<script setup>
import { useNotificationStore } from "../stores/notification"
import { storeToRefs } from "pinia";

const { show, message, type } = storeToRefs(useNotificationStore());
</script>

<style></style>
