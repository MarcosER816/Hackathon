const apiKey = "sk-...xtOR"; // Replace YOUR_API_KEY with your actual ChatGPT API key
const chatbotFrame = document.getElementById("chatbot");
chatbotFrame.src = `https://api.openai.com/embeddings/chat-demo/chat.html?api_key=${apiKey}`;