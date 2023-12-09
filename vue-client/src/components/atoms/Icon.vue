<template>
  <component
    :is="iconType"
    v-bind="$attrs"
    class="inline-block"
  />
</template>

<script setup>
import { defineProps } from 'vue';
import * as HeroIcons from '@heroicons/vue/24/solid';

const props = defineProps({
  name: {
    type: String,
    required: true,
    validator: (value) => value in HeroIcons
  }
});

const iconType = HeroIcons[props.name];
</script>