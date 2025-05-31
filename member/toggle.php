<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle').addEventListener('click', function () {
        document.body.classList.toggle('collapsed');
    });
</script>
<script>
  if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.interimResults = false;
    recognition.continuous = false;

    let isListening = false;

    const commandMap = {
      "dashboard": "index.php",
      "add money": "add.php",
      "send money": "send.php",
      "check balance": "check.php",
      "transaction history": "history.php",
      "support tickets": "ticket.php",
      "profile": "profile.php"
    };

    recognition.onstart = function () {
      console.log('Voice recognition started. Speak a command.');
    };

    recognition.onresult = function (event) {
      const command = event.results[0][0].transcript.toLowerCase().trim();
      console.log('Recognized command:', command);

      const searchInput = document.getElementById('search');
      searchInput.value = command;

      for (let key in commandMap) {
        if (command.includes(key)) {
          window.location.href = commandMap[key];
          return;
        }
      }

      setTimeout(() => {
        searchInput.value = '';
      }, 2000);
    };

    recognition.onend = function () {
      if (isListening) {
        recognition.start();
      }
    };

    document.getElementById('microphone-icon').addEventListener('click', function () {
      isListening = !isListening;
      if (isListening) {
        recognition.start();
      } else {
        recognition.stop();
      }
    });

  } else {
    console.log('Web Speech API not supported.');
  }
</script>

