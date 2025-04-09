
<div class="container">
    <h2>Edit Petugas</h2>

    <form action="{{ route('petugas.update', $petugas->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $petugas->user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $petugas->user->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (Biarkan kosong jika tidak ingin mengubah)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" value="{{ $petugas->alamat }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No HP</label>
            <input type="text" name="no_hp" class="form-control" value="{{ $petugas->no_hp }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

