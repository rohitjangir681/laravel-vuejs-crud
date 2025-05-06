<script setup>
import BaseHeading from '@/components/BaseHeading.vue';
import { RouterLink } from 'vue-router';
import EmployeeList from '@/views/employee/EmployeeList.vue';
</script>

<template>
    <div class="flex justify-between w-full">
        <BaseHeading class="inline-flex justify-center items-center">Employee Page</BaseHeading>
        <RouterLink to="/employee/create"
            class="inline-flex items-center px-3 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800">Create Employee
        </RouterLink> 
    </div>
    
    <EmployeeList />

</template>