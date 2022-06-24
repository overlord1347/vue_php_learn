<template>

  <h2 class="center">Онлайн Чат</h2>

  <div id="main-container" class="hidden">
    <div id="messages">

      <p class="text-messages" v-for="message in messagesList"> {{message.messageText}}</p>
    </div>

    <div id="msg-container">
      <input type="text" id="msg" name="msg" v-model="messageText">
      <button type="button" id="send-msg" @click="sendMessage">Send</button>
    </div>
  </div>

</template>


<script>


import axios from 'axios'

window.onload = function () {
  let block = document.getElementById("messages");
  block.scrollTop = block.scrollHeight;
};


export default {
  name: 'App',

  data() {
    return {
      messagesList: [],
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
  },

  mounted() {

    // получаем последние сообщения
    axios.get("message/get/all").then(response => (this.messagesList = response.data))

    // открываем соеденение для получения новых сообщений
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
    }
  }
};
</script>