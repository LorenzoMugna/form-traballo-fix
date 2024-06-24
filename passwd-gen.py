import random
import base64

# Usato per generare nuove password per l'utente php su mysql (se dovesse servire)

random_number = random.randint(256**20, 256**21)
binary_stream = random_number.to_bytes((random_number.bit_length() + 7) // 8, 'big')
base64_number = base64.b64encode(str(random_number).encode()).decode()

print(base64_number)