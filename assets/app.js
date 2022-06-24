import { createApp } from "vue";
import App from "./js/components/App";
import ModalAuth from "./js/components/modal-auth";
import './styles/app.css';
import './styles/modal-auth.css';

import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";


const modalWindow = createApp(ModalAuth)
const app = createApp(App)

app.use(Toast)

modalWindow.use(Toast)

app.mount("#app")
modalWindow.mount("#modalWindow")

