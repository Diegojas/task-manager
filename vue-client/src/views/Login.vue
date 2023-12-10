<template>
  <div>
    <div>
      <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company" />
      <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Sign in to your account</h2>
      <p class="mt-10 text-center text-sm text-gray-500">
        Not a member?
        {{ ' ' }}
        <router-link
          :to="{ name: 'Register' }"
          class="font-medium text-indigo-600 hover:text-indigo-500"
        >
          Register for free
        </router-link>
      </p>
    </div>

    <div class="mt-10">
      <form class="mt-8 space-y-6" @submit.prevent="login">
        <Alert v-if="errorMsg">
          {{ errorMsg }}
          <span
            @click="errorMsg = ''"
            class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </span>
        </Alert>

        <div class="rounded-md shadow-sm space-y-4">
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
        </div>

        <div>
          <Button type="submit" class="w-full relative justify-center">
            Sign in
          </Button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
import { useUserStore } from '../stores/user'
import { useRouter } from "vue-router";
import { reactive, ref, watch } from "vue";
import InputField from "../components/atoms/InputField.vue";
import Alert from "../components/Alert.vue";
import Button from '@/components/atoms/Button.vue';
import { validateField, validateForm } from '@/common/validation.service';

const router = useRouter();
const store = useUserStore();

const user = reactive({
  email: "",
  password: "",
});
const validationRules = {
  email: { required: true, isEmail: true },
  password: { required: true }
};
const validationErrors = reactive({
  email: null,
  password: null,
});
let loading = ref(false);
let errorMsg = ref("");

function login() {
  const isFormValid = validateForm(validationRules, validationErrors, user);
  if (isFormValid) {
    loading.value = true;
    store
      .login(user)
      .then(() => {
        loading.value = false;
        router.push({
          name: "Dashboard",
        });
      })
      .catch((err) => {
        loading.value = false;
        errorMsg.value = err.response.message || err.message;
      });
  }
}

for (const field in user) {
  watch(() => user[field], (newValue) => {
    validateField(validationRules, validationErrors, field, newValue);
  });
}
</script>
  