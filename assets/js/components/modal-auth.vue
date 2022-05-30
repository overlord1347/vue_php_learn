<template>
  <button class="show-modal-button" @click="showModal">Войти</button>
  <button class="show-modal-button" @click="showModalTwo">Регистрация</button>

  <modal-window ref="modal">
    <notifications position="bottom right" classes="my-custom-class" />

    <template v-slot:title>
      <h3 class="modal-title">Войти на сайт</h3>
    </template>
    <template v-slot:body>

      <form action="" class="ui-form">
        <div class="form-row">
          <input type="text" id="email" autocomplete="off"><label for="email">Email</label>
        </div>
        <div class="form-row">
          <input type="password" id="password" autocomplete="off"><label for="password">Пароль</label>
        </div>
        <p><input type="submit" value="Войти"></p>
      </form>
    </template>
  </modal-window>

  <modal-window ref="modalTwo">
    <template v-slot:title>
      <h3 class="modal-title">Войти на сайт</h3>
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
              "Content-type": "application/json"
            }
          }).then(function (response) {

            // this.$notification(
            //     'Good job!',
            //     'You clicked the button!',
            //     'success',
            //     async () => {
            //       console.log('Clicked notification')
            //     },
            //     'A minute ago'
            // )
        location.reload();
      }).catch(function (error) {
        console.log(error)
      })

    },
    openRegistration: function () {
      this.signin = false
    }
  },
}
</script>

<style>
/*textarea {*/
/*  color: #000000;*/
/*}*/

h3 {
  color: #000000;
}

* {
  box-sizing: border-box;
}

body {
  background: #e6f4fd;
  font-family: 'Roboto', sans-serif;
}

.ui-form {
  max-width: 350px;
  padding: 80px 30px 30px;
  margin: 50px auto 30px;
  background: white;
}

.ui-form h3 {
  position: relative;
  z-index: 5;
  margin: 0 0 60px;
  text-align: center;
  color: #4a90e2;
  font-size: 30px;
  font-weight: normal;
}

.ui-form h3:before {
  content: "";
  position: absolute;
  z-index: -1;
  left: 60px;
  top: -30px;
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #fee8e4;
}

.ui-form h3:after {
  content: "";
  position: absolute;
  z-index: -1;
  right: 50px;
  top: -40px;
  width: 0;
  height: 0;
  border-left: 55px solid transparent;
  border-right: 55px solid transparent;
  border-bottom: 90px solid #ffe3b5;
}

.form-row {
  position: relative;
  margin-bottom: 40px;
}

.form-row input {
  display: block;
  width: 100%;
  padding: 0 10px;
  line-height: 40px;
  font-family: 'Roboto', sans-serif;
  background: none;
  border-width: 0;
  border-bottom: 2px solid #4a90e2;
  transition: all 0.2s ease;
}

.form-row label {
  position: absolute;
  left: 13px;
  color: #9d959d;
  font-size: 20px;
  font-weight: 300;
  transform: translateY(-35px);
  transition: all 0.2s ease;
}

.form-row input:focus {
  outline: 0;
  border-color: #F77A52;
}

.form-row input:focus + label, .form-row input:valid + label {
  transform: translateY(-60px);
  margin-left: -14px;
  font-size: 14px;
  font-weight: 400;
  outline: 0;
  border-color: #F77A52;
  color: #F77A52;
}

input {
  width: 100%;
  padding: 0;
  line-height: 42px;
  background: #4a90e2;
  border-width: 0;
  color: #000000;
  font-size: 20px;
}


.ui-form p {
  margin: 0;
  padding-top: 10px;
}
</style>