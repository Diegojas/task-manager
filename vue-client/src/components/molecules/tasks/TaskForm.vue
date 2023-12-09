<template>
  <form @submit.prevent="submitForm">
    <InputField
      v-model="task.title"
      label="Title"
      placeholder="Enter task title"
      class="mb-4"
      :error="validationErrors.title"
    />
    <TextAreaField
      label="Description"
      v-model="task.description"
      placeholder="Enter task description"
      class="mb-4"
      :error="validationErrors.description"
    />
    <SelectField
      label="Status"
      v-model="task.status"
      :options="statusOptions"
      placeholder="Select status"
      class="mb-6"
      :error="validationErrors.status"
    />
    <Button type="button" @click="cancel" buttonClass="mr-2 bg-gray-600">
      Cancel
    </Button>
    <Button type="submit">
      {{ isEditMode ? 'Update' : 'Create' }}
    </Button>
  </form>
</template>

<script setup>
import { reactive, ref, toRefs, watch } from 'vue';
import InputField from '@/components/atoms/InputField.vue';
import TextAreaField from '@/components/atoms/TextAreaField.vue';
import SelectField from '@/components/atoms/SelectField.vue';
import Button from '@/components/atoms/Button.vue';
import { validateField, validateForm } from '@/common/validation.service';

const props = defineProps({
  initialTask: {
    type: Object,
    default: {},
  },
});
const emit = defineEmits(['create-task', 'update-task', 'delete-task', 'cancel']);

const statusOptions = [
  { key: 'new', value: 'New' },
  { key: 'pending', value: 'Pending' },
  { key: 'in_progress', value: 'In Progress' },
  { key: 'completed', value: 'Completed' },
];
const { initialTask } = toRefs(props);
const task = reactive(Object.keys(initialTask.value).length ? { ...initialTask.value } : { title: '', description: '', status: 'pending' });

const isEditMode = ref(!!task.id);
const validationRules = {
  title: { required: true, minLength: 3 },
  description: { required: false },
  status: { required: true }
};

const validationErrors = reactive({
  title: null,
  description: null,
  status: null
});

const submitForm = () => {
  const isFormValid = validateForm(validationRules, validationErrors, task);
  if (isFormValid) {
    emit(isEditMode.value ? 'update-task' : 'create-task', task);
  }
};

for (const field in task) {
  watch(() => task[field], (newValue) => {
    validateField(validationRules, validationErrors, field, newValue);
  });
}

const cancel = () => {
  emit('cancel');
};
</script>