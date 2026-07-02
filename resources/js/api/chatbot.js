const CHATBOT_BASE_URL = import.meta.env.VITE_CHATBOT_URL || 'http://localhost:8001';

export async function sendMessage(message) {
  const response = await fetch(`${CHATBOT_BASE_URL}/chat`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    body: JSON.stringify({ message }),
  });

  if (!response.ok) {
    const errorText = await response.text();
    throw new Error(errorText || 'Chatbot request failed');
  }

  const data = await response.json();
  return { response: data.response ?? 'Sorry, I could not answer that right now.' };
}
