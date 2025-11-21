@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp

<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Delulu' : 'Delulu' }}</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>

    <!-- Top page header -->
    <!-- <nav class="flex items-center justify-between px-6 py-4 bg-gray-800 text-white">-->
    <nav class="flex items-center justify-between px-6 py-4 bg-primary text-white border-background border-3" >
        
         <!-- Left part -->
        <div class="flex items-center space-x-4">
            <div class="text-center font-semibold px-10 py-4 text-4xl tracking-wide text-white bg-primary">
                DELULU
            </div>
            <span class="inline-block w-[2px] h-10 bg-white mx-3"></span>

            <a href="/home" class="px-5 text-xl">Home</a>

            <a href="{{ route('activities.index') }} " class="px-2 text-xl">Activities</a>
            @can('viewAny', Activity::class)
            @endcan

            <a href="{{ route('steps.index') }}" class="px-2 text-xl">Steps</a>
            @can('viewAny', Step::class)
            @endcan

            <a href="{{ route('campaigns.index') }}" class="px-2 text-xl">Campaigns</a>
            @can('viewAny', Campaign::class)
            @endcan

            <a href="{{ route('themes.index') }}" class="px-2 text-xl">Themes</a>
            @can('viewAny', Theme::class)
             @endcan

        </div>
        

        <!-- Right part -->
        <div class="flex items-center space-x-4">
            @if(Auth::check())
                <span>{{ Auth::user()->username }}</span>
            @else
                <span>Nejste přihlášen</span>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                @csrf
                <button type="submit" class="px-3 py-1 bg-white text-primary font-semibold rounded hover:bg-gray-200">
                    Logout
                </button>
            </form>
        </div>
    </nav>
   
    <!-- Page body-->
    <div class="flex min-h-screen">
        <!-- Side bar -->
        <div class="flex flex-col w-64 min-w-64 bg-background-darker">
            <div class="font-semibold text-2xl px-5 py-4 text-white">
                Your Campaigns
            </div>
            <hr class="border-background border-t-3">

            <!-- List element-->
            @foreach($userCampaigns as $campaign)
                <x-sidebarItem :campaign="$campaign" />
            @endforeach
        </div>

        <!-- Page content -->
        {{ $slot }}
        @if(session('success'))
            <span>{{ session('success') }}</span>
        @endif
    </div>

    
</body>
</html>
