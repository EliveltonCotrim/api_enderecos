// import './bootstrap';

import { createApp } from 'vue';
import 'bootstrap/dist/css/bootstrap.min.css'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import VueMask from 'vue-jquery-mask';

import Example from './components/Example.vue';
import Modal from './components/Modal.vue';
import InputContainer from './components/InputContainer.vue';
import Endereco from './components/Endereco.vue';
import Alert from './components/Alert.vue';
import Card from './components/Card.vue';
import NavBar from './components/NavBar.vue';

const app = createApp();

library.add(fas);

app.component('fa', FontAwesomeIcon);
app.use(Toast);
app.use(VueMask);

app.component('example', Example);
app.component('modal-component', Modal);
app.component('input-container-component', InputContainer);
app.component('endereco-component', Endereco);
app.component('alert-component', Alert);
app.component('card-component', Card);
app.component('nav-component', NavBar);


app.mount('#app');
