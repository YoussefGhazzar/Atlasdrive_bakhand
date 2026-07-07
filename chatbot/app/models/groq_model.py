from groq import Groq
import os
import json
from app.prompts.prompts import SYSTEM_PROMPT 
from app.prompts.prompts import USER_PROMPT_TEMPLATE
from dotenv import load_dotenv

import os
from app.models.database import (
    query_available_cars,
    query_agency_details,
    query_reservation_details,
    calculate_booking_price
)
load_dotenv()

GROQ_API_KEY = os.getenv("GROQ_API_KEY")

# Define tools for database querying
TOOLS = [
    {
        "type": "function",
        "function": {
            "name": "query_available_cars",
            "description": "Search for available rental cars at AtlasDrive based on brand, category, city/location, transmission type, fuel type, and budget limit.",
            "parameters": {
                "type": "object",
                "properties": {
                    "category": {"type": "string", "description": "The category of the car, e.g., 'SUV', 'Citadine', 'Compacte', etc."},
                    "brand": {"type": "string", "description": "The car manufacturer/brand, e.g., 'Dacia', 'Renault', 'Peugeot'."},
                    "transmission": {"type": "string", "description": "Transmission type: 'manuelle' or 'automatique'."},
                    "fuel": {"type": "string", "description": "Fuel type: 'diesel' or 'essence' (petrol)."},
                    "max_price": {"type": "number", "description": "The maximum daily rental budget in MAD."},
                    "city": {"type": "string", "description": "The city/location of the rental agency."}
                }
            }
        }
    },
    {
        "type": "function",
        "function": {
            "name": "query_agency_details",
            "description": "Get contact information, addresses, phone numbers and locations of AtlasDrive rental agencies.",
            "parameters": {
                "type": "object",
                "properties": {
                    "city": {"type": "string", "description": "Filter agencies by city, e.g., 'Casablanca', 'Marrakech'."},
                    "agency_id": {"type": "integer", "description": "Search a specific agency by its ID."}
                }
            }
        }
    },
    {
        "type": "function",
        "function": {
            "name": "query_reservation_details",
            "description": "Look up status and details of an existing customer reservation using the reservation ID.",
            "parameters": {
                "type": "object",
                "properties": {
                    "reservation_id": {"type": "integer", "description": "The unique reservation ID."}
                },
                "required": ["reservation_id"]
            }
        }
    },
    {
        "type": "function",
        "function": {
            "name": "calculate_booking_price",
            "description": "Calculate the total estimated rental price for a specific car and date range.",
            "parameters": {
                "type": "object",
                "properties": {
                    "car_id": {"type": "integer", "description": "The vehicle ID."},
                    "start_date": {"type": "string", "description": "Start date of the rental in YYYY-MM-DD format."},
                    "end_date": {"type": "string", "description": "End date of the rental in YYYY-MM-DD format."}
                },
                "required": ["car_id", "start_date", "end_date"]
            }
        }
    }
]

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

        # Process message, executing tools if the model decides to use them
        for _ in range(5):  # loop up to 5 times to handle consecutive tool calls
            completion = self.client.chat.completions.create(
                model="llama-3.3-70b-versatile",
                messages=messages,
                temperature=0.5,
                max_tokens=1024,
                tools=TOOLS,
                tool_choice="auto"
            )

            response_message = completion.choices[0].message

            if response_message.tool_calls:
                # Add LLM's request to call a tool to history
                messages.append(response_message)
                
                # Execute each tool call
                for tool_call in response_message.tool_calls:
                    function_name = tool_call.function.name
                    try:
                        function_args = json.loads(tool_call.function.arguments)
                    except Exception:
                        function_args = {}

                    print(f"Calling tool: {function_name} with args: {function_args}")

                    # Execute local db query helper based on name
                    if function_name == "query_available_cars":
                        result = query_available_cars(**function_args)
                    elif function_name == "query_agency_details":
                        result = query_agency_details(**function_args)
                    elif function_name == "query_reservation_details":
                        result = query_reservation_details(**function_args)
                    elif function_name == "calculate_booking_price":
                        result = calculate_booking_price(**function_args)
                    else:
                        result = f"Error: Tool {function_name} not found."

                    print(f"Tool Result: {result[:200]}...")

                    # Append tool response
                    messages.append({
                        "role": "tool",
                        "tool_call_id": tool_call.id,
                        "name": function_name,
                        "content": result
                    })
                # Go to next iteration to give Groq all tool output
                continue
            else:
                return response_message.content

        # Fallback if max loop depth is reached
        return "I apologize, but I was unable to complete your request within the processing limit."
