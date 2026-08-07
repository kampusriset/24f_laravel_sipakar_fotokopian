from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"], 
    allow_credentials=True,
    allow_methods=["*"],  
    allow_headers=["*"],
)

# Definisi Model Input 
class PesananInput(BaseModel):
    jenis_layanan_nama: str
    jumlah_halaman: int
    tenggat_waktu: int
    jenis_layanan_angka: int
    jumlah_antrean: int

@app.post("/hitung-prioritas")
def hitung_prioritas(data: PesananInput):
    
    # Eksekusi Bypass Layanan Pengecualian Pengetikan Dokumen
    if data.jenis_layanan_nama.lower() == 'pengetikan dokumen':
        return {
            "status": "success",
            "pesan": "Pesanan Jasa Ketik dialihkan dari antrean mesin cetak.",
            "nilai_prioritas": 0,
            "kategori_prioritas": "Tunda"
        }

    halaman = data.jumlah_halaman
    waktu = data.tenggat_waktu
    layanan = data.jenis_layanan_angka
    antrean = data.jumlah_antrean

    # Fuzzifikasi: Konversi Parameter ke Derajat Keanggotaan
    u_hal = {'sedikit': 0, 'sedang': 0, 'banyak': 0}
    u_hal['sedikit'] = 1 if halaman <= 1 else (0 if halaman >= 25 else (25 - halaman) / 24)
    if halaman <= 15 or halaman >= 75:
        u_hal['sedang'] = 0
    elif halaman <= 45:
        u_hal['sedang'] = (halaman - 15) / 30
    else:
        u_hal['sedang'] = (75 - halaman) / 30
    u_hal['banyak'] = 0 if halaman <= 65 else (1 if halaman >= 100 else (halaman - 65) / 35)

    u_waktu = {'mepet': 0, 'normal': 0, 'longgar': 0}
    u_waktu['mepet'] = 1 if waktu <= 0 else (0 if waktu >= 60 else (60 - waktu) / 60)
    if waktu <= 40 or waktu >= 120:
        u_waktu['normal'] = 0
    elif waktu <= 80:
        u_waktu['normal'] = (waktu - 40) / 40
    else:
        u_waktu['normal'] = (120 - waktu) / 40
    u_waktu['longgar'] = 0 if waktu <= 100 else (1 if waktu >= 180 else (waktu - 100) / 80)

    u_layanan = {'ringan': 0, 'berat': 0}
    u_layanan['ringan'] = 1 if layanan <= 1 else (0 if layanan >= 8 else (8 - layanan) / 7)
    u_layanan['berat'] = 0 if layanan <= 5 else (1 if layanan >= 13 else (layanan - 5) / 8)

    u_antrean = {'sepi': 0, 'ramai': 0}
    u_antrean['sepi'] = 1 if antrean <= 0 else (0 if antrean >= 6 else (6 - antrean) / 6)
    u_antrean['ramai'] = 0 if antrean <= 3 else (1 if antrean >= 10 else (antrean - 3) / 7)

    # Basis Aturan (36 Rule Base)
    rules = [
        {'w': 'mepet', 'h': 'sedikit', 'l': 'ringan', 'a': 'sepi', 'out': 'Normal'},
        {'w': 'mepet', 'h': 'sedikit', 'l': 'ringan', 'a': 'ramai', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'sedikit', 'l': 'berat', 'a': 'sepi', 'out': 'Normal'},
        {'w': 'mepet', 'h': 'sedikit', 'l': 'berat', 'a': 'ramai', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'sedang', 'l': 'ringan', 'a': 'sepi', 'out': 'Normal'},
        {'w': 'mepet', 'h': 'sedang', 'l': 'ringan', 'a': 'ramai', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'sedang', 'l': 'berat', 'a': 'sepi', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'sedang', 'l': 'berat', 'a': 'ramai', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'banyak', 'l': 'ringan', 'a': 'sepi', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'banyak', 'l': 'ringan', 'a': 'ramai', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'banyak', 'l': 'berat', 'a': 'sepi', 'out': 'Tinggi'},
        {'w': 'mepet', 'h': 'banyak', 'l': 'berat', 'a': 'ramai', 'out': 'Tinggi'},
        
        {'w': 'normal', 'h': 'sedikit', 'l': 'ringan', 'a': 'sepi', 'out': 'Rendah'},
        {'w': 'normal', 'h': 'sedikit', 'l': 'ringan', 'a': 'ramai', 'out': 'Rendah'},
        {'w': 'normal', 'h': 'sedikit', 'l': 'berat', 'a': 'sepi', 'out': 'Rendah'},
        {'w': 'normal', 'h': 'sedikit', 'l': 'berat', 'a': 'ramai', 'out': 'Normal'},
        {'w': 'normal', 'h': 'sedang', 'l': 'ringan', 'a': 'sepi', 'out': 'Normal'},
        {'w': 'normal', 'h': 'sedang', 'l': 'ringan', 'a': 'ramai', 'out': 'Normal'},
        {'w': 'normal', 'h': 'sedang', 'l': 'berat', 'a': 'sepi', 'out': 'Tinggi'},
        {'w': 'normal', 'h': 'sedang', 'l': 'berat', 'a': 'ramai', 'out': 'Normal'},
        {'w': 'normal', 'h': 'banyak', 'l': 'ringan', 'a': 'sepi', 'out': 'Tinggi'},
        {'w': 'normal', 'h': 'banyak', 'l': 'ringan', 'a': 'ramai', 'out': 'Normal'},
        {'w': 'normal', 'h': 'banyak', 'l': 'berat', 'a': 'sepi', 'out': 'Tinggi'},
        {'w': 'normal', 'h': 'banyak', 'l': 'berat', 'a': 'ramai', 'out': 'Tinggi'},
        
        {'w': 'longgar', 'h': 'sedikit', 'l': 'ringan', 'a': 'sepi', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'sedikit', 'l': 'ringan', 'a': 'ramai', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'sedikit', 'l': 'berat', 'a': 'sepi', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'sedikit', 'l': 'berat', 'a': 'ramai', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'sedang', 'l': 'ringan', 'a': 'sepi', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'sedang', 'l': 'ringan', 'a': 'ramai', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'sedang', 'l': 'berat', 'a': 'sepi', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'sedang', 'l': 'berat', 'a': 'ramai', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'banyak', 'l': 'ringan', 'a': 'sepi', 'out': 'Rendah'},
        {'w': 'longgar', 'h': 'banyak', 'l': 'ringan', 'a': 'ramai', 'out': 'Normal'},
        {'w': 'longgar', 'h': 'banyak', 'l': 'berat', 'a': 'sepi', 'out': 'Normal'},
        {'w': 'longgar', 'h': 'banyak', 'l': 'berat', 'a': 'ramai', 'out': 'Normal'},
    ]

    # Inferensi Z dan Predikat Alpha
    total_alpha_z = 0
    total_alpha = 0

    for rule in rules:
        alpha = min(
            u_waktu[rule['w']], 
            u_hal[rule['h']], 
            u_layanan[rule['l']], 
            u_antrean[rule['a']]
        )

        if alpha > 0:
            # Invers Kurva Output
            if rule['out'] == 'Rendah':
                z = 50 - (alpha * 50)
            elif rule['out'] == 'Normal':
                z = 25 + (alpha * 50)
            else:  # Tinggi
                z = 50 + (alpha * 50)
            
            total_alpha_z += (alpha * z)
            total_alpha += alpha

    # Defuzzifikasi Rata - Rata Terbobot
    hasil_prioritas = (total_alpha_z / total_alpha) if total_alpha > 0 else 0

    # Pemetaan Kategori Akhir
    if hasil_prioritas <= 37.5:
        kategori_akhir = 'Rendah'
    elif hasil_prioritas <= 62.5:
        kategori_akhir = 'Normal'
    else:
        kategori_akhir = 'Tinggi'

    return {
        "status": "success",
        "nilai_prioritas": round(hasil_prioritas, 2),
        "kategori_prioritas": kategori_akhir
    }