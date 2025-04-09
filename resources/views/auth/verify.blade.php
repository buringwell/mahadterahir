    
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifikasi Email Anda') }}</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p>Sebelum melanjutkan, silakan verifikasi email Anda dengan mengklik link yang kami kirim ke email Anda.</p>
                    <p>Jika Anda tidak menerima email, klik tombol di bawah ini untuk mengirim ulang.</p>

                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Kirim Ulang Email Verifikasi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
