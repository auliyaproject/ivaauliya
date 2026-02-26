<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akses Terkunci</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #ffe4f0, #e9ddff);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Emoji background satu baris */
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

        /* Emoji lock utama */
        .lock {
            font-size: 130px;
            z-index: 2;
            animation: pop .6s ease;
        }

        @keyframes pop {
            0% { transform: scale(.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

    {{-- EMOJI BACKGROUND --}}
    <div class="emoji-row">
        🌸 ✨ 👑 💖 🔐 🌷 💎 ✨ 🌸
    </div>

    {{-- LOCK --}}
    <div class="lock">
        🔐
    </div>

</body>
</html>
