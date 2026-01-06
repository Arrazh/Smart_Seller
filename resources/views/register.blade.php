<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e40af 0%, #7c3aed 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 80px;
            height: auto;
            object-fit: contain;
            border-radius: 50%;
        }

        .company-name {
            color: white;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 40px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, #1e40af, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-weight: 500;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f9fafb;
        }

        .form-control:focus {
            outline: none;
            border-color: #7c3aed;
            background: white;
            box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.1);
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #7c3aed);
            color: white;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 58, 237, 0.5);
        }

        .btn-secondary {
            background: white;
            color: #7c3aed;
            border: 2px solid #7c3aed;
        }

        .btn-secondary:hover {
            background: #7c3aed;
            color: white;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 14px;
        }

        .login-link a {
            color: #7c3aed;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 30px 25px;
            }

            .title {
                font-size: 24px;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <img src="{{ asset('images/BUMK.jpeg') }}" alt="Logo" class="logo">
            <div class="company-name">BADAN USAHA MILIK KAMPUS</div>
        </div>

        <div class="register-card">
            <h1 class="title">Daftar</h1>

            @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </div>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</body>
</html>