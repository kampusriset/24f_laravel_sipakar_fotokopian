// document.addEventListener('DOMContentLoaded', function () {
//     // --- 1. LOGIKA TOGGLE SUMBER DOKUMEN ---
//     const sumberDokumen = document.getElementById('sumber_dokumen');
//     const wrapperFile = document.getElementById('wrapper_file');
//     const wrapperHalaman = document.getElementById('wrapper_halaman');
//     const inputFile = document.getElementById('file_dokumen');
//     const inputHalaman = document.getElementById('jumlah_halaman_manual');

//     function toggleSumberDokumen() {
//         if (sumberDokumen.value === 'fisik') {
//             wrapperFile.classList.add('d-none');
//             inputFile.removeAttribute('required');
            
//             wrapperHalaman.classList.remove('d-none');
//             inputHalaman.setAttribute('required', 'required');
//         } else {
//             wrapperHalaman.classList.add('d-none');
//             inputHalaman.removeAttribute('required');
            
//             wrapperFile.classList.remove('d-none');
//             inputFile.setAttribute('required', 'required');
//         }
//     }

//     if (sumberDokumen) {
//         sumberDokumen.addEventListener('change', toggleSumberDokumen);
//         toggleSumberDokumen();
//     }

//     // --- 2. LOGIKA KONEKSI KE API FAST API (FUZZY TSUKAMOTO) ---
//     const formTransaksi = document.getElementById('formTransaksi');
    
//     if(formTransaksi) {
//         formTransaksi.addEventListener('submit', async function(e) {
//             e.preventDefault(); 

//             // Ubah tampilan tombol jadi Loading
//             const btnSubmit = document.getElementById('btnSubmitAntrean');
//             const btnText = document.getElementById('btnText');
//             const btnLoading = document.getElementById('btnLoading');
            
//             btnSubmit.disabled = true;
//             btnText.classList.add('d-none');
//             btnLoading.classList.remove('d-none');

//             try {
//                 // A. Ambil Text Jenis Layanan
//                 const selectLayanan = document.getElementById('layanan_id');
//                 const layananNama = selectLayanan.options[selectLayanan.selectedIndex].text;
                
//                 // Asumsi sementara untuk angka durasi layanan
//                 // const layananAngka = 5; 

//                 // B. Cek Jumlah Halaman
//                 let jmlHalaman = 10; 
//                 if (sumberDokumen.value === 'fisik') {
//                     jmlHalaman = parseInt(inputHalaman.value) || 1;
//                 }

//                 // C. Hitung Tenggat Waktu
//                 const waktuDeadline = document.getElementById('waktu_deadline').value;
//                 const now = new Date();
//                 const targetTime = new Date();
//                 const [hours, minutes] = waktuDeadline.split(':');
//                 targetTime.setHours(parseInt(hours), parseInt(minutes), 0, 0);
                
//                 let diffMinutes = Math.floor((targetTime - now) / 60000);
//                 if (diffMinutes < 0) diffMinutes += 24 * 60; 

//                 // D. Hitung Jumlah Antrean Saat Ini di Tabel
//                 let jmlAntrean = 0;
//                 const rowKosong = document.getElementById('rowKosong');
//                 if (!rowKosong) {
//                     jmlAntrean = document.querySelectorAll('#tabelAntrean tbody tr').length;
//                 }

//                 // Bungkus data untuk dikirim ke Python
//                 const payloadData = {
//                     jenis_layanan_nama: layananNama,
//                     jumlah_halaman: jmlHalaman,
//                     tenggat_waktu: diffMinutes,
//                     jenis_layanan_angka: layananAngka,
//                     jumlah_antrean: jmlAntrean
//                 };

//                 console.log("Data yang dikirim ke AI:", payloadData);

//                 // E. Tembak API Python FastAPI
//                 const response = await fetch('http://127.0.0.1:8000/hitung-prioritas', {
//                     method: 'POST',
//                     headers: {
//                         'Content-Type': 'application/json'
//                     },
//                     body: JSON.stringify(payloadData)
//                 });

//                 const hasilAI = await response.json();
//                 console.log("Balasan dari AI:", hasilAI);

//                 // F. Masukkan Hasil AI ke dalam Input Hidden di Form
//                 document.getElementById('input_nilai_prioritas').value = hasilAI.nilai_prioritas;
//                 document.getElementById('input_kategori_prioritas').value = hasilAI.kategori_prioritas;

//                 // G. Lanjutkan Proses Submit Form ke Laravel 
//                 HTMLFormElement.prototype.submit.call(formTransaksi);

//             } catch (error) {
//                 console.error("Gagal terhubung ke API Fuzzy:", error);
//                 alert("Koneksi ke AI Gagal. Pastikan server Python sedang berjalan.");
                
//                 btnSubmit.disabled = false;
//                 btnText.classList.remove('d-none');
//                 btnLoading.classList.add('d-none');
//             }
//         });
//     }

//     // Auto Close Alert
//     setTimeout(function() {
//         var alertElement = document.getElementById('myAlert');
//         if (alertElement) {
//             var alert = new bootstrap.Alert(alertElement);
//             alert.close();
//         }
//     }, 3000);
// });