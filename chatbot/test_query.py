from app.services.database_service import DatabaseService

cars = DatabaseService.get_available_cars()

print(cars)