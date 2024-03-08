<template>
    <div class="container mt-4">
        <h5>Click on a row to make a request user by ID</h5>
        <div class="row">
            <div class="col-md-6">
                <label for="perPage">Items per Page:</label>
                <select v-model="perPage" @change="fetchUsers">
                    <option v-for="option in perPageOptions" :value="option" :key="option">{{ option }}</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="offset">Offset:</label>
                <select v-model="offsetMode" @change="fetchUsers">
                    <option value="none">None</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="250">250</option>
                    <option value="250">1000</option>
                </select>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Position ID</th>
                        <th>Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in userList" :key="user.id" @click="fetchUserDetails(user.id)">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.phone }}</td>
                        <td>{{ user.email }}</td>
                        <td><img height="70" v-bind:src="user.photo" /></td>
                        <td>{{ user.position_id }}</td>
                        <td>{{ user.created_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" v-if="offsetMode === 'none'">
            <div class="col-md-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                            <a class="page-link" href="#" @click.prevent="prevPage">Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" >{{ currentPage }}</a>
                        </li>
                        <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                            <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedUser: null,
            userList: [],
            currentPage: 1,
            perPage: 10,
            totalPages: 0,
            offsetMode: 'none',
            perPageOptions: [5, 10, 20, 50],
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        fetchUserDetails(userId) {
            fetch(`/api/v1/users/${userId}`)
                .then(response => response.json())
                .then(data => {
                    const userData = `Requested data: ID: ${data.id}, Name: ${data.name}, Phone: ${data.phone}, Email: ${data.email}, Position ID: ${data.position_id}, Created At: ${data.created_at}`;
                    alert(userData);
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                });
        },
        async fetchUsers() {
            const response = await fetch(`/api/v1/users?${this.getQueryParams()}`);
            const data = await response.json();
            this.userList = data.data;
            this.totalPages = data.last_page;
        },
        getQueryParams() {
            let params = `page=${this.currentPage}&count=${this.perPage}`;
            if (this.offsetMode !== 'none') {
                params += `&offset=${this.offsetMode}`;
            }
            return params;
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.fetchUsers();
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.fetchUsers();
            }
        }
    }
};
</script>
