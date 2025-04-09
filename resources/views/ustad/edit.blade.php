
<div class="container">
    <h2>Edit Data Ustadz</h2>

    <form action="{{ route('ustadz.update', $ustadz->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" name="name" value="{{ $ustadz->user->name }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $ustadz->user->email }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin diubah)</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="mb-3">
            <label for="JK" class="form-label">Jenis Kelamin</label>
            <select class="form-control" name="JK">
                <option value="L" {{ $ustadz->JK == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $ustadz->JK == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="No_Hp" class="form-label">No HP</label>
            <input type="text" class="form-control" name="No_Hp" value="{{ $ustadz->No_Hp }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" name="alamat" value="{{ $ustadz->alamat }}" required>
        </div>

        <div class="mb-3">
            <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
            <input type="text" class="form-control" name="mata_pelajaran" value="{{ $ustadz->mata_pelajaran }}" required>
        </div>


        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

