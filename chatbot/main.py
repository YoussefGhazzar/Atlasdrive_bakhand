from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from app.routes.chat_routes import router
app = FastAPI(
title="Groq Chatbot API",
version="1.0.0"
)
app.add_middleware(CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
    )

app.include_router(router)

@app.get("/")
def root():
    return {"message": "Groq Chatbot API Running 2026"}


@app.post("/chat")
def chat_endpoint(request: dict):
    user_input = request.get("user_input")
    if not user_input:
        return {"error": "Missing 'user_input' in request body."}
    
    # Here you would typically call your chatbot logic to get a response
    # For demonstration purposes, we'll just echo the user input
    response = f"Echo: {user_input}"
    
    return {"response": response}
