<template>
   <div>
    <label :for="id" class="block text-sm font-medium leading-6 text-gray-900 text-left">{{ label }}</label>
    <div class="mt-2">
      <select
        :value="modelValue"
        @change="emit('update:modelValue', $event.target.value)"
        :class="`block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ${selectClass}`"
      >
        <option v-if="placeholder" value="">{{ placeholder }}</option>
        <option
          v-for="(option, index) in options"
          :key="index"
          :value="option.key"
        >
          {{ option.value }}
        </option>
      </select>
      <span v-if="error" class="block text-sm text-left text-red-500">{{ error }}</span>
    </div>
  </div>
  
</template>

<script setup>
import { computed } from "@vue/reactivity";

const props = defineProps({
  modelValue: String,
  options: {
    type: Array,
    default: () => []
  },
  id: String,
  placeholder: String,
  label: String,
  error: String,
  selectClass: {
    type: [String, Array, Object],
    default: ''
  }
});
const emit = defineEmits(["update:modelValue"]);
const id = computed(
  () => props.id || "id-" + Math.floor(Math.random() * 100000000)
);
</script>