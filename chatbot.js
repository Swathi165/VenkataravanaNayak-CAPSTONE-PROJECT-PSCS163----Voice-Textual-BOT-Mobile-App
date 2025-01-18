const chatInput = document.getElementById('chat-input');
const sendBtn = document.getElementById('send-btn');
const chatbotMessages = document.getElementById('chatbot-messages');
const voiceBtn = document.getElementById('voice-btn');

const apiUrl = 'chatbot/chatbot.php'; // Backend PHP URL
let currentVoiceIndex = 0; // Tracks the current voice index
let voices = []; // Will store available voices

// Populate voices after page load
window.speechSynthesis.onvoiceschanged = () => {
    voices = speechSynthesis.getVoices();
};

// Function to add messages to the chat window
function addMessage(content, isUser = false) {
    const message = document.createElement('div');
    const timestamp = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    message.className = isUser ? 'user-message' : 'bot-message';
    message.innerHTML = `<span>${content}</span><br><small class="timestamp">${timestamp}</small>`;
    chatbotMessages.appendChild(message);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

// Function to show typing indicator
function showTypingIndicator() {
    const typingIndicator = document.createElement('div');
    typingIndicator.id = 'typing-indicator';
    typingIndicator.className = 'bot-message';
    typingIndicator.innerHTML = 'Typing...';
    chatbotMessages.appendChild(typingIndicator);
    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

// Function to remove typing indicator
function removeTypingIndicator() {
    const typingIndicator = document.getElementById('typing-indicator');
    if (typingIndicator) {
        chatbotMessages.removeChild(typingIndicator);
    }
}

// Function to convert text to speech
function speak(text) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.lang = 'en-US';
    utterance.voice = voices[currentVoiceIndex] || null;
    speechSynthesis.speak(utterance);
}

// Stop speaking
const stopSpeakingBtn = document.getElementById('stop-speaking-btn');

// Stop speaking
function stopSpeaking() {
    if (speechSynthesis.speaking) {
        speechSynthesis.cancel();
        addMessage('Speaking stopped.');
    }
}

// Handle stop speaking button click
stopSpeakingBtn.addEventListener('click', stopSpeaking);

// Change the voice
function changeVoice() {
    if (voices.length === 0) {
        addMessage('No voices available. Please try again later.');
        return;
    }
    currentVoiceIndex = (currentVoiceIndex + 1) % voices.length; // Cycle through available voices
    addMessage(`Voice changed to: ${voices[currentVoiceIndex].name}`);
    speak('Voice changed successfully.');
}

// Clear the chat
function clearChat() {
    chatbotMessages.innerHTML = '';
    addMessage('Chat cleared. Starting fresh...');
}

// Process user input
function processInput(input) {
    addMessage(input, true);

    // Normalize the input
    const sanitizedInput = input.replace(/\s+/g, ' ').trim(); // Remove extra spaces
    const lowerCaseInput = sanitizedInput.toLowerCase();

    // Predefined responses
    const predefinedResponses = {
        'how are you': "I am doing well, what kind of help are you looking for?",
        'i want to know the status of my order': "Sure, please let me know your order ID or mobile number.",
        'great thanks': "I am always happy to help you 😁",
        'what is your name': "My name is Apparel."
    };

    if (predefinedResponses[lowerCaseInput]) {
        const response = predefinedResponses[lowerCaseInput];
        addMessage(response);
        speak(response);
        return;
    }

    // Handle greetings
    const greetings = ['hi', 'hello', 'hey', 'greetings', 'howdy'];
    if (greetings.includes(lowerCaseInput)) {
        const greetingResponse = "Hello! How can I assist you today?";
        addMessage(greetingResponse);
        speak(greetingResponse);
        return;
    }

    // Special commands handling
    if (lowerCaseInput === 'clear chat' || lowerCaseInput === 'clear') {
        clearChat();
        return;
    }

    if (lowerCaseInput === 'stop') {
        stopSpeaking();
        return;
    }

    if (lowerCaseInput === 'change the voice' || lowerCaseInput === 'voice toggle') {
        changeVoice();
        return;
    }

    // Handle unrecognized input
    const errorMessage = "Please login or signup for the order details or any other services.";
    addMessage(errorMessage);
    speak(errorMessage);
}

// Handle send button click
sendBtn.addEventListener('click', () => {
    const inputValue = chatInput.value.trim();
    if (inputValue !== '') {
        processInput(inputValue);
        chatInput.value = '';
    }
});

// Handle voice input button click
voiceBtn.addEventListener('click', () => {
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
    recognition.lang = 'en-US';
    recognition.start();

    recognition.onresult = (event) => {
        const spokenInput = event.results[0][0].transcript;
        chatInput.value = spokenInput;
        processInput(spokenInput);
    };

    recognition.onerror = () => {
        addMessage('Voice recognition error. Please try again.');
    };
});
