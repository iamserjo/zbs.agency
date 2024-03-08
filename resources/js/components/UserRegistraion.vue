<template>
    <div>
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" v-model="name">
        </div>
        <div class="form-group">
            <label>Phone:</label>
            <input type="text" class="form-control" v-model="phone" placeholder="+380...">
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" v-model="email">
        </div>
        <div class="form-group">
            <label>Position:</label>
            <select class="form-control" v-model="position">
                <option v-for="position in positions" :value="position.id">{{ position.name }}</option>
            </select>
        </div>
        <div class="form-group">
            <label>Photo:</label>
            <input type="file" class="form-control" @change="photo = $event.target.files[0]">
        </div>
        <div class="form-group">
            <label>Token:</label>
            <input type="text" class="form-control" v-model="token">
            <button class="btn btn-secondary mt-2" @click="getToken">Get Token</button>
        </div>
        <button class="btn btn-primary" @click="handleSubmit">Submit</button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            name: '',
            phone: '',
            email: '',
            position: '',
            positions: [],
            photo: null,
            token: ''
        }
    },
    mounted() {
        // Fetch positions
        this.fetchPositions();
    },
    methods: {
        fetchPositions() {
            fetch('/api/v1/positions')
                .then(response => response.json())
                .then(data => {
                    this.positions = data.positions;
                })
                .catch(error => {
                    console.error('Error fetching positions:', error);
                });
        },
        getToken() {
            fetch('/api/v1/token')
                .then(response => response.json())
                .then(data => {
                    this.token = data.token;
                })
                .catch(error => {
                    console.error('Error fetching token:', error);
                });
        },
        handleSubmit() {
            // Prepare data
            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('phone', this.phone);
            formData.append('email', this.email);
            formData.append('position_id', this.position);
            formData.append('photo', this.photo);

            // Send data to the backend
            fetch('/api/v1/users', {
                method: 'POST',
                headers: {
                    'Authorization': this.token
                },
                body: formData
            })
                .then(response => {
                    if (response.ok) {
                        return response.json().then(data => {
                            alert(`User registered successfully with ID: ${data.user.id}`);
                        });
                    } else {
                        return response.json().then(error => {
                            alert(JSON.stringify(error));
                        });
                    }
                })
                .catch(error => {
                    console.error('Error registering user:', error);
                    alert('Error registering user. Please try again later.');
                });
        }
    }
};
</script>
