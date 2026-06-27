from fastapi import APIRouter, HTTPException
from app.models.models import (
ChatRequest,
ChatResponse
)
router = APIRouter()

from app.services.chatbot_service import ChatbotService
service = ChatbotService()

@router.post(
"/chat",
response_model=ChatResponse
)
async def chat(request: ChatRequest):
    try:
        
        response = service.chat(request.message)
        

        return ChatResponse(response=response)
    
    except Exception as e: 
        raise HTTPException(status_code=500,detail=str(e))
 