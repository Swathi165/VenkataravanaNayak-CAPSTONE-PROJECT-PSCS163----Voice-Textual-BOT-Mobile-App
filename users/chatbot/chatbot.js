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
        'i want to know the status of my order': "Sure, please let me know your Order ID or Mobile number.",
        'great thanks': "I am always happy to help you! 😁",
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

    // Extract a 10-digit phone number (allowing spaces in between)
    const phoneNumberMatch = sanitizedInput.match(/\b(\d\s*){10}\b/); // Match 10 digits with optional spaces
    const phoneNumber = phoneNumberMatch ? phoneNumberMatch[0].replace(/\s+/g, '') : null; // Remove spaces from phone number

    // Extract potential order ID (e.g., SGE_00001234, or numeric IDs embedded in sentences)
    const orderIdMatch = sanitizedInput.match(/sge_0000\d+/i) || sanitizedInput.match(/\b\d{1,6}\b/); // Match IDs in the range of 1-6 digits
    let orderId = orderIdMatch ? orderIdMatch[0].toUpperCase() : null;

    // Ensure proper Order ID format if a shorter numeric ID is matched
    if (orderId && !orderId.startsWith('SGE_0000')) {
        orderId = 'SGE_0000' + orderId.padStart(6, '0'); // Pad the numeric part to ensure it has 6 digits
    }

    // Prioritize phone number if found
    if (phoneNumber) {
        fetchOrdersByPhoneNumber(phoneNumber);
        return;
    }

    // Process as Order ID if valid
    if (orderId) {
        fetchOrderDetails(orderId);
        return;
    }

    // Handle unrecognized input
    const errorMessage = "I couldn't understand your input. Please provide a valid Order ID or mobile number.";
    addMessage(errorMessage);
    speak(errorMessage);
}

// Fetch order details from backend
function fetchOrderDetails(orderId) {
    showTypingIndicator();
    addMessage(`Fetching details for Order ID: ${orderId}...`);

    // Wait for 3 seconds before showing the result
    setTimeout(() => {
        fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ order_id: orderId })
        })
        .then(response => response.json())
        .then(data => {
            removeTypingIndicator();
            if (data.error) {
                addMessage(data.error);
                speak(data.error);
            } else {
                const details = formatOrderDetails(data.order);
                addMessage(details);
                speakOrderDetails(data.order);
            }
        })
        .catch(() => {
            removeTypingIndicator();
            const fetchError = 'Failed to fetch order details. Please try again.';
            addMessage(fetchError);
            speak(fetchError);
        });
    }, 3000); // 3 seconds delay
}

// Other existing functions remain unchanged...

// Fetch orders by mobile number
function fetchOrdersByPhoneNumber(phoneNumber) {
    showTypingIndicator();
    addMessage(`Fetching orders for mobile number: ${phoneNumber}...`);

    // Wait for 3 seconds before showing the result
    setTimeout(() => {
        fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ phone: phoneNumber })
        })
        .then(response => response.json())
        .then(data => {
            removeTypingIndicator();
            if (data.error) {
                addMessage(data.error);
                speak(data.error);
            } else {
                const orderList = formatOrderList(data.orders);
                addMessage(orderList);
                speakOrderList(data.orders);
            }
        })
        .catch(() => {
            removeTypingIndicator();
            const fetchError = 'Failed to fetch orders. Please try again.';
            addMessage(fetchError);
            speak(fetchError);
        });
    }, 3000); // 3 seconds delay
}

// Format order details for display
function formatOrderDetails(orderDetails) {
    const header = `
        <strong>Order ID:</strong> ${orderDetails[0].order_id}<br>
        <strong>Customer:</strong> ${orderDetails[0].full_name}<br>
        <strong>Total Quantity:</strong> ${orderDetails[0].total_quantity}<br>
        <strong>Total Amount:</strong> ₹${orderDetails[0].total_amount}<br>
        <strong>Payment Mode:</strong> ${orderDetails[0].payment_mode}<br>
        <strong>Address:</strong> ${orderDetails[0].street_address}, 
                                ${orderDetails[0].city}, 
                                ${orderDetails[0].state} - ${orderDetails[0].postal_code}, 
                                ${orderDetails[0].country}<br>
    `;
    const productDetails = orderDetails.map(product => `
        <li>
            <strong>Product:</strong> ${product.p_name} (${product.p_specification})<br>
            <strong>Price:</strong> ₹${product.p_price}<br>
            <strong>Discount:</strong> ${product.product_discount}%<br>
            <strong>Quantity:</strong> ${product.quantity}<br>
            <strong>Total Price:</strong> ₹${product.total_price}
        </li>
    `).join('');

    return `${header}<ul>${productDetails}</ul>`;
}

// Speak order details
function speakOrderDetails(orderDetails) {
    const header = `
        Here are the details for Order ID ${orderDetails[0].order_id}.
        Customer name: ${orderDetails[0].full_name}.
        Total quantity: ${orderDetails[0].total_quantity}.
        Total amount: ₹${orderDetails[0].total_amount}.
        Payment mode: ${orderDetails[0].payment_mode}.
        Address: ${orderDetails[0].street_address}, ${orderDetails[0].city}, 
        ${orderDetails[0].state}, ${orderDetails[0].postal_code}, ${orderDetails[0].country}.
    `;
    const productDetails = orderDetails.map(product => `
        Product: ${product.p_name}, Specification: ${product.p_specification}, 
        Price: ₹${product.p_price}, Discount: ${product.product_discount}%, 
        Quantity: ${product.quantity}, Total Price: ₹${product.total_price}.
    `).join(' ');

    speak(header + productDetails);
}

// Format and speak the order list for multiple orders
function formatOrderList(orders) {
    if (orders.length === 0) {
        return "No orders found for this mobile number.";
    }

    const orderList = orders.map(order => `
        <li>
            <strong>Order ID:</strong> ${order.order_id}<br>
            <strong>Total Quantity:</strong> ${order.total_quantity}<br>
            <strong>Total Amount:</strong> ₹${order.total_amount}<br>
            <strong>Payment Mode:</strong> ${order.payment_mode}<br>
        </li>
    `).join('');

    return `<ul>${orderList}</ul>`;
}

function speakOrderList(orders) {
    if (orders.length === 0) {
        speak("No orders found for this mobile number.");
        return;
    }

    orders.forEach(order => {
        speak(`Order ID: ${order.order_id}, Total quantity: ${order.total_quantity}, 
               Total amount: ₹${order.total_amount}, Payment mode: ${order.payment_mode}.`);
    });
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
