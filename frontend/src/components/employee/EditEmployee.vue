<script setup>
import BaseHeading from '@/components/BaseHeading.vue';
import { RouterLink, useRouter, useRoute } from 'vue-router';
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';

const form = reactive({
    name: '',
    email: '',
    phone: '',
    dob: '',
    gender: '',
    skills: [],
    profile_picture: null,
    resume: null
});

const router = useRouter();
const errors = ref({});
const route = useRoute();

const employeeId = route.params.id;


onMounted(async () => {
    try {
        const response = await axios.get(`http://localhost:8000/api/employee/${employeeId}`);
        form.name = response.data.name;
        form.email = response.data.email;
        form.phone = response.data.phone;
        form.dob = response.data.dob;
        form.gender = response.data.gender;
        form.skills = JSON.parse(response.data.skills) || [];

    } catch (error) {
        console.log('Fetching Employee error: ', error);

    }
});



const handleProfilePicture = (event) => {
    form.profile_picture = event.target.files[0]
}

const handleResume = (event) => {

    const file = event.target.files[0];

    const allowedResumeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    if (file && allowedResumeTypes.includes(file.type)) {
        form.resume = file;
    } else {
        alert('Please upload a valid resume file (PDF, DOC, DOCX).');
        form.resume = null;
    }
}

const formSubmit = async () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('email', form.email);
    formData.append('phone', form.phone);
    formData.append('dob', form.dob);
    formData.append('gender', form.gender);

    form.skills.forEach((skill, index) => {
        formData.append(`skills[${index}]`, skill);
    });

    if (form.profile_picture) {
        formData.append('profile_picture', form.profile_picture);
    }
    if (form.resume) {
        formData.append('resume', form.resume);
    }
    try {
        const response = await axios.post(`http://localhost:8000/api/employee/${employeeId}?_method=PUT`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            }
        });
        console.log(response.data);
        router.push(`/employee/${employeeId}`);
    } catch (error) {
        errors.value = error.response?.data?.errors || {};
        console.log('Form submit error ', error);

    }
}


</script>

<template>
    <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[-20rem]"
        aria-hidden="true">

    </div>
    <div class="mx-auto max-w-2xl text-center">
        <BaseHeading>Edit Employee</BaseHeading>
        <RouterLink :to="`/employee/${employeeId}`"
            class="inline-flex items-center px-3 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800">Back
        </RouterLink>
    </div>

    <form @submit.prevent="formSubmit" class="mx-auto mt-16 max-w-xl sm:mt-20">

        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
            <div>
                <label for="name" class="block text-sm/6 font-semibold text-gray-900">Name</label>
                <div class="mt-2.5">
                    <input v-model="form.name" type="text" name="name" id="name"
                        class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    <p v-if="errors.name" class="text-red-400">{{ errors.name[0] }}</p>
                </div>
            </div>
            <div>
                <label for="dob" class="block text-sm/6 font-semibold text-gray-900">Date of Birth</label>
                <div class="mt-2.5">
                    <input v-model="form.dob" type="date" name="dob" id="dob"
                        class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    <p v-if="errors.dob" class="text-red-400">{{ errors.dob[0] }}</p>
                </div>
            </div>
            <!-- Gender -->
            <div>
                <label class="block text-sm/6 font-semibold text-gray-900">Gender</label>
                <div class="mt-2.5 flex">
                    <div class="flex items-center mr-2">
                        <input v-model="form.gender" id="bordered-radio-1" type="radio" value="Male" name="gender"
                            class="text-blue-600">
                        <label for="bordered-radio-1" class="ms-2">Male</label>
                    </div>
                    <div class="flex items-center mr-2">
                        <input v-model="form.gender" id="bordered-radio-2" type="radio" value="Female" name="gender"
                            class="text-blue-600">
                        <label for="bordered-radio-2" class="ms-2">Female</label>
                    </div>
                    <div class="flex items-center">
                        <input v-model="form.gender" id="bordered-radio-3" type="radio" value="Other" name="gender"
                            class="text-blue-600">
                        <label for="bordered-radio-3" class="ms-2">Other</label>
                    </div>
                </div>
                <p v-if="errors.gender" class="text-red-400">{{ errors.gender[0] }}</p>
            </div>
            <!-- Skills -->
            <div class="sm:col-span-2">
                <label for="Skills" class="block text-sm/6 font-semibold text-gray-900">Skills</label>
                <div class="mt-2 space-y-1">
                    <label><input v-model="form.skills" type="checkbox" value="JavaScript" /> JavaScript</label><br />
                    <label><input v-model="form.skills" type="checkbox" value="PHP" /> PHP</label><br />
                    <label><input v-model="form.skills" type="checkbox" value="Laravel" /> Laravel</label><br />
                    <label><input v-model="form.skills" type="checkbox" value="Vue.js" /> Vue.js</label>
                </div>
            </div>

            <div class="sm:col-span-2">
                <label for="email" class="block text-sm/6 font-semibold text-gray-900">Email</label>
                <div class="mt-2.5">
                    <input v-model="form.email" type="email" name="email" id="email"
                        class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                    <p v-if="errors.email" class="text-red-400">{{ errors.email[0] }}</p>
                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="phone-number" class="block text-sm/6 font-semibold text-gray-900">Phone number</label>
                <div class="mt-2.5">
                    <input v-model="form.phone" type="text" name="phone" id="phone-number"
                        class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                        placeholder="123-456-7890">
                    <p v-if="errors.phone" class="text-red-400">{{ errors.phone[0] }}</p>

                </div>
            </div>
            <div class="sm:col-span-2">
                <label for="profile-picture" class="block text-sm/6 font-semibold text-gray-900">Profile Picture</label>
                <input @change="handleProfilePicture" type="file"
                    class="w-full text-slate-500 font-medium text-sm bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded mt-2"
                    id="profile-picture" />

            </div>

            <div class="sm:col-span-2">
                <label for="Resume" class="block text-sm/6 font-semibold text-gray-900">Upload Resume</label>
                <input @change="handleResume" type="file"
                    class="w-full text-slate-500 font-medium text-sm bg-gray-100 file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-gray-800 file:hover:bg-gray-700 file:text-white rounded mt-2"
                    id="Resume" />
                <p v-if="errors.resume" class="text-red-400">{{ errors.resume[0] }}</p>

            </div>
        </div>
        <div class="mt-10">
            <button type="submit"
                class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
        </div>
    </form>


</template>