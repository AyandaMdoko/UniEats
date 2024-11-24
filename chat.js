const chatContainer = document.getElementById('chat-container');
const toggleArrow = document.getElementById('toggle-arrow');
const chatMessages = document.getElementById('chat-messages');
const messageInput = document.getElementById('message-input');
const senderType = document.getElementById('sender-type').value; // Fetch the actual sender's type
const notificationSound = new Audio('notification.mp3'); // Add your notification sound file here
const chatIcon = document.getElementById('chat-icon');
const alertIcon = document.getElementById('alert-icon'); // Add this line

// Connect to WebSocket server
const ws = new WebSocket('wss://unieats.co.za:8080/chat');

// Handle incoming messages from the WebSocket
ws.onmessage = function(event) {
    const data = JSON.parse(event.data);
    const messageTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Create message element
    const messageElement = document.createElement('div');

    // Determine message alignment based on sender type
    if (data.senderType === senderType) {
        messageElement.className = 'sent-message';
    } else {
        messageElement.className = 'received-message';
        notificationSound.play(); // Play notification sound for received messages
        alertIcon.style.display = 'block'; // Show the alert icon
    }

    messageElement.innerHTML = `<strong>${data.senderType}:</strong> ${data.message} <span class="timestamp">${messageTime}</span>`;

    // Append message to chat window
    chatMessages.appendChild(messageElement);

    // Scroll to the bottom to show the latest message
    chatMessages.scrollTop = chatMessages.scrollHeight;
};

// Toggle the chat container and rotate the arrow
function toggleChat() {
    chatContainer.classList.toggle('collapsed');

    if (chatContainer.classList.contains('collapsed')) {
        toggleArrow.innerHTML = '▼'; // Down arrow when collapsed
        chatIcon.style.display = 'flex'; // Show the chat icon
        alertIcon.style.display = 'none'; // Hide the alert icon when chat is open
    } else {
        toggleArrow.innerHTML = '▲'; // Up arrow when expanded
        chatIcon.style.display = 'none'; // Hide the chat icon
    }
}

// Handle message sending
function sendMessage(event) {
    event.preventDefault(); // Prevent form from reloading the page

    const message = messageInput.value.trim();
    const messageTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    if (message) {
        // Send message to WebSocket server
        const data = {
            senderType: senderType,
            message: message
        };
        ws.send(JSON.stringify(data));

        // Append the message to the sender's chat window
        const messageElement = document.createElement('div');
        messageElement.className = 'sent-message'; // Sent message is always aligned right
        messageElement.innerHTML = `<strong>${senderType}:</strong> ${message} <span class="timestamp">${messageTime}</span>`;

        // Append message to chat window
        chatMessages.appendChild(messageElement);

        // Scroll to the bottom to show the latest message
        chatMessages.scrollTop = chatMessages.scrollHeight;

        // Clear the input field
        messageInput.value = '';
    }
}

// Initially hide the chat container
chatContainer.classList.add('collapsed');
chatIcon.style.display = 'flex'; // Ensure chat icon is visible on load
alertIcon.style.display = 'none'; // Ensure alert icon is hidden on load
