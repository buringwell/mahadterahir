<h2>Lupa Password</h2>
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <input type="email" name="email" placeholder="Email" required>
    <button type="submit">Kirim Link Reset</button>
</form>

@if (session('status'))
    <p>{{ session('status') }}</p>
@endif
