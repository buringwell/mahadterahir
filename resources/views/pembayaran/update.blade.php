<div class="container">
    <h2>Edit Pembayaran</h2>
    <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Santri</label>
            <select name="santri_id" class="form-control" required>
                @foreach($santris as $santri)
                    <option value="{{ $santri->id }}" {{ $santri->id == $pembayaran->santri_id ? 'selected' : '' }}>
                        {{ $santri->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" value="{{ old('jumlah', $pembayaran->jumlah) }}" min="0" max="99999999.99" step="0.01" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $pembayaran->tanggal }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status Pembayaran</label>
            <select name="status_pembayaran" class="form-control">
                <option value="pending" {{ $pembayaran->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas" {{ $pembayaran->status_pembayaran == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="gagal" {{ $pembayaran->status_pembayaran == 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control">
                <option value="cash" {{ $pembayaran->metode_pembayaran == 'cash' ? 'selected' : '' }}>Cash</option>
                <option value="transfer" {{ $pembayaran->metode_pembayaran == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="qris" {{ $pembayaran->metode_pembayaran == 'qris' ? 'selected' : '' }}>QRIS</option>
                <option value="beasiswa" {{ $pembayaran->metode_pembayaran == 'beasiswa' ? 'selected' : '' }}>Beasiswa</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
