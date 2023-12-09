<template>
  <div>
    <label :for="id" class="block text-sm font-medium leading-6 text-gray-900 text-left">{{ label }}</label>
    <div class="mt-2">
      <textarea
        :id="id"
        :value="modelValue"
        @input="emit('update:modelValue', $event.target.value)"
        class="form-textarea block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
        :class="computedInputClass"
        :placeholder="placeholder"
        :rows="rows"
      ></textarea>
      <span v-if="error" class="block text-sm text-left text-red-500">{{ error }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  id: String,
  label: String,
  placeholder: String,
  modelValue: String,
  error: String,
  inputClass: [String, Array, Object],
  rows: {
    type: [Number, String],
    default: 3
  }
});

const emit = defineEmits(["update:modelValue"]);

const id = computed(
  () => props.id || "textarea-" + Math.floor(Math.random() * 100000000)
);
const computedInputClass = computed(() => {
  if (typeof props.inputClass === 'string') {
    return {
      [props.inputClass]: true
    }
  } else if (Array.isArray(props.inputClass)) {
    return props.inputClass.reduce((accum, val) => {
      accum[val] = true;
      return accum;
    }, {})
  }

  return props.inputClass;
})
</script>
