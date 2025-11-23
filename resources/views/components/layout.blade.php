@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
    use App\Models\User;
    use App\Models\AreaOfInterest;
    use App\Models\TargetDemographic;
    use App\Models\InformationSource;
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
    <nav class="flex items-center justify-between px-6 py-4 bg-primary text-white border-background border-3" >

         <!-- Left part -->
        <div class="flex items-center space-x-4">
            <div class="text-center font-semibold px-8 py-4 text-4xl tracking-wide text-white bg-primary">
                DELULU
            </div>
            <span class="inline-block w-[2px] h-18 bg-white mx-3"></span>

            <a href="/home" class="px-2 text-lg">Home</a>
            
            @can('viewAny', User::class)
            <a href="{{ route('users.index') }} " class="px-2 text-lg">Users</a>
            @endcan

            @can('viewAny', Theme::class)
            <a href="{{ route('themes.index') }}" class="px-2 text-lg">Themes</a>
            @endcan
            
            @can('viewAny', Campaign::class)
            <a href="{{ route('campaigns.index') }}" class="px-2 text-lg">Campaigns</a>
            @endcan
            
            @can('viewAny', Step::class)
            <a href="{{ route('steps.index') }}" class="px-2 text-lg">Steps</a>
            @endcan
            
            @can('viewAny', Activity::class)
            <a href="{{ route('activities.index') }} " class="px-2 text-lg">Activities</a>
            @endcan
            
            @can('viewAny', AreaOfInterest::class)
            <a href="{{ route('areasOfInterest.index') }}" class="px-2 text-lg">Areas of Interest</a>
            @endcan
            @can('viewAny', TargetDemographic::class)
            <a href="{{ route('targetDemographics.index') }}" class="px-2 text-lg">Target demographics</a>
            @endcan
            @can('viewAny', InformationSource::class)
            <a href="{{ route('informationSources.index') }}" class="px-2 text-lg">Information Sources</a>
            @endcan

            

        </div>


        <!-- Right part -->
        <div class="flex items-center space-x-4">
           
            
            @if(Auth::check())
                <a href="{{ route('users.show', auth()->user()) }}" 
                class="font-semibold text-white py-1 hover:underline hover:text-background">
                    {{ auth()->user()->username }}
                </a>
            @else
                <span>Nejste přihlášen</span>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="flex items-center">
                @csrf
                <button type="submit" class="px-3 py-1 bg-white text-primary font-semibold rounded  hover:bg-primary-highlight cursor-pointer">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Page body-->
    <div class="flex min-h-screen h-fill">
        <!-- Side bar -->
        <div class="flex flex-col w-64 min-w-64 bg-background-darker">
            <div class="font-semibold text-2xl px-5 py-4 text-white">
                Your Campaigns
            </div>
            <hr class="border-background border-t-3">

            <!-- List element-->
            @foreach($userCampaigns as $campaign)
                <x-sidebarItem 
                    :campaign="$campaign"/>
            @endforeach
        </div>

        <!-- Page content -->
        <div class="px-5 py-4 flex-1 bg-background">
            {{ $slot }}
        </div>
        @if(session('success'))
            <span>{{ session('success') }}</span>
        @endif
    </div>
    <footer class="flex bg-gray-800 gap-4 text-white p-4 text-center">
        <div class="block ml-auto center-left">
            <div class="block content-center">
                <span>&copy; 2025 Delulu</span><br>
                <span>xtopint00 & xpokorj00 </span>
            </div>
        </div>
        <div class="flex min-w-16">
            <div class="tenor-gif-embed" data-postid="21401933" data-share-method="host" data-aspect-ratio="0.784375" data-width="100%">
                <a href="https://tenor.com/view/vergil-chair-dmc-yamato-gif-21401933">Vergil Chair GIF</a>from 
                <a href="https://tenor.com/search/vergil-gifs">Vergil GIFs</a></div> <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
            </div>
    </footer>
    
</body>
</html>
