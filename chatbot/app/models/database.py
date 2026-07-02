import os
import psycopg2
from psycopg2.extras import RealDictCursor
from datetime import datetime

def get_db_connection():
    return psycopg2.connect(
        host=os.getenv("DB_HOST", "localhost"),
        port=os.getenv("DB_PORT", "5432"),
        database=os.getenv("DB_NAME", "Multipe_agence_location"),
        user=os.getenv("DB_USER", "postgres"),
        password=os.getenv("DB_PASSWORD", "12345")
    )

def query_available_cars(category=None, brand=None, transmission=None, fuel=None, max_price=None, city=None):
    """
    Search for available rental cars based on user requirements.
    """
    conn = None
    try:
        conn = get_db_connection()
        cur = conn.cursor(cursor_factory=RealDictCursor)
        
        query = """
            SELECT v.id, v.marque as brand, v.modele as model, v.annee as year, 
                   v.prix_par_jour as price_per_day, v.nb_places as seats, 
                   v.transmission, v.carburant as fuel, v.couleur as color, 
                   v.description, c.name as category, a.nom_agence as agency_name, 
                   a.ville as city, a.address, a.telephone
            FROM public.voitures v
            LEFT JOIN public.categories c ON v.category_id = c.id
            LEFT JOIN public.agences a ON v.agency_id = a.id
            WHERE v.disponible = TRUE
        """
        params = []
        
        if category:
            query += " AND (c.name ILIKE %s OR c.slug ILIKE %s)"
            params.extend([f"%{category}%", f"%{category}%"])
        if brand:
            query += " AND v.marque ILIKE %s"
            params.append(f"%{brand}%")
        if transmission:
            query += " AND v.transmission ILIKE %s"
            params.append(f"%{transmission}%")
        if fuel:
            query += " AND v.carburant ILIKE %s"
            params.append(f"%{fuel}%")
        if max_price:
            try:
                query += " AND v.prix_par_jour <= %s"
                params.append(float(max_price))
            except ValueError:
                pass
        if city:
            query += " AND a.ville ILIKE %s"
            params.append(f"%{city}%")
            
        query += " ORDER BY v.prix_par_jour ASC LIMIT 10"
        
        cur.execute(query, params)
        results = cur.fetchall()
        
        if not results:
            return "No available cars matching those criteria were found."
            
        # Format output
        output = "Available Cars:\n"
        for row in results:
            output += (f"- ID: {row['id']} | {row['brand']} {row['model']} ({row['year']}) | "
                       f"Category: {row['category']} | Price: {row['price_per_day']} MAD/day | "
                       f"Specs: {row['seats']} seats, {row['transmission']}, {row['fuel']} | "
                       f"Location: {row['agency_name']} in {row['city']}\n")
        return output
        
    except Exception as e:
        return f"Database error while fetching cars: {str(e)}"
    finally:
        if conn:
            conn.close()

def query_agency_details(city=None, agency_id=None):
    """
    Retrieve contact and address details of AtlasDrive rental agencies.
    """
    conn = None
    try:
        conn = get_db_connection()
        cur = conn.cursor(cursor_factory=RealDictCursor)
        
        query = """
            SELECT id, nom_agence as agency_name, ville as city, address, telephone, email, status
            FROM public.agences
            WHERE status != 'Suspended'
        """
        params = []
        
        if agency_id:
            query += " AND id = %s"
            params.append(int(agency_id))
        elif city:
            query += " AND ville ILIKE %s"
            params.append(f"%{city}%")
            
        cur.execute(query, params)
        results = cur.fetchall()
        
        if not results:
            return "No agencies found."
            
        output = "AtlasDrive Agencies:\n"
        for row in results:
            output += (f"- Agency ID: {row['id']} | Name: {row['agency_name']} | "
                       f"City: {row['city']} | Address: {row['address']} | "
                       f"Tel: {row['telephone']} | Email: {row['email']}\n")
        return output
        
    except Exception as e:
        return f"Database error while fetching agencies: {str(e)}"
    finally:
        if conn:
            conn.close()

def query_reservation_details(reservation_id):
    """
    Look up details and status of an existing reservation.
    """
    conn = None
    try:
        conn = get_db_connection()
        cur = conn.cursor(cursor_factory=RealDictCursor)
        
        query = """
            SELECT r.id, r.date_debut as start_date, r.date_fin as end_date, 
                   r.prix_total as total_price, r.statut as status, r.notes,
                   v.marque as car_brand, v.modele as car_model, 
                   a.nom_agence as agency_name, u.nom as client_last_name, u.prenom as client_first_name
            FROM public.reservations r
            LEFT JOIN public.voitures v ON r.voiture_id = v.id
            LEFT JOIN public.agences a ON r.agency_id = a.id
            LEFT JOIN public.users u ON r.user_id = u.id
            WHERE r.id = %s
        """
        cur.execute(query, [int(reservation_id)])
        row = cur.fetchone()
        
        if not row:
            return f"No reservation found with ID {reservation_id}."
            
        output = (f"Reservation #{row['id']} Details:\n"
                  f"- Client: {row['client_first_name']} {row['client_last_name']}\n"
                  f"- Vehicle: {row['car_brand']} {row['car_model']}\n"
                  f"- Agency: {row['agency_name']}\n"
                  f"- Rental Period: from {row['start_date']} to {row['end_date']}\n"
                  f"- Total Price: {row['total_price']} MAD\n"
                  f"- Status: {row['status']}\n")
        if row['notes']:
            output += f"- Notes: {row['notes']}\n"
        return output
        
    except Exception as e:
        return f"Database error while fetching reservation: {str(e)}"
    finally:
        if conn:
            conn.close()

def calculate_booking_price(car_id, start_date, end_date):
    """
    Calculate the total rental cost for a specific car and date range.
    """
    conn = None
    try:
        conn = get_db_connection()
        cur = conn.cursor(cursor_factory=RealDictCursor)
        
        cur.execute("SELECT id, marque, modele, prix_par_jour, disponible FROM public.voitures WHERE id = %s", [int(car_id)])
        car = cur.fetchone()
        
        if not car:
            return f"Car with ID {car_id} not found."
            
        # Parse dates
        d1 = datetime.strptime(start_date, "%Y-%m-%d")
        d2 = datetime.strptime(end_date, "%Y-%m-%d")
        days = (d2 - d1).days
        
        if days <= 0:
            return "Error: End date must be after start date."
            
        price_per_day = float(car['prix_par_jour'])
        total_price = days * price_per_day
        
        return (f"Rental Price Estimation:\n"
                f"- Car: {car['marque']} {car['modele']} (ID: {car['id']})\n"
                f"- Daily Rate: {price_per_day} MAD/day\n"
                f"- Duration: {days} days\n"
                f"- Estimated Total: {total_price} MAD\n"
                f"- Status: {'Available' if car['disponible'] else 'Not available (Currently booked)'}\n")
                
    except ValueError:
        return "Error: Date formats must be YYYY-MM-DD."
    except Exception as e:
        return f"Database error while calculating price: {str(e)}"
    finally:
        if conn:
            conn.close()
