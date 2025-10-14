<!DOCTYPE html>
@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Delulu' : 'Delulu' }}</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>
    <nav class="navbar">
        <a href="/home">Delulu</a>
        @can('viewAny', Activity::class)
            <a href="{{ route('activities.index') }}">Activities</a>
        @endcan
        @can('viewAny', Step::class)
            <a href="{{ route('steps.index') }}">Steps</a>
        @endcan
        @can('viewAny', Campaign::class)
            <a href="{{ route('campaigns.index') }}">Campaigns</a>
        @endcan
        @can('viewAny', Theme::class)
            <a href="{{ route('themes.index') }}">Themes</a>
        @endcan
        <div class="text-right">
            <span class="text-sm">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Logout</button>
            </form>
        </div>
    </nav>

    {{ $slot }}

@if(session('success'))
    <span>{{ session('success') }}</span>
@endif
</body>
</html>
