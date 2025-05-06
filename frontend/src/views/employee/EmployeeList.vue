<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink } from 'vue-router';


import axios from 'axios';

const employees = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('http://localhost:8000/api/employee');
        employees.value = response.data.employees;
    } catch (error) {
        console.log('Fetch Employee error ', error);

    }
});



</script>


<template>
    <div class="relative overflow-x-auto mt-6">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Phone
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date of Birth
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Gender
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Skills
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Profile Picture
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Resume
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>

                </tr>
            </thead>
            <tbody>
                <tr v-if="employees.length > 0" v-for="employee in employees"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ employee.name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ employee.email }}
                    </td>
                    <td class="px-6 py-4">
                        {{ employee.phone }}
                    </td>
                    <td class="px-6 py-4">
                        {{ employee.dob }}
                    </td>
                    <td class="px-6 py-4">
                        {{ employee.gender }}
                    </td>
                    <td class="px-6 py-4">
                        {{ JSON.parse(employee.skills).join(', ') }}
                    </td>
                    <td>
                        <img v-if="employee.profile_picture"
                            :src="`http://localhost:8000/storage/${employee.profile_picture}`"
                            class="w-20 h-20 rounded-sm">
                        <span v-else>No Image</span>
                    </td>
                    <td class="px-6 py-4">
                        <a v-if="employee.resume" :href="`http://localhost:8000/storage/${employee.resume}`" download
                            :title="`Resume of ${employee.name}`" target="_blank">
                            <button
                                class="inline-flex items-center justify-center px-3 py-2 font-medium text-center text-white bg-blue-700 rounded-lg">Your
                                Resume</button>
                        </a>
                        <span v-else>No Resume</span>
                    </td>
                    <td>
                        <RouterLink :to="`/employee/${employee.id}`"
                            class="inline-flex items-center justify-center px-3 py-2 font-medium text-center text-white bg-blue-500 rounded-lg">
                            Show</RouterLink>
                    </td>
                </tr>

                <tr v-else>
                    <td colspan="3" class="px-6 py-4">No employees available.</td>
                </tr>


            </tbody>
        </table>
    </div>

</template>