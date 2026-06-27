from app.services.database_service import DatabaseService
from app.models.groq_model import GroqService


class ChatbotService:

    def __init__(self):
        self.groq = GroqService()

    def chat(self, message: str):

        lower = message.lower()

        if "voiture" in lower or "car" in lower:

            cars = DatabaseService.get_available_cars()

            if not cars:
                return "Il n'y a actuellement aucune voiture disponible."

            context = "Voitures disponibles :\n"

            for marque, modele, prix, dispo in cars:
                context += f"- {marque} {modele} : {prix} €/jour\n"

            prompt = f"""
Voici les données de la base AtlasDrive.

{context}

Question utilisateur :
{message}

Réponds uniquement avec les informations disponibles.
"""

            return self.groq.generate_response(prompt)

        return self.groq.generate_response(message)