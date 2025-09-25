<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Delulu' : 'Delulu' }}</title>
</head>
<body>
    <nav class="navbar">
        <a href="/home">Delulu</a>
        <div>
            <span class="text-sm">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="btn">Logout</button>
            </form>
        </div>
    </nav>
@if(session('success'))
    <span>{{ session('success') }}</span>
@endif
</body>
</html>
