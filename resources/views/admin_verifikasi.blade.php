<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #ffe4f0, #e9ddff);
            overflow: hidden;
        }

        /* Emoji satu baris di tengah */
        .emoji-row {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            text-align: center;
            font-size: 3rem;
            opacity: 0.18;
            pointer-events: none;
            white-space: nowrap;
        }

        /* Bubble card besar */
        .bubble-card {
            border-radius: 36px;
            box-shadow: 0 30px 70px rgba(0,0,0,.18);
            animation: pop .6s ease;
            padding: 10px;
        }

        @keyframes pop {
            0% { transform: scale(.85); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .title {
            font-weight: 600;
            color: #000;
            text-align: center;
            margin-bottom: 6px;
        }

        .subtitle {
            font-size: .9rem;
            color: #888;
            text-align: center;
            margin-bottom: 22px;
        }

        /* Input besar & lembut */
        .form-control-lg {
            padding: 16px;
            border-radius: 18px;
        }

        /* Tombol */
        .btn-primary {
            border-radius: 18px;
            padding: 14px;
            font-size: 1.05rem;
            font-weight: 600;
            background: linear-gradient(135deg, #a0e9ff, #b4a7fc);
            border: none;
        }

        .btn-primary:hover {
            opacity: .9;
        }
    </style>
</head>
<body>

{{-- EMOJI BACKGROUND 1 BARIS --}}
<div class="emoji-row">
   💄  👑 🎀 🛍️
</div>

<div class="container d-flex justify-content-center align-items-center vh-100 position-relative">
    <div class="col-md-5 col-lg-4">

        <div class="card bubble-card">
            <div class="card-body p-5">

                <h4 class="title">Verifikasi</h4>
                <div class="subtitle">
                    Masukkan password
                </div>

                @if (session('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.verifikasi.post') }}">
                    @csrf

                    <div class="mb-3">
                        <input
                            type="password"
                            name="password"
                            class="form-control form-control-lg"
                            placeholder="🔐"
                            required
                        >
                    </div>

                    <button class="btn btn-primary w-100">
                        Verifikasi Password
                    </button>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('pilih.role') }}" class="text-decoration-none">
                        ← Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>
