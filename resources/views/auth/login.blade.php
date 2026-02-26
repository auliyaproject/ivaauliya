<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Kasir App</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        /* Emoji Background */
        .page-wrapper::before {
            content: "💄 💅 🎀 👑 🦋 💰 🌺 🛍️ ✨";
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

        /* Glass Bubble Card */
        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(14px);
            border-radius: 1.5rem;
            box-shadow: 0 20px 50px rgba(236, 72, 153, 0.35);
            border: 1px solid rgba(248, 0, 141, 0.4);
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 420px;
        }

        .card-header {
            background: transparent;
            color: #000000ff;
            font-weight: bold;
            font-size: 1.3rem;
            text-align: center;
            border: none;
            padding-top: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #b0c4ec, #d8caf4);
            border: none;
            border-radius: 999px;
            color: black;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ada9e3, #ada9e3);
        }
    </style>
</head>
<body>

<div class="page-wrapper">
    <div class="card p-4">
        <div class="card-header">💄🎀 Login  👑🛍️</div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- LOGIN FORM --}}
            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    Login
                </button>
            </form>

            <p class="mt-3 text-center">
                Belum punya akun?
                <a href="{{ route('register.form') }}" class="fw-bold text-decoration-underline">
                    Daftar di sini
                </a>
            </p>

        </div>
    </div>
</div>

</body>
</html>
