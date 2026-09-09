<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Penting -->
    <title>Login</title>
    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet" />
</head>
<body class="bg-gradient-primary">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-6 col-lg-5"> <!-- Tambahkan col-12 & col-sm-10 agar lebih fleksibel -->
            <div class="card shadow">
                <div class="card-header text-center text-primary">
                    <h4 class="my-2">Login Admin</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login.process') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center small text-muted">
                    SMKN 7 Jember
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
