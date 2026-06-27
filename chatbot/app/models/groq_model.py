from groq import Groq

from app.prompts.prompts import SYSTEM_PROMPT 
from app.prompts.prompts import USER_PROMPT_TEMPLATE
import os

GROQ_API_KEY = os.getenv("GROQ_API_KEY")

class GroqService:

    def __init__(self):
        print("API Key :" , GROQ_API_KEY)
        self.client = Groq(
            api_key=GROQ_API_KEY
        )

    def generate_response(self, user_message: str):

        user_prompt = USER_PROMPT_TEMPLATE.format(
            user_input=user_message
        )

        messages = [
            {
                "role": "system",
                "content": SYSTEM_PROMPT
            },
            {
                "role": "user",
                "content": user_prompt
            }
        ]

        completion = self.client.chat.completions.create(
            model="openai/gpt-oss-120b",
            messages=messages,
            temperature=0.5,
            max_tokens=1024
        )

        return completion.choices[0].message.content



