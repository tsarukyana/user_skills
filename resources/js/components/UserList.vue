<!-- resources/js/components/UserList.vue -->
<template>
    <div class="max-w-4xl mx-auto p-6 bg-gray-100">
        <h1 class="text-2xl font-bold mb-4">User List</h1>
        <ul class="space-y-4">
            <li v-for="user in users" :key="user.id" class="bg-white p-4 rounded-lg shadow">
                <div class="text-lg font-semibold">{{ user.name }}</div>
                <div class="text-gray-500">{{ user.email }}</div>
                <div class="text-gray-600">Skills: {{ user.description }}</div>
            </li>
        </ul>
        <div v-if="nextPageUrl" class="text-center">
            <button
                @click="loadMoreUsers"
                class="bg-indigo-600 text-white px-2 py-1 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-4">
                Load More
            </button>
        </div>

        <h2 class="text-xl font-semibold mt-8 mb-4">Add New User</h2>
        <form @submit.prevent="addUser" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                <input type="text" v-model="newUser.name" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <span v-if="errors.name" class="text-red-600 text-sm">{{ errors.name[0] }}</span>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" v-model="newUser.email" class="mt-1 p-2 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email[0] }}</span>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add User</button>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            users: [],
            newUser: {
                name: '',
                email: ''
            },
            errors: {},
            nextPageUrl: null
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        fetchUsers(url = '/users') {
            axios.get(url)
                .then(response => {
                    this.users = response.data.data;
                    this.nextPageUrl = response.data.next_page_url;
                });
        },
        loadMoreUsers() {
            if (this.nextPageUrl) {
                axios.get(this.nextPageUrl)
                    .then(response => {
                        this.users = this.users.concat(response.data.data);
                        this.nextPageUrl = response.data.next_page_url;
                    });
            }
        },
        addUser() {
            if (!this.validateName(this.newUser.name)) {
                this.errors.name = ['Name must be either only letters or only numbers and no more than 12 characters.'];
                return;
            }

            axios.post('/users', this.newUser)
                .then(response => {
                    this.users.push(response.data);
                    this.newUser.name = '';
                    this.newUser.email = '';
                    this.errors = {};
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
        validateName(name) {
            const isNumeric = /^\d{1,12}$/.test(name);
            const isAlpha = /^[a-zA-Z]{1,12}$/.test(name);
            return isNumeric || isAlpha;
        }
    }
};
</script>
