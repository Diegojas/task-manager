<template>
  <button
    :type="type"
    class="px-4 py-2 border rounded text-sm border-2 border-transparent text-white transition duration-300 ease-in-out"
    :class="[disabled ? 'opacity-50 cursor-not-allowed' : '', buttonClass ]"
    :disabled="disabled"
    @click="$emit('click')"
  >
    <slot></slot>
  </button>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  type: {
    type: String,
    default: 'button'
  },
  buttonClass: {
    type: String,
    default: 'bg-indigo-600 hover:bg-indigo-700'
  },
  disabled: {
    type: Boolean,
    default: false
  }
});
</script>