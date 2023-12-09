<template>
  <div>
    <label :for="id" class="block text-sm font-medium leading-6 text-gray-900 text-left">{{ label }}</label>
    <div class="mt-2">
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        @input="emit('update:modelValue', $event.target.value)"
        class="form-input block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
        :class="{ ...computedInputClass }"
        :placeholder="placeholder"
      />
      <span v-if="error" class="block text-sm text-left text-red-500">{{ error }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from "@vue/reactivity";

const props = defineProps({
  type: {
    type: String,
    default: "text",
  },
  id: String,
  label: String,
  placeholder: String,
  modelValue: String,
  inputClass: [String, Array, Object],
  error: String,
});

const emit = defineEmits(["update:modelValue"]);

const id = computed(
  () => props.id || "id-" + Math.floor(Math.random() * 100000000)
);
const computedInputClass = computed(() => {
  if (typeof props.inputClass === 'string') {
    return {
      [props.inputClass]: true
    }
  } else if (typeof props.inputClass === 'object' && props.inputClass.length !== undefined) {
    return props.inputClass.reduce((accum, val) => {
      accum[val] = true;
      return accum;
    }, {})
  }

  return props.inputClass;
})
</script>

<style></style>
