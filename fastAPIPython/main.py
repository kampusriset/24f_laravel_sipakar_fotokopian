from fastapi import FastAPI
from pydantic import BaseModel

# =====================================================================
# 1. INISIALISASI FASTAPI & PYDANTIC (Validasi Input)
# =====================================================================
app = FastAPI(
    title="API Fuzzy Tsukamoto POS Fotokopi",
    description="Mesin AI untuk menghitung prioritas antrean pesanan",
    version="1.0.0"
)

# Struktur data yang diterima dari PHP
class DataPesanan(BaseModel):
    waktu: float       # menit (Tenggat Waktu)
    halaman: float     # lembar (Jumlah Halaman)
    layanan: float     # detik/lembar (Jenis Layanan)
    antrean: float     # jumlah antrean menunggu

# =====================================================================
# 2. KELAS FUZZY TSUKAMOTO (Otak AI)
# =====================================================================
class FuzzyTsukamotoPOS:
    def __init__(self):
        self.rules = self._generate_rules()

    def _generate_rules(self):
        rules = {}
        # 1. TENGGAT WAKTU MEPET
        rules[('Mepet', 'Sedikit', 'Ringan', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Sedikit', 'Sedang', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Sedikit', 'Berat', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Sedang', 'Ringan', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Sedang', 'Sedang', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Sedang', 'Berat', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Banyak', 'Ringan', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Banyak', 'Sedang', 'Sepi')] = 'Tinggi'
        rules[('Mepet', 'Banyak', 'Berat', 'Sepi')] = 'Sedang'
        rules[('Mepet', 'Sedikit', 'Ringan', 'Normal')] = 'Tinggi'
        rules[('Mepet', 'Sedikit', 'Sedang', 'Normal')] = 'Tinggi'
        rules[('Mepet', 'Sedikit', 'Berat', 'Normal')] = 'Tinggi'
        rules[('Mepet', 'Sedang', 'Ringan', 'Normal')] = 'Tinggi'
        rules[('Mepet', 'Sedang', 'Sedang', 'Normal')] = 'Tinggi'
        rules[('Mepet', 'Sedang', 'Berat', 'Normal')] = 'Sedang'
        rules[('Mepet', 'Banyak', 'Ringan', 'Normal')] = 'Sedang'
        rules[('Mepet', 'Banyak', 'Sedang', 'Normal')] = 'Sedang'
        rules[('Mepet', 'Banyak', 'Berat', 'Normal')] = 'Rendah'
        rules[('Mepet', 'Sedikit', 'Ringan', 'Ramai')] = 'Tinggi'
        rules[('Mepet', 'Sedikit', 'Sedang', 'Ramai')] = 'Tinggi'
        rules[('Mepet', 'Sedikit', 'Berat', 'Ramai')] = 'Sedang'
        rules[('Mepet', 'Sedang', 'Ringan', 'Ramai')] = 'Sedang'
        rules[('Mepet', 'Sedang', 'Sedang', 'Ramai')] = 'Sedang'
        rules[('Mepet', 'Sedang', 'Berat', 'Ramai')] = 'Rendah'
        rules[('Mepet', 'Banyak', 'Ringan', 'Ramai')] = 'Rendah'
        rules[('Mepet', 'Banyak', 'Sedang', 'Ramai')] = 'Rendah'
        rules[('Mepet', 'Banyak', 'Berat', 'Ramai')] = 'Rendah'

        # 2. TENGGAT WAKTU NORMAL
        rules[('Normal', 'Sedikit', 'Ringan', 'Sepi')] = 'Tinggi'
        rules[('Normal', 'Sedikit', 'Sedang', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Sedikit', 'Berat', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Sedang', 'Ringan', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Sedang', 'Sedang', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Sedang', 'Berat', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Banyak', 'Ringan', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Banyak', 'Sedang', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Banyak', 'Berat', 'Sepi')] = 'Sedang'
        rules[('Normal', 'Sedikit', 'Ringan', 'Normal')] = 'Tinggi'
        rules[('Normal', 'Sedikit', 'Sedang', 'Normal')] = 'Sedang'
        rules[('Normal', 'Sedikit', 'Berat', 'Normal')] = 'Sedang'
        rules[('Normal', 'Sedang', 'Ringan', 'Normal')] = 'Sedang'
        rules[('Normal', 'Sedang', 'Sedang', 'Normal')] = 'Sedang'
        rules[('Normal', 'Sedang', 'Berat', 'Normal')] = 'Rendah'
        rules[('Normal', 'Banyak', 'Ringan', 'Normal')] = 'Rendah'
        rules[('Normal', 'Banyak', 'Sedang', 'Normal')] = 'Rendah'
        rules[('Normal', 'Banyak', 'Berat', 'Normal')] = 'Rendah'
        rules[('Normal', 'Sedikit', 'Ringan', 'Ramai')] = 'Sedang'
        rules[('Normal', 'Sedikit', 'Sedang', 'Ramai')] = 'Sedang'
        rules[('Normal', 'Sedikit', 'Berat', 'Ramai')] = 'Rendah'
        rules[('Normal', 'Sedang', 'Ringan', 'Ramai')] = 'Rendah'
        rules[('Normal', 'Sedang', 'Sedang', 'Ramai')] = 'Rendah'
        rules[('Normal', 'Sedang', 'Berat', 'Ramai')] = 'Rendah'
        rules[('Normal', 'Banyak', 'Ringan', 'Ramai')] = 'Rendah'
        rules[('Normal', 'Banyak', 'Sedang', 'Ramai')] = 'Rendah'
        rules[('Normal', 'Banyak', 'Berat', 'Ramai')] = 'Rendah'

        # 3. TENGGAT WAKTU LONGGAR
        rules[('Longgar', 'Sedikit', 'Ringan', 'Sepi')] = 'Rendah'
        rules[('Longgar', 'Sedikit', 'Sedang', 'Sepi')] = 'Rendah'
        rules[('Longgar', 'Sedikit', 'Berat', 'Sepi')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Ringan', 'Sepi')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Sedang', 'Sepi')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Berat', 'Sepi')] = 'Sedang'
        rules[('Longgar', 'Banyak', 'Ringan', 'Sepi')] = 'Sedang'
        rules[('Longgar', 'Banyak', 'Sedang', 'Sepi')] = 'Sedang'
        rules[('Longgar', 'Banyak', 'Berat', 'Sepi')] = 'Sedang'
        rules[('Longgar', 'Sedikit', 'Ringan', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Sedikit', 'Sedang', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Sedikit', 'Berat', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Ringan', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Sedang', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Berat', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Banyak', 'Ringan', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Banyak', 'Sedang', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Banyak', 'Berat', 'Normal')] = 'Rendah'
        rules[('Longgar', 'Sedikit', 'Ringan', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Sedikit', 'Sedang', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Sedikit', 'Berat', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Ringan', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Sedang', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Sedang', 'Berat', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Banyak', 'Ringan', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Banyak', 'Sedang', 'Ramai')] = 'Rendah'
        rules[('Longgar', 'Banyak', 'Berat', 'Ramai')] = 'Rendah'
        
        return rules

    # --- FUNGSI KEANGGOTAAN (FUZZIFIKASI) ---
    def fuzzify_waktu(self, x):
        miu = {'Mepet': 0, 'Normal': 0, 'Longgar': 0}
        if x <= 45: miu['Mepet'] = 1
        elif 45 < x < 60: miu['Mepet'] = (60 - x) / (60 - 45)
        
        if 45 < x <= 60: miu['Normal'] = (x - 45) / (60 - 45)
        elif 60 < x <= 120: miu['Normal'] = 1
        elif 120 < x < 135: miu['Normal'] = (135 - x) / (135 - 120)
        
        if 120 < x < 135: miu['Longgar'] = (x - 120) / (135 - 120)
        elif x >= 135: miu['Longgar'] = 1
        return miu

    def fuzzify_halaman(self, x):
        miu = {'Sedikit': 0, 'Sedang': 0, 'Banyak': 0}
        if x <= 25: miu['Sedikit'] = 1
        elif 25 < x < 40: miu['Sedikit'] = (40 - x) / (40 - 25)
        
        if 25 < x <= 40: miu['Sedang'] = (x - 25) / (40 - 25)
        elif 40 < x <= 75: miu['Sedang'] = 1
        elif 75 < x < 100: miu['Sedang'] = (100 - x) / (100 - 75)
        
        if 75 < x < 100: miu['Banyak'] = (x - 75) / (100 - 75)
        elif x >= 100: miu['Banyak'] = 1
        return miu

    def fuzzify_layanan(self, x):
        miu = {'Ringan': 0, 'Sedang': 0, 'Berat': 0}
        if x <= 4: miu['Ringan'] = 1
        elif 4 < x < 5: miu['Ringan'] = (5 - x) / (5 - 4)
        
        if 4 < x <= 5: miu['Sedang'] = (x - 4) / (5 - 4)
        elif 5 < x <= 15: miu['Sedang'] = 1
        elif 15 < x < 100: miu['Sedang'] = (100 - x) / (100 - 15)
        
        if 15 < x < 100: miu['Berat'] = (x - 15) / (100 - 15)
        elif x >= 100: miu['Berat'] = 1
        return miu

    def fuzzify_antrean(self, x):
        miu = {'Sepi': 0, 'Normal': 0, 'Ramai': 0}
        if x <= 2: miu['Sepi'] = 1
        elif 2 < x < 3: miu['Sepi'] = (3 - x) / (3 - 2)
        
        if 2 < x <= 3: miu['Normal'] = (x - 2) / (3 - 2)
        elif 3 < x <= 5: miu['Normal'] = 1
        elif 5 < x < 7: miu['Normal'] = (7 - x) / (7 - 5)
        
        if 5 < x < 7: miu['Ramai'] = (x - 5) / (7 - 5)
        elif x >= 7: miu['Ramai'] = 1
        return miu

    # --- INFERENSI & DEFUZZIFIKASI ---
    def hitung_prioritas(self, val_waktu, val_halaman, val_layanan, val_antrean):
        miu_waktu = self.fuzzify_waktu(val_waktu)
        miu_halaman = self.fuzzify_halaman(val_halaman)
        miu_layanan = self.fuzzify_layanan(val_layanan)
        miu_antrean = self.fuzzify_antrean(val_antrean)
        
        total_alpha_z = 0
        total_alpha = 0
        
        for w_key, w_val in miu_waktu.items():
            for h_key, h_val in miu_halaman.items():
                for l_key, l_val in miu_layanan.items():
                    for a_key, a_val in miu_antrean.items():
                        
                        # Operator MIN (Logika AND)
                        alpha = min(w_val, h_val, l_val, a_val)
                        
                        if alpha > 0:
                            output_kategori = self.rules[(w_key, h_key, l_key, a_key)]
                            
                            # Invers / Z Crisp Tsukamoto
                            if output_kategori == 'Rendah':
                                z = 50 - (alpha * 50)
                            elif output_kategori == 'Sedang':
                                z = 50
                            elif output_kategori == 'Tinggi':
                                z = 50 + (alpha * 50)
                                
                            total_alpha_z += alpha * z
                            total_alpha += alpha
                            
        # Defuzzifikasi Rata-Rata Terbobot
        if total_alpha == 0:
            return 0, "Rendah"
            
        z_akhir = total_alpha_z / total_alpha
        
        if z_akhir >= 75:
            label = "Tinggi"
        elif z_akhir >= 40:
            label = "Sedang"
        else:
            label = "Rendah"
            
        return z_akhir, label

# Inisialisasi Objek AI
sistem_fuzzy = FuzzyTsukamotoPOS()


# =====================================================================
# 3. ENDPOINT / JALUR API (Pintu masuk dari PHP)
# =====================================================================
@app.post("/hitung")
def hitung_api(pesanan: DataPesanan):
    # Masukkan data dari PHP ke fungsi Fuzzy
    z_score, label = sistem_fuzzy.hitung_prioritas(
        val_waktu=pesanan.waktu,
        val_halaman=pesanan.halaman,
        val_layanan=pesanan.layanan,
        val_antrean=pesanan.antrean
    )
    
    # Kembalikan jawaban ke PHP dalam bentuk JSON
    return {
        "status": 200,
        "message": "Perhitungan Fuzzy Berhasil",
        "input": {
            "waktu": pesanan.waktu,
            "halaman": pesanan.halaman,
            "layanan": pesanan.layanan,
            "antrean": pesanan.antrean
        },
        "output": {
            "z_score": round(z_score, 2),
            "prioritas": label
        }
    }