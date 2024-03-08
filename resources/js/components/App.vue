<template>
    <div>
        <ul class="nav nav-tabs">
            <li class="nav-item" @click="switchTab('user-list')">
                <a class="nav-link" :class="{ active: activeTab === 'user-list' }" href="#">User List</a>
            </li>
            <li class="nav-item" @click="switchTab('user-registration')">
                <a class="nav-link" :class="{ active: activeTab === 'user-registration' }" href="#">User Registration</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane" :class="{ active: activeTab === 'user-list' }">
                <user-list></user-list>
            </div>
            <div class="tab-pane" :class="{ active: activeTab === 'user-registration' }">
                <user-registration></user-registration>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            activeTab: 'user-list' // Set initial active tab
        };
    },
    methods: {
        switchTab(tabName) {
            this.activeTab = tabName;
        }
    }
};
</script>
