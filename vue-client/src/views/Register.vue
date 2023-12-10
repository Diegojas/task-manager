<template>
  <div>
    <div>
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Register for free</h2>
      <p class="mt-10 text-center text-sm text-gray-500">
        Or
        {{ ' ' }}
        <router-link
          :to="{ name: 'Login' }"
          class="font-medium text-indigo-600 hover:text-indigo-500"
        >
          Login to your account
        </router-link>
      </p>
    </div>

    <div class="mt-10">
      <form class="mt-8 space-y-6" @submit.prevent="register">
        <Alert
          v-if="Object.keys(errors).length"
          class="flex-col items-stretch text-sm"
        >
          <div v-for="(field, i) of Object.keys(errors)" :key="i">
            <div v-for="(error, ind) of errors[field] || []" :key="ind">
              * {{ error }}
            </div>
          </div>
        </Alert>

        <div class="rounded-md shadow-sm space-y-4">
          <InputField
            name="name"
            v-model="user.name"
            label="Name"
            placeholder="Full Name"
            :error="validationErrors.name"
          />
          <InputField
            type="email"
            name="email"
            label="Email"
            v-model="user.email"
            placeholder="Email"
            :error="validationErrors.email"
          />
          <InputField
            type="password"
            name="password"
            label="Password"
            v-model="user.password"
            placeholder="Password"
            :error="validationErrors.password"
          />
          <InputField
            type="password"
            name="password_confirmation"
            label="Confirm password"
            v-model="user.password_confirmation"
            placeholder="Confirm Password"
            :error="validationErrors.password_confirmation"
          />
        </div>
        <div>
          <Button type="submit" class="w-full relative justify-center">
            Sign up
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { reactive, ref, watch } from "vue";
import { useUserStore } from '../stores/user'
import { useRouter } from "vue-router";
import Button from '@/components/atoms/Button.vue';
import InputField from "../components/atoms/InputField.vue";
import Alert from "../components/Alert.vue";
import { validateField, validateForm } from '@/common/validation.service';

const router = useRouter();
const store = useUserStore();
const user = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: ""
});
const validationRules = {
  name: { required: true, minLength: 3 },
  email: { required: true, isEmail: true },
  password: { required: true },
  password_confirmation: { required: true }
};
const validationErrors = reactive({
  name: null,
  email: null,
  password: null,
  password_confirmation: null
});
const loading = ref(false);
const errors = ref({});

function register(ev) {
  const isFormValid = validateForm(validationRules, validationErrors, user);

  if (isFormValid) {
    loading.value = true;
    store
      .register(user)
      .then(() => {
        loading.value = false;
        router.push({
          name: "Dashboard",
        });
      })
      .catch((error) => {
        loading.value = false;
        if (error.response.status === 422) {
          errors.value = error.response.data.errors;
        }
      });
  }
}

for (const field in user) {
  watch(() => user[field], (newValue) => {
    validateField(validationRules, validationErrors, field, newValue);
  });
}
</script>