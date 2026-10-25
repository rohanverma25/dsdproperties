<!DOCTYPE html>
<html lang="hi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verification Admin — Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f1f5f9; min-height:100vh; display:flex; align-items:center; justify-content:center; }
.login-card { max-width:400px; width:100%; }
.login-logo span { color:#FF5C00; }
</style>
</head>
<body>
<div class="card shadow-sm login-card">
    <div class="card-body p-4">
        <div class="text-center mb-3">
            <svg width="32" height="32" viewBox="0 0 40 40" fill="none"><rect width="40" height="40" rx="10" fill="#011f4b"/><path d="M10 20 C10 13 30 13 30 20 C30 27 10 27 10 20Z" fill="#008080" opacity=".5"/><circle cx="20" cy="20" r="5" fill="#FF5C00"/></svg>
            <div class="fw-bold login-logo mt-1">DSD <span>Properties</span></div>
        </div>
        <h5 class="text-center fw-bold mb-1">Verification Admin Panel</h5>
        <p class="text-center small text-muted mb-4">संपत्ति सत्यापन रिपोर्ट प्रबंधन</p>

        @if($errors->any())
        <div class="alert alert-danger small">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('ver.admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label small text-uppercase text-muted">Admin Password</label>
                <input type="password" name="password" class="form-control" autofocus placeholder="Enter admin password">
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background:#011f4b;border-color:#011f4b;">Login &rarr;</button>
        </form>
    </div>
</div>
</body>
</html>
