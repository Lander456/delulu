<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <form method="POST" action="/register">
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

        <input type="email"
               name="email"
               placeholder="Maidenless@mail.com"
               value="{{ old('email') }}"
               class="input @error('email') input-error @enderror"
               required>
        <span>Email</span><br>
        @error('email')
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
        <input type="password"
               name="password_confirmation"
               placeholder="********"
               class="input @error('password_confirmation') input-error @enderror"
               required>
        <span>Password Confirmation</span>
        @error('password_confirmation')
            <span class="text-error">{{ $message }}</span>
        @enderror

        <button type="submit" class="btn">
            Register
        </button>
    </form>

    <p class="text-center text-sm">
        Already a seasoned gaslighter?
        <a href="/login" class="link link-primary">Sign In</a>
    </p>
</body>
</html>
