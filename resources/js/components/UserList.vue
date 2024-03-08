<template>
    <div class="container mt-4">
        <h5>Click on a row to make a request user by ID</h5>
        <div class="row">
            <div class="col-md-3">
                <label for="perPage">Items per Page:</label>
                <select v-model="perPage" @change="fetchUsers">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="250">250</option>
                    <option value="1000">1000</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="offset">Offset:</label>
                <select v-model="offsetMode" @change="fetchUsers">
                    <option value="none">None</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="250">250</option>
                    <option value="1000">1000</option>
                </select>
            </div>
            <div class="col-md-3">
                <button  @click="fetchUsers">Refresh</button>
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
                    <tr v-for="user in userList" :key="user.id" @click="openModal(user.id)">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.phone }}</td>
                        <td>{{ user.email }}</td>
                        <td><img height="70" v-bind:src="user.photo" /></td>
                        <td>{{ user.position_id }}</td>
                        <td><span :title="user.created_at">{{ timeAgo(user.created_at) }}</span></td>
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
    <UserModalWindow :showModal="showModal" :user="selectedUser" @close="showModal = false" />
</template>

<script>
import UserModalWindow from './UserModalWindow.vue';
import moment from 'moment'

export default {
    name: 'UsersTable',
    components: {
        UserModalWindow
    },
    data() {
        return {
            showModal: false,
            selectedUser: null,

            userList: [],
            currentPage: 1,
            perPage: 10,
            totalPages: 0,
            offsetMode: 'none',
        };
    },
    mounted() {
        this.fetchUsers();
    },
    methods: {
        timeAgo(datetime) {
            return moment(datetime).fromNow();
        },
        openModal(userId) {
            fetch(`/api/v1/users/${userId}`)
                .then(response => response.json())
                .then(data => {
                    this.selectedUser = data;
                    this.showModal = true;
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                });
        },
        fetchUsers() {
            fetch(`/api/v1/users?${this.getQueryParams()}`)
                .then(response => response.json())
                .then(data => {
                    this.userList = data.data;
                    this.totalPages = data.last_page;
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                });
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
<style scoped>
table tr:hover td {
    background-color: #f5f5f5; /* Your color here */
}

table {
    width: 100%;
    border-collapse: collapse;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
}

table th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
}

table tr:nth-child(even) td{background-color: #F2F2F2;}
</style>
