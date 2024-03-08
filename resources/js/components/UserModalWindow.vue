<template>
    <div v-if="showModal" class="modal">
        <div class="modal-content">
            <span @click="close" class="close">&times;</span>
            <p>Name: {{ user.name }}</p>
            <p>ID: {{ user.id }}</p>
            <p>Phone: {{ user.phone }}</p>
            <p>Email: {{ user.email }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "UserModalWindow",
    props: ["showModal", "user"],
    methods: {
        close() {
            this.$emit('close');
        }
    }
};
</script>

<style scoped>
.modal {
    display: flex;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    border-radius: 4px;
    max-width: 500px;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>
