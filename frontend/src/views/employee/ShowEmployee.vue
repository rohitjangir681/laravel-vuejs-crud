<script setup>
import BaseHeading from '@/components/BaseHeading.vue';
import { useRoute, RouterLink, useRouter } from 'vue-router';
import { onMounted, ref } from 'vue';
import axios from 'axios';

const route = useRoute();
const employee = ref(null);
const router = useRouter();

const employeeId = route.params.id;

onMounted(async () => {
    try {
        const response = await axios.get(`http://localhost:8000/api/employee/${employeeId}`);
        employee.value = response.data;
    } catch (error) {
        console.log('Fetching employee error: ', error);
    }

});

const deleteEmployee = async (id) => {
        try {
            const response = await axios.delete(`http://localhost:8000/api/employee/${id}`);
            
            if(response.status === 200){
                router.push('/employee');
            } 

        } catch(error) {
            console.log('Error employee delete: ', error);
            
        }
}


</script>

<template>
    <div class="max-w-6xl flex justify-between">
        <BaseHeading v-if="employee">{{ employee.name.toUpperCase() }} Profile Page</BaseHeading>
        <RouterLink to="/employee"
            class="inline-flex items-center px-3 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800">Back
        </RouterLink>
    </div>
    <div class="relative overflow-x-auto mt-6">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            </thead>
            <tbody v-if="employee">
                <tr>
                    <th class="py-3">Name:</th>
                    <td>{{ employee.name }}</td>
                </tr>
                <tr>
                    <th class="py-3">Email:</th>
                    <td>{{ employee.email }}</td>
                </tr>
                <tr>
                    <th class="py-3">Phone</th>
                    <td>{{ employee.phone }}</td>
                </tr>
                <tr>
                    <th class="py-3">Date of Birth</th>
                    <td>{{ employee.dob }}</td>
                </tr>
                <tr>
                    <th class="py-3">Gender</th>
                    <td>{{ employee.gender }}</td>
                </tr>
                <tr>
                    <th class="py-3">Skills</th>
                    <td>{{ JSON.parse(employee.skills).join(', ') }}</td>
                </tr>
                <tr>
                    <th class="py-3">Profile Picture</th>
                    <td v-if="employee.profile_picture">
                        <img :src="`http://localhost:8000/storage/${employee.profile_picture}`"
                            class="w-20 h-20 rounded-sm">
                    </td>
                    <td v-else>
                        No Image
                    </td>
                </tr>
                <tr>
                    <th class="py-3">Resume</th>
                    <td v-if="employee.resume">
                        <a :href="`http://localhost:8000/storage/${employee.resume}`"
                            :title="`Resume of ${employee.name}`" target="_blank">
                            <button
                                class="inline-flex items-center justify-center px-3 py-2 font-medium text-center text-white bg-blue-700 rounded-lg">Your
                                Resume</button>
                        </a>
                    </td>
                    <td v-else>
                        No Resume
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-end space-x-2">
            <RouterLink :to="`/employee/edit/${employeeId}`"
                class="inline-flex items-center justify-center px-3 py-2 font-medium text-center text-white bg-blue-700 rounded-lg">
                Edit
            </RouterLink>
            <button @click="deleteEmployee(employeeId)"
                class="inline-flex items-center justify-center px-3 py-2 font-medium text-center text-white bg-red-700 rounded-lg">
                DELETE
            </button>
        </div>


    </div>
</template>