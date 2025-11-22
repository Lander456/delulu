@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp
<x-slot:title>{{ $theme->name }}</x-slot:title>
<x-layout>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Assigned activities -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    Theme Overview
                </div>
                <!-- Right Button -->
                @can('update', $theme)
                    <div class="flex flex-col  items-center w-32 text-black justify-center">
                        <a href="{{ route('themes.edit', $theme) }}" 
                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                            Edit
                        </a>
                    </div>
                @endcan
            </div>
           <hr class="border-background-darker border-t-2 mb-6">
            <div class="flex font-semibold text-2xl px-5 text-black">
                {{ $theme->name }}
            </div>
            <div class="flex px-5 py-4 text-black mb-2">
                {{ $theme->description }}
            </div>
            <div>
            <!-- Assigned Coordinator-->
            <label class="font-semibold text-lg px-5 py-4s">Assigned Coordinator:</label>
            <div class="px-5 py-4s mb-4">
                {{ $theme->user->username }}</div>
            </div>

            <!-- Campaing table-->
            <div class="flex font-semibold text-lg px-5 mb-2 text-black">
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
                        @can('view', arguments: $campaign)
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
                            <td class="p-2 border border-background-dark">
                                {{ $campaign->getSuccessRateAttribute() }}
                            </td>
                        </tr>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>


            <!-- Areas of interest -->
            <div class="flex font-semibold text-lg px-5 mb-2 text-black">
                Areas of interest:
            </div>
            <div class="flex px-5 mb-4 max-w-300">
                @if($theme->areasOfInterest->isNotEmpty())
                <table class="w-full border  border-background-darker border-t-2">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2 ">
                            <th class="text-left p-2 font-semibold">Name</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($theme->areasOfInterest as $area)
                        @can('view', arguments: $area)
                        <tr>
                            <td class="p-2 border border-background-darker">
                                <a href="{{ route('areasOfInterest.show', $area) }}" 
                                class="font-semibold py-1 hover:underline text-primary">
                                    {{ $area->name }}
                                </a>
                            </td>
                        </tr>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- Target demographics -->
            <div class="flex font-semibold text-lg px-5 mb-2 text-black">
                Target demographics:
            </div>
            <div class="flex px-5 mb-4 max-w-300">
                @if($theme->targetDemographics->isNotEmpty())
                <table class="w-full border  border-background-darker border-t-2">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2 ">
                            <th class="text-left p-2 font-semibold">Name</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($theme->targetDemographics as $demo)
                        @can('view', arguments: $demo)
                        <tr>
                            <td class="p-2 border border-background-darker">
                                <a href="{{ route('targetDemographics.show', $demo) }}" 
                                class="font-semibold py-1 hover:underline text-primary">
                                    {{ $demo->name }}
                                </a>
                            </td>
                        </tr>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- Information Sources -->
            <div class="flex font-semibold text-lg px-5 mb-2 text-black">
                Information Sources:
            </div>
            <div class="flex px-5 mb-4 max-w-300">
                @if($theme->informationSources->isNotEmpty())
                <table class="w-full border  border-background-darker border-t-2">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2 ">
                            <th class="text-left p-2 font-semibold">Name</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($theme->informationSources as $source)
                        @can('view', arguments: $source)
                        <tr>
                            <td class="p-2 border border-background-darker">
                                <a href="{{ route('informationSources.show', $source) }}" 
                                class="font-semibold py-1 hover:underline text-primary">
                                    {{ $source->name }}
                                </a>
                            </td>
                        </tr>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>