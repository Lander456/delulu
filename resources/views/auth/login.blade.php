<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<form method="POST" action="/login">
    @csrf

    <input type="text"
           name="username"
           placeholder="MaidenlessBith"
           value="{{ old('name') }}"
           class="input @error('username') input-error @enderror"
           required>
    <span>Username</span><br>
    @error('username')
    <span class="text-error">{{ $message }}</span>
    @enderror

    <input type="password"
           name="password"
           placeholder="********"
           class="input @error('password') input-error @enderror"
           required>
    <span>Password</span><br>
    @error('password')
        <span class="text-error">{{ $message }}</span>
    @enderror

    <button type="submit" class="btn">
        Login
    </button>
</form>

<p class="text-center text-sm">
    Don't have an account yet?
    <a href="/register" class="link link-primary">Sign Up</a>
</p>
</body>
</html>

