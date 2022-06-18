<template>
  <h2 class="center">Онлайн Чат</h2>

  <div id="main-container" class="hidden">
    <div id="messages">

      <p class="text-messages">Mes1s</p>
      <p class="text-messages">Mes2s</p>
    </div>

    <div id="msg-container">
      <input type="text" id="msg" name="msg" v-model="messageText">
      <button type="button" id="send-msg" @click="sendMessage">Send</button>
    </div>
  </div>

</template>

<script>

import {useToast} from "vue-toastification";

window.onload = function () {
  let block = document.getElementById("messages");
  block.scrollTop = block.scrollHeight;
};

const url = new URL('http://127.0.0.1:3000/.well-known/mercure');
url.searchParams.append('topic', '/conversations/1');

const es = new EventSource(url);
es.onmessage = (msg) => {
  const data = JSON.parse(msg.data);
  console.log(data)
  let messagesblock = document.getElementById("messages");
  const message = document.createElement('p');

  // добавляем соообщение которое пришла к низу блока
  message.classList.add('text-messages')
  message.textContent = data.messageText
  messagesblock.prepend(message)
  // messagesblock.insertAdjacentHTML("afterbegin", message);


  // скроллим диалог вниз после получения сообщений
  let block = document.getElementById("messages");
  block.scrollTop = block.scrollHeight;
}

import axios from 'axios'


export default {


  name: 'App',

  data() {
    return {
      messageText: ""
    }
  },

  methods: {

    sendMessage: function () {
      const formData = new FormData();

      formData.append('messageText', this.$data.messageText)


      this.$data.messageText = ""
      axios.post("message/send",
          formData,
          {
            headers: {
              "Content-type": "application/json",
            }
          }).then(function (response) {
        console.log(response)
      }).catch(function (error) {
        console.log(error)
      })
      this.$data.messageText = ""

    }
  }
};
</script>