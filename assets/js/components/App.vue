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

window.onload = function() {
  let block = document.getElementById("messages");
  block.scrollTop = block.scrollHeight;
};

const hubUrl = 'http://localhost:8001/.well-known/mercure';
const eventSource = new EventSource(`${hubUrl}?topic=1e9`);
eventSource.onmessage = event => {

  const data = JSON.parse(event.data);
  console.log(data.headline)
  let messagesblock = document.getElementById("messages");
  const message = document.createElement('p');
  message.classList.add('text-messages')
  message.textContent = data.headline
  messagesblock.appendChild(message)

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

    }
  }
};
</script>

<style>
.center {
  text-align: center;
}

#messages {
  display: flex;
  flex-direction: column-reverse;
  background-color: white;
  height: 300px;
  width: 800px;
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
  overflow: auto;
  overflow-y: scroll;

}

#msg-container {
  padding: 20px;
}

#msg {
  width: 400px;
}

.text-messages {
  width: 100%;
  color: black;
}

</style>