import { createApp } from "vue";
import App from "./js/components/App";
import ModalAuth from "./js/components/modal-auth";
import './styles/app.css';

const app = createApp(App)
const modalWindow = createApp(ModalAuth)

app.mount("#app")
modalWindow.mount("#modalWindow")

