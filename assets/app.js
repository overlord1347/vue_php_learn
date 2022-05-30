import { createApp } from "vue";
import App from "./js/components/App";
import ModalAuth from "./js/components/modal-auth";
import './styles/app.css';
import Notifications from 'vue3-vt-notifications'



const app = createApp(App)
const modalWindow = createApp(ModalAuth)
app.use(Notifications)

app.mount("#app")
modalWindow.mount("#modalWindow")

