<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pilih Role</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #ffe4f0, #e9ddff);
            overflow: hidden;
        }

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

        .bubble-card {
            border-radius: 28px;
            box-shadow: 0 25px 50px rgba(0,0,0,.15);
            animation: pop 0.6s ease;
        }

        @keyframes pop {
            0% { transform: scale(.85); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .role-btn {
            border-radius: 20px;
            padding: 18px;
            font-weight: 600;
            font-size: 1.1rem;
            border: none;
            transition: .3s;
            color: #fff;
        }

        .role-admin {
            background: linear-gradient(135deg, #f8acd6, #a2cff0);
        }

        .role-kasir {
            background: linear-gradient(135deg, #a0e9ff, #b4a7fc);
        }

        .role-btn:hover {
            opacity: .9;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<div class="emoji-row">
    🌈 🦄 💄 💅 🎀 👑 💎 💰 🌷 🛍️
</div>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-md-4">

        <div class="card bubble-card">
            <div class="card-body p-4">

                <h4 class="text-center fw-bold">Pilih Role</h4>
                <p class="text-center text-muted mb-4">Masuk sebagai Admin atau Kasir</p>

                <div class="d-grid gap-3">

                    {{-- ADMIN --}}
                    <form method="POST" action="{{ route('pilih.role.post') }}">
                        @csrf
                        <input type="hidden" name="role" value="admin">
                        <button class="btn role-btn role-admin w-100">
                            👑 Admin
                        </button>
                    </form>

                    {{-- KASIR --}}
                    <form method="POST" action="{{ route('pilih.role.post') }}">
                        @csrf
                        <input type="hidden" name="role" value="kasir">
                        <button class="btn role-btn role-kasir w-100">
                            🧾 Kasir
                        </button>
                    </form>

                </div>

                <div class="text-center mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-link text-decoration-none">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>
