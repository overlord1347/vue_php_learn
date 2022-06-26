<template>

  <h2 class="center">Онлайн Чат</h2>

  <div id="main-container" class="hidden">
    <div id="messages">

      <template v-for="message in messagesList">
        <p class="text-messages" > {{ message.message_text }}</p>
        <h6 style="color: black; margin-bottom: 2px"> {{ message.name }}</h6>
      </template>
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
      messageText: "",
      page: 1
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

        let block = document.getElementById("messages");
        block.scrollTop = block.scrollHeight;

        console.log(response)
      }).catch(function (error) {
        console.log(error)
      })
      this.$data.messageText = ""

    },

    scrollMessage: function () {

      let messagesblock = document.getElementById("messages");

      var heiscroll = -200;
      var page = 2;
      messagesblock.onscroll = () => {

        // если скроллим вверх
        if (messagesblock.scrollTop < heiscroll) {
          axios.get('message/get/?page=' + page).then(response => (Array.prototype.push.apply(this.messagesList, response.data)))

          heiscroll -= 250;
          page++;
        }
      }

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
      let messagesblock = document.getElementById("messages");
      const message = document.createElement('p');

      // добавляем соообщение которое пришла к низу блока
      message.classList.add('text-messages')
      message.textContent = data.messageText
      messagesblock.prepend(message)
    }

    this.scrollMessage();
  }
};
</script>