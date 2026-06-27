from app.database import get_connection

print("Connecting...")

conn = get_connection()

print("Connected!")

cursor = conn.cursor()

cursor.execute("SELECT NOW();")

print(cursor.fetchone())

cursor.close()
conn.close()

print("Done!")