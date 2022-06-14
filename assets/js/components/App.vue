<template>
  <h2 class="center">Онлайн Чат</h2>

  <div id="main-container" class="hidden">
    <div id="messages">
      <p class="text-messages">Mess</p>
      <p class="text-messages">Mes2s</p>
    </div>

    <div id="msg-container">
      <input type="text" id="msg" name="msg">
      <button type="button" id="send-msg">Send</button>
    </div>
  </div>

</template>

<script>
const hubUrl = 'http://localhost:8001/.well-known/mercure';
const eventSource = new EventSource(`${hubUrl}?topic=1e9`);
eventSource.onmessage = event => {
  console.log(event);
}

export default {

  name: 'App',
};
</script>

<style>
.center {
  text-align: center;
}

#messages {
  background-color: white;
  height: 300px;
  width: 800px;
  border: 1px solid #ccc;
  padding: 20px;
  text-align: left;
  overflow-y: scroll;
}

#msg-container {
  padding: 20px;
}

#msg {
  width: 400px;
}

.text-messages {
  margin-top: -50px;
  width: 100%;
  color: black;
}


</style>