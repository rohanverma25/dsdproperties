<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login — DSD Properties</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f7fb; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-wrap { width: 100%; max-width: 440px; }
        .auth-brand { text-align: center; margin-bottom: 28px; }
        .auth-brand a { text-decoration: none; font-size: 22px; font-weight: 700; color: #011f4b; }
        .auth-brand a span { color: #008080; }
        .auth-brand p { font-size: 13px; color: #64748b; margin-top: 4px; }
        .auth-card { background: #fff; border-radius: 14px; box-shadow: 0 4px 24px rgba(1,31,75,.08); padding: 36px; }
        .auth-title { font-size: 19px; font-weight: 700; color: #011f4b; margin-bottom: 6px; }
        .auth-sub { font-size: 13px; color: #64748b; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 12.5px; font-weight: 600; color: #64748b; margin-bottom: 6px; }
        input[type=email], input[type=password], input[type=text] {
            width: 100%; padding: 10px 13px; border: 1.5px solid #e2e8f0; border-radius: 8px;
            font-family: 'Poppins', sans-serif; font-size: 13.5px; color: #1a2235; transition: border-color .15s;
        }
        input:focus { outline: none; border-color: #008080; box-shadow: 0 0 0 3px rgba(0,128,128,.1); }
        .input-error { border-color: #dc2626 !important; }
        .err-msg { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .alert { padding: 11px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .btn-submit {
            width: 100%; padding: 11px; background: #011f4b; color: #fff; border: none;
            border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; font-weight: 600;
            cursor: pointer; transition: background .15s; margin-top: 6px;
        }
        .btn-submit:hover { background: #023372; }
        .auth-links { text-align: center; margin-top: 20px; font-size: 13px; color: #64748b; }
        .auth-links a { color: #008080; text-decoration: none; font-weight: 500; }
        .auth-links a:hover { text-decoration: underline; }
        .divider { text-align: center; margin: 18px 0; color: #94a3b8; font-size: 12px; position: relative; }
        .divider::before, .divider::after { content: ''; position: absolute; top: 50%; width: 42%; height: 1px; background: #e2e8f0; }
        .divider::before { left: 0; } .divider::after { right: 0; }
    </style>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-brand">
        <a href="{{ url('/') }}"><span>DSD</span> Properties</a>
        <p>Seller Account Portal</p>
    </div>
    <div class="auth-card">
        <div class="auth-title">Welcome back</div>
        <div class="auth-sub">Login to manage your property listings</div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('seller.login.post') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="{{ $errors->has('email') ? 'input-error' : '' }}"
                    placeholder="you@example.com" required autocomplete="email">
                @error('email') <div class="err-msg">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password"
                    placeholder="••••••••" required autocomplete="current-password">
                @error('password') <div class="err-msg">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn-submit">Login to Dashboard →</button>
        </form>

        <div class="divider">or</div>
        <div class="auth-links">
            New seller? <a href="{{ route('seller.register') }}">Create free account</a>
        </div>
    </div>
</div>
</body>
</html>
