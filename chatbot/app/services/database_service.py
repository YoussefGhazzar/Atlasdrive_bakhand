from app.database import get_connection


class DatabaseService:

    @staticmethod
    def get_available_cars():

        conn = get_connection()
        cursor = conn.cursor()

        cursor.execute("""
            SELECT
                marque,
                modele,
                prix_par_jour,
                disponible
            FROM voitures
            WHERE disponible = TRUE
        """)

        rows = cursor.fetchall()

        cursor.close()
        conn.close()

        return rows
    def get_car_by_brand(self, brand):
        conn = get_connection()
        cursor = conn.cursor()

        cursor.execute("""
            SELECT
                marque,
                modele,
                prix_par_jour,
                disponible
            FROM voitures
            WHERE marque = %s AND disponible = TRUE
        """, (brand,))

        rows = cursor.fetchall()

        cursor.close()
        conn.close()

        return rows
    
    def get_categories(self):
        conn = get_connection()
        cursor = conn.cursor()

        cursor.execute("""
            SELECT DISTINCT categorie
            FROM voitures
        """)

        rows = cursor.fetchall()

        cursor.close()
        conn.close()

        return rows
    def search_car(self, keyword):
        conn = get_connection()
        cursor = conn.cursor()
        cursor.execute("""
            SELECT
                marque,
                modele,
                prix_par_jour,
                disponible
            FROM voitures
            WHERE marque LIKE %s OR modele LIKE %s AND disponible = TRUE
        """, (f"%{keyword}%", f"%{keyword}%"))

        rows = cursor.fetchall()

        cursor.close()
        conn.close()

        return rows