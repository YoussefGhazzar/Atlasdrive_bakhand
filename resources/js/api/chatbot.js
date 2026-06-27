import axios from "axios";

export async function sendMessage(message) {
    const { data } = await axios.post("/api/chatbot", {
        message,
    });

    return data;
}