from fastapi import APIRouter, HTTPException
from app.models.models import (
ChatRequest,
ChatResponse
)
from app.models.groq_model import GroqService
router = APIRouter()
service = GroqService()


@router.post(
"/chat",
response_model=ChatResponse
)
async def chat(request: ChatRequest):
    try:
        
        response = service.generate_response( request.message)
        
        return ChatResponse(response=response)
    
    except Exception as e: 
        raise HTTPException(status_code=500,detail=str(e))
 