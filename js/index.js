// import the ChatGPTAPI 
import { ChatGPTAPI } from 'chatgpt'

async function myFunction() {
  // Initialize the constructor with your OpenAI API key
  const api = new ChatGPTAPI({
    apiKey: "sk-...xtOR"
  })
  // Invoke the sendMessage method to send a message to the GPT-3 model
  const res = await api.sendMessage('Hello World!');
  // display the response
  console.log(res.text);
}

// Make the function call to execute the functionality
myFunction().then((data)=>{
    // do something
})