<!DOCTYPE html>
<html>
<head>
    <title>Register - Kasir App</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        /* Wrapper center */
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            background: transparent;
        }

        /* Emoji background */
        .page-wrapper::before {
            content: "💄  👑 🎀 🛍️";
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 6rem;
            opacity: 0.18;
            pointer-events: none;
            white-space: nowrap;
            z-index: 0;
        }

        /* Glass bubble card */
        .card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 1.5rem;
            box-shadow: 0 20px 50px rgba(199, 45, 156, 0.35);
            border: 1px solid rgba(255, 1, 145, 0.4);
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
        }

    .card-header {
    background: transparent;   /* HILANGKAN WARNA BUBBLE */
    color: #000000ff;
    font-weight: 600;
    font-size: 1.3rem;
    text-align: center;
    border: none;
    border-radius: 0;
    padding-top: 1.5rem;
}


        .btn-primary {
            background: linear-gradient(135deg, #b0c4ecff, #d8caf4ff);
             color: black; /* warna tulisan Daftar */
            border: none;
            border-radius: 999px;
        }

        .btn-primary:hover {
             background: linear-gradient(to right, #ada9e3ff, #ada9e3ff);
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="card p-4">
        <div class="card-header">📝 Register Kasir</div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required minlength="8">
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>

            <p class="mt-3 text-center">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="fw-bold text-decoration-underline">Login di sini</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
