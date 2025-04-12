
<div class="container">
    <h2>Rekap Absensi Bulan {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}</h2>

    <!-- Filter -->
    <form method="GET" action="{{ route('absensi.rekap') }}" class="form-inline mb-4">
        <select name="bulan" class="form-control mr-2">
            @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('bulan', $bulan) == $i ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                </option>
            @endfor
        </select>

        <select name="tahun" class="form-control mr-2">
            @for($y = 2023; $y <= now()->year; $y++)
                <option value="{{ $y }}" {{ request('tahun', $tahun) == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <select name="kelas_id" class="form-control mr-2">
            <option value="">Pilih Kelas</option>
            @foreach($kelasOptions as $id => $nama)
                <option value="{{ $id }}" {{ request('kelas_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
        </select>

        <select name="kamar_id" class="form-control mr-2">
            <option value="">Pilih Kamar</option>
            @foreach($kamarOptions as $id => $nama)
                <option value="{{ $id }}" {{ request('kamar_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
            @endforeach
        </select>
            
            <select name="semester" class="form-control mx-2">
                <option value="">Pilih Semester</option>
                <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
            </select>

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>

    <!-- Rekap Tabel -->
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Hadir</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alfa</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap as $santriId => $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $santris[$santriId]->user->name ?? '-' }}</td>
                    <td>{{ $data['hadir'] }}</td>
                    <td>{{ $data['izin'] }}</td>
                    <td>{{ $data['sakit'] }}</td>
                    <td>{{ $data['alfa'] }}</td>
                    <td>{{ array_sum($data) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data absensi untuk bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
