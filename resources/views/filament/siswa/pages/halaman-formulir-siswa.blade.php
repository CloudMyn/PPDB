<x-filament-panels::page>
    <div class="container">

        @if ($this->status_kelulusan == 'lulus')
            <div class="alert alert-success">
                <strong>Selamat</strong> anda telah <strong>lulus</strong> seleksi penerimaan siswa baru SMP Negeri 2
                TOWUTI
            </div>
        @elseif ($this->status_kelulusan == 'gagal')
            <div class="alert alert-danger">
                <strong>Mohon Maaf</strong> anda telah <strong>tidak lulus</strong> seleksi penerimaan siswa baru SMP Negeri 2
                TOWUTI
            </div>
        @elseif ($this->record->status_pendaftaran == 'belum_verifikasi')
            <div class="alert alert-warning">
                <strong>Informasi</strong> verifikasi formulir/data anda sedang dalam antrian
            </div>
        @elseif ($this->record->status_pendaftaran == 'berhasil_verifikasi')
            <div class="alert alert-success">
                <strong>Verifikasi Berhasil</strong> silahkan menunggu informasi terkait kelulusan anda
            </div>
        @elseif ($this->record->status_pendaftaran == 'gagal_verifikasi')
            <div class="alert alert-danger">
                <strong>Verifikasi Gagal</strong> verfikasi formulir/data anda gagal, silahkan lakukan pengisian
                formulir ulang
            </div>
        @endif

        <div id="receipt" class="receipt card p-4">
            <h4 class="title">Penerimaan Peserta Didik Baru <br> SMP Negeri 2 TOWUTI</h4>
            <hr>
            <div class="receipt-wraper">
                <div class="foto-siswa">
                    <img src="/storage/{{ $this->record->foto }}" alt="">
                </div>
                <div class="attribute-box">
                    <div class="attribute">
                        <span class="label">Nomor Formulir : </span>
                        <span class="value">{{ $this->record->nomor_formulir }}</span>
                    </div>
                    <div class="attribute">
                        <span class="label">Nama Lengkap : </span>
                        <span class="value">{{ $this->record->nama_lengkap }}</span>
                    </div>
                    <div class="attribute">
                        <span class="label">NISN : </span>
                        <span class="value">{{ $this->record->calonSiswa->nisn }}</span>
                    </div>
                    <div class="attribute">
                        <span class="label">Nomor Telepon : </span>
                        <span class="value">{{ $this->record->nomor_telepon }}</span>
                    </div>
                    <div class="attribute">
                        <span class="label">JALUR : </span>
                        <span class="value">{{ $this->record->jalur_pendaftaran }}</span>
                    </div>
                    <div class="attribute">
                        <span class="label">alamat : </span>
                        <span class="value">{{ $this->record->alamat }}</span>
                    </div>
                </div>
            </div>
            <div class="signature-box">
                <div class="signature">
                    <p>Tanda Tangan Peserta</p>
                    <div class="signature-line"></div>
                    {{-- <p>Towuti, <span id="receipt-date"></span></p> --}}
                </div>
                <div class="signature">
                    <p>Towuti, {{ date('d F Y') }}</p>
                    {{-- <div class="signature-line"></div> --}}
                    <p style="margin-bottom: 0px">Panitia seleksi penerimaan siswa baru</p>
                </div>
            </div>
        </div>
    </div>

    <div style="display: flex; gap: 20px; justify-content: center; align-items: center;">
        <button class="btn btn-primary" onclick="generatePDF()">Download PDF</button>
        @if ($this->record->status_pendaftaran == 'berhasil_verifikasi')
            <a class="btn btn-success" href="/FORMULIR-PPDB-2024-2025.docx">Download Surat</a>
        @endif
    </div>

    <script>
        function generatePDF() {
            const receipt = document.getElementById('receipt');
            html2PDF(receipt, {
                jsPDF: {
                    format: 'a4',
                },
                imageType: 'image/jpeg',
                output: './pdf/bukti_pendaftaran.pdf'
            });
        }
    </script>
</x-filament-panels::page>
