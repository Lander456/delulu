@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp
<x-slot:title>{{ $theme->name }}</x-slot:title>
<x-layout>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Theme Detail -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    Theme Overview
                </div>
                <div class="flex flex-row gap-4">
                    <!-- Edit Button -->
                    @can('update', $theme)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <a href="{{ route('themes.edit', $theme) }}" 
                            class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                Edit
                            </a>
                        </div>
                    @endcan
                    <!-- Delete Button -->
                    @can('update', $theme)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('themes.destroy', $theme) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this theme?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
            <hr class="border-background-darker border-t-2 mb-6">
            <div class="flex font-semibold text-2xl px-5 text-black">
                {{ $theme->name }}
            </div>
            <div class="flex px-5 py-4 text-black mb-2">
                {{ $theme->description }}
            </div>
            <!-- Assigned Coordinator-->
            <div>
                <label class="font-semibold text-lg px-5 py-4s">Assigned Coordinator:</label>
                <div class="px-5 py-4s mb-4">
                    {{ $theme->user->username }}
                </div>
            </div>

            <!-- Campaing table-->
            <div class="flex font-semibold text-lg px-5 text-black mb-4">
                Campaigns:
            </div>
            <div class="flex px-5 mb-4 max-w-300">
                @if($theme->campaigns->isNotEmpty())
                <table class="w-full border  border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-5/10 text-left border border-background-darker p-2 font-semibold">Administrator</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($theme->campaigns as $campaign)
                        @can('view',  $campaign)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('campaigns.show', $campaign) }}" 
                                class="font-semibold py-1 hover:underline text-primary">
                                    {{ $campaign->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $campaign->user->username}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $campaign->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $campaign->getSuccessRateAttribute()*100 }}%
                            </td>
                        </tr>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-background-darker">
                    none
                </div>
                @endif
            </div>
            @can('create', Campaign::class)
            <div class="flex justify-between w-full px-5 mb-4">
                <div>
                </div>
                <form action="{{ route('campaigns.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="New Campaign">
                    <input type="hidden" name="description" value="No description">
                    <input type="hidden" name="theme_id" value="{{ $theme->id }}">
                    <input type="hidden" name="user_id" value="{{ $theme->user->id }}">
                    <button type="submit" class="bg-primary hover:bg-primary-highlight text-white px-2 py-1 rounded cursor-pointer">
                        Add Campaign
                    </button>
                </form>
            </div>
            @endcan


            <!-- Areas of interest -->
            <div x-data="{ open: false }" class="px-5 mb-4">
                <div class="flex font-semibold text-lg mb-2 text-black">
                    Areas of interest:
                </div>
                <div class="flex mb-4 max-w-300">
                    @if($theme->areasOfInterest->isNotEmpty())
                    <table class="w-full border  border-background-darker border-t-2">
                        <thead class="bg-background-dark">
                            <tr class="border border-background-darker border-t-2 ">
                                <th class="text-left border border-background-darker p-2 font-semibold">Name</th>
                                <th class="w-1/10 text-left border border-background-darker p-2 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($theme->areasOfInterest as $area)
                            @can('view', arguments: $area)
                            <tr>
                                <td class="p-2 border border-background-dark">
                                    <a href="{{ route('areasOfInterest.show', $area) }}" 
                                    class="font-semibold py-1 hover:underline text-primary">
                                        {{ $area->name }}
                                    </a>
                                </td>
                                <td class="p-2 border font-bold text-primary border-background-dark text-center">
                                    <form action="{{ route('themes.unassignAreaOfInterest', ['theme' => $theme->id, 'areaOfInterest' => $area->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="areasOfInterest[]" value="{{ $area->id}}">
                                        <button type="submit"
                                                class=" text-center text-primary hover:text-primary-highlight font-bold cursor-pointer">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endcan
                            @endforeach
                        </tbody>
                    </table>
                    @else   
                    <div class="text-background-darker">
                        none
                    </div>
                    @endif
                </div>

                <!-- Add Areas of interest -->
      
                <button @click="open = !open" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                    Add Interests
                </button>

                <div x-show="open" x-transition class="mt-4 mb-4">
                    @if($areasOfInterest->isNotEmpty())
                    <form action="{{ route('themes.assignAreasOfInterest', $theme) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <table class="border w-full max-w-96 border-background-darker border-t-2 mb-4">
                            <thead class="bg-background-dark">
                                <tr class="border border-background-darker border-t-2">
                                    <th class="text-left p-2 border border-background-darker">Name</th>
                                    <th class="w-12"></th>
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach($areasOfInterest as $interest)
                                    <tr class="p-2 border border-background-dark">
                                        <td class="p-2">{{ $interest->name }}</td>
                                        <td class="p-2 flex justify-center">
                                            <input type="checkbox" class="w-4 h-4" name="areasOfInterest[]" value="{{ $interest->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="flex gap-2">
                            <button type="button" @click="open = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">Confirm Selection</button>
                        </div>
                    </form>
                    @else
                        <div x-show="open" class="text-background-darker mb-4">
                            none to add
                        </div>
                    @endif
                </div>
            </div>

             <!-- Target demographics -->
            <div x-data="{ open: false }" class="px-5 mb-4">
                <div class="flex font-semibold text-lg mb-2 text-black">
                    Target demographics:
                </div>
                <div class="flex mb-4 max-w-300">
                    @if($theme->targetDemographics->isNotEmpty())
                    <table class="w-full border  border-background-darker border-t-2">
                        <thead class="bg-background-dark">
                            <tr class="border border-background-darker border-t-2 ">
                                <th class="text-left border border-background-darker p-2 font-semibold">Name</th>
                                <th class="w-1/10 text-left border border-background-darker p-2 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($theme->targetDemographics as $demo)
                            @can('view', arguments: $demo)
                            <tr>
                                <td class="p-2 border border-background-dark">
                                    <a href="{{ route('targetDemographics.show', $demo) }}" 
                                    class="font-semibold py-1 hover:underline text-primary">
                                        {{ $demo->name }}
                                    </a>
                                </td>
                                <td class="p-2 border font-bold text-primary border-background-dark text-center">
                                    <form action="{{ route('themes.unassignTargetDemographic', ['theme' => $theme->id, 'targetDemographic' => $demo->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="targetDemographics[]" value="{{ $demo->id}}">
                                        <button type="submit"
                                                class=" text-center text-primary hover:text-primary-highlight font-bold cursor-pointer">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endcan
                            @endforeach
                        </tbody>
                    </table>
                    @else   
                    <div class="text-background-darker">
                        none
                    </div>
                    @endif
                </div>
                <!-- Add Target demographics -->
      
                <button @click="open = !open" type="button" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                    Add Demographics
                </button>

                <div x-show="open" x-transition class="mt-4 mb-4">
                    @if($targetDemographics->isNotEmpty())
                    <form action="{{ route('themes.assignTargetDemographics', $theme) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <table class="border w-full max-w-96 border-background-darker border-t-2 mb-4">
                            <thead class="bg-background-dark">
                                <tr class="border border-background-darker border-t-2">
                                    <th class="text-left p-2 border border-background-darker">Name</th>
                                    <th class="w-12"></th>
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach($targetDemographics as $demo)
                                    <tr class="p-2 border border-background-dark">
                                        <td class="p-2">{{ $demo->name }}</td>
                                        <td class="p-2 flex justify-center">
                                            <input type="checkbox" class="w-4 h-4" name="targetDemographics[]" value="{{ $demo->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="flex gap-2">
                            <button type="button" @click="open = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">Confirm Selection</button>
                        </div>
                    </form>
                    @else
                        <div x-show="open" class="text-background-darker mb-4">
                            none to add
                        </div>
                    @endif
                </div>
            </div>

            
            <!-- Information Sources -->
            <div x-data="{ open: false }" class="px-5 mb-4">
                <div class="flex font-semibold text-lg mb-2 text-black">
                    Information Sources:
                </div>
                <div class="flex mb-4 max-w-300">
                    @if($theme->informationSources->isNotEmpty())
                    <table class="w-full border  border-background-darker border-t-2">
                        <thead class="bg-background-dark">
                            <tr class="border border-background-darker border-t-2 ">
                                <th class="text-left border border-background-darker p-2 font-semibold">Name</th>
                                <th class="w-1/10 text-left border border-background-darker p-2 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($theme->informationSources as $source)
                            @can('view', arguments: $source)
                            <tr>
                                <td class="p-2 border border-background-dark">
                                    <a href="{{ route('informationSources.show', $source) }}" 
                                    class="font-semibold py-1 hover:underline text-primary">
                                        {{ $source->name }}
                                    </a>
                                </td>
                                <td class="p-2 border font-bold text-primary border-background-dark text-center">
                                    <form action="{{ route('themes.unassignInformationSource', ['theme' => $theme->id, 'informationSource' => $source->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="informationSources[]" value="{{ $source->id}}">
                                        <button type="submit"
                                                class=" text-center text-primary hover:text-primary-highlight font-bold cursor-pointer">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endcan
                            @endforeach
                        </tbody>
                    </table>
                    @else   
                    <div class="text-background-darker">
                        none
                    </div>
                    @endif
                </div>
                <!-- Add Information Sources -->
      
                <button @click="open = !open" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                    Add Sources
                </button>

                <div x-show="open" x-transition class="mt-4 mb-4">
                    @if($informationSources->isNotEmpty())
                    <form action="{{ route('themes.assignInformationSources', $theme) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <table class="border w-full max-w-96 border-background-darker border-t-2 mb-4">
                            <thead class="bg-background-dark">
                                <tr class="border border-background-darker border-t-2">
                                    <th class="text-left p-2 border border-background-darker">Name</th>
                                    <th class="w-12"></th>
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach($informationSources as $source)
                                    <tr class="p-2 border border-background-dark">
                                        <td class="p-2">{{ $source->name }}</td>
                                        <td class="p-2 flex justify-center">
                                            <input type="checkbox" class="w-4 h-4" name="informationSources[]" value="{{ $source->id }}">
                                        </td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                        <div class="flex gap-2">
                            <button type="button" @click="open = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">Confirm Selection</button>
                        </div>
                    </form>
                    @else
                        <div x-show="open" class="text-background-darker mb-4">
                            none to add
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>