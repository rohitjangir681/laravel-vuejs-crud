<script setup>
import { RouterLink } from 'vue-router';

</script>

<template>
  <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
      <div class="flex lg:flex-1">
        <a href="#" class="-m-1.5 p-1.5">
          <span class="sr-only">Your Company</span>
          <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
            alt="">
        </a>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
        <div class="relative">
          <div
            class="absolute top-full -left-8 z-10 mt-3 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg ring-1 ring-gray-900/5">
          </div>
        </div>
        <RouterLink to="/" class="text-sm/6 font-semibold text-gray-900">Home</RouterLink>
        <RouterLink to="/about" class="text-sm/6 font-semibold text-gray-900">About</RouterLink>
        <RouterLink to="/employee" class="text-sm/6 font-semibold text-gray-900">Employee</RouterLink>
      </div>
    </nav>
</template>