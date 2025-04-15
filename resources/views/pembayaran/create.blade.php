
<div class="container">
    <h2>Tambah Pembayaran</h2>

    <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Santri</label>
            <select name="santri_id" class="form-control" required>
                <option value="">-- Pilih Santri --</option>
                @foreach($santris as $santri)
                    <option value="{{ $santri->id }}">{{ $santri->user->name }}</option> <!-- ✅ Ambil nama dari user -->
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="bulan">Bulan Dibayar</label>
            <select name="bulan" id="bulan" class="form-control" required>
                <option value="">-- Pilih Bulan --</option>
                @foreach([
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ] as $bulan)
                    <option value="{{ $bulan }}">{{ $bulan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="0" max="99999999.99" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
                <option value="qris">QRIS</option>
                <option value="beasiswa">Beasiswa</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">File Transaksi (opsional)</label>
            <input type="file" name="file_transaksi" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Pembayaran</button>
    </form>
</div>

