<template>
  <div class="flex flex-col justify-center items-center min-h-screen text-gray-800 bg-gray-100">
    <h1 class="text-6xl font-bold mb-4">404</h1>
    <p class="text-2xl mb-8">Page not found!</p>
    <p class="mb-8">We can't find the page you're looking for.</p>
    <router-link
      to="/"
      class="inline-block px-6 py-3 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
    >
      Go to Home
    </router-link>
  </div>
</template>

<script setup>
</script>