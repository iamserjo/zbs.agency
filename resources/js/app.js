import { createApp} from 'vue'
import UserList from './components/UserList.vue';
import UserRegistration from './components/UserRegistraion.vue';
import App from './components/App.vue';
import UserModalWindow from "./components/UserModalWindow.vue";

const app = createApp(App);
app.component('user-list', UserList);
app.component('user-modal-window', UserModalWindow);
app.component('user-registration', UserRegistration);
app.mount('#app');
