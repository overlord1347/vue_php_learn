<template>
  <button class="show-modal-button" @click="showModal">Войти</button>
  <button class="show-modal-button" @click="showModalTwo">Регистрация</button>

<!--  окно для входа на сайт-->
  <modal-window ref="modal">
    <template v-slot:title>
      <h3 class="modal-title">Войти на сайт</h3>
    </template>
    <template v-slot:body>

      <form action="" class="ui-form">
        <div class="form-row">
          <input type="text" id="email" autocomplete="off" v-model="email"><label for="email">Email</label>
        </div>
        <div class="form-row">
          <input type="password" id="password" autocomplete="off" v-model="password"><label for="password">Пароль</label>
        </div>
        <p><input value="Войти" @click="onLogin" ></p>
      </form>
    </template>
  </modal-window>

<!--  окно для регистрации -->
  <modal-window ref="modalTwo">
    <template v-slot:title>
      <h3 class="modal-title">Регистрация</h3>
    </template>
    <template v-slot:body>

      <form action="" class="ui-form">
        <div class="form-row">
          <input
              type="text"
              id="emailreg"
              required
              v-model="email">
          <label for="emailreg">Email</label>
        </div>
        <div class="form-row">
          <input type="text" id="fullname" required autocomplete="off" v-model="fullname"><label
            for="fullname">Имя</label>
        </div>
        <div class="form-row">
          <input type="password" id="passwordreg" required autocomplete="off" v-model="password"><label
            for="passwordreg">Пароль</label>
        </div>
        <p><input value="Зарегистрироваться" @click="sendDataFunction"></p>
      </form>
    </template>
  </modal-window>

</template>
<script>

import ModalWindow from './modal-window.vue'
import axios from 'axios'
import {useToast} from "vue-toastification";


export default {

  name: 'App',
  components: {
    ModalWindow
  },


  data() {
    return {
      signin: true,
      email: '',
      password: '',
      fullname: '',
    };
  },

  methods: {
    showModal: function () {
      this.$refs.modal.show = true
    },

    showModalTwo: function () {

      this.$refs.modalTwo.show = true
    },

    sendDataFunction: function () {

      const formData = new FormData();

      formData.append('email', this.$data.email)
      formData.append('plainPassword', this.$data.password)
      formData.append('name', this.$data.fullname)

      axios.post("auth/register",
          formData,
          {
            headers: {
              "Content-type": "application/json",
            }
          }).then(function (response) {

        const toast = useToast();

        toast.success('Вы успешно вошли, страница сейчас перезагрузится')

        setTimeout(() => window.location.reload(),  2000)
      }).catch(function (error) {

        const toast = useToast();

        toast. error(error.response.data);
      })

    },

    onLogin: function () {
      const formData = new FormData();

      formData.append('email', this.$data.email)
      formData.append('password', this.$data.password)
      formData.append('_csrf_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))

      axios.post("login",
          formData,
          {
            headers: {
              "Content-type": "application/json",
            }
          }).then(function (response) {

        const toast = useToast();

        toast.success('Вы успешно вошли, страница сейчас перезагрузится')

        // setTimeout(() => window.location.reload(),  2000)
      }).catch(function (error) {

        const toast = useToast();
        toast. error(error.message);
      })
    }
  },
}
</script>