<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Sekolah</title>

    <style>
      
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .login-page {
            background: linear-gradient( 45deg, #A0CAE0, #2449a4);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            box-sizing: border-box;
        }

        
        .login-card {
            background: linear-gradient(145deg, #2449a4 0%, #1e3d8b 100%);
            width: 100%;
            max-width: 850px;
            min-height: 480px;
            border-radius: 28px;
            display: flex;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.35);
            position: relative;
        }

       
        .login-left {
            background: linear-gradient(135deg, #ffffff 0%, #eef4ff 100%);
            flex: 1;
            padding: 45px 35px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            clip-path: ellipse(120% 100% at 20% 50%);
            z-index: 2;
        }

        .login-left-content {
            max-width: 300px;
        }

        .login-left h1 {
            color: #2449a4;
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 10px 0;
            line-height: 1.2;
        }

        .login-left p {
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 30px 0;
        }

       
        .login-right {
            flex: 1;
            padding: 45px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #ffffff;
            z-index: 1;
        }

        .login-right h2 {
            font-size: 30px;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 25px;
            color: #ffffff;
        }


        .error-alert {
            background-color: #ef4444;
            color: #ffffff;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            margin-bottom: 8px;
            color: #e0e7ff;
        }

        .form-group input {
            width: 100%;
            padding: 12px 18px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background-color: #1a3578;
            color: #ffffff;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-group input::placeholder {
            color: #8da2fb;
        }

        .form-group input:focus {
            background-color: #152b61;
            box-shadow: 0 0 0 2px #A0CAE0;
            border-color: transparent;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #A0CAE0;
            color: #2449a4;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-login:hover {
            background: #2449a4;
            color: #ffffff;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                border-radius: 20px;
            }

            .login-left {
                clip-path: none;
                border-bottom-right-radius: 40px;
                border-bottom-left-radius: 40px;
                padding: 30px 25px;
            }

            .login-right {
                padding: 30px 25px;
            }
        }
    </style>
</head>
<body>

    <div class="login-page">
        <div class="login-card">
        
            <div class="login-left">
                <div class="login-left-content">
                    <h1>Sistem Akademik</h1>
                    <p>Selamat datang! Silakan masukan kredensial akun Anda untuk mengakses dashboard sekolah.</p>
                </div>
            </div>

            <div class="login-right">
                <h2>Login</h2>

                @if ($errors->any())
                    <div class="error-alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.proses') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn-login">
                        Login
                    </button>
                </form>
            </div>

        </div>
    </div>

</body>
</html>