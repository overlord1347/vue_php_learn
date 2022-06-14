<template>
  <h2 class="center">Онлайн Чат</h2>

  <div id="main-container" class="hidden">
    <div id="messages">

    </div>

    <div id="msg-container">
      <input type="text" id="msg" name="msg">
      <button type="button" id="send-msg">Send</button>
    </div>
  </div>

</template>

<script>

export default {

  name: 'App',
};
</script>

<style>
.center {
  text-align: center;
}

#messages {
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


</style>