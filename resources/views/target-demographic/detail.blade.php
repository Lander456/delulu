@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
    use App\Models\TargetDemographic;
@endphp
<x-slot:title>{{ $targetDemographic->name }}</x-slot:title>
<x-layout>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Theme Detail -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    Target Demographics Overview
                </div>
                <div class="flex flex-row gap-4">
                    <!-- Edit Button -->
                    @can('update', $targetDemographic)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <a href="{{ route('targetDemographics.edit', $targetDemographic) }}" 
                            class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                Edit
                            </a>
                        </div>
                    @endcan
                    <!-- Delete Button -->
                    @can('update', $targetDemographic)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('targetDemographics.destroy', $targetDemographic) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this Target Demographic?')">
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
                {{ $targetDemographic->name }}
            </div>
            <div class="flex px-5 py-4 text-black mb-4">
                {{ $targetDemographic->description }}
            </div>

            <!-- Amount-->
            <div class="flex font-semibold text-md px-5 text-black">
                Amount: <span class="flex font-normal text-md px-5 text-black ">{{ $targetDemographic->amount }}</span>
            </div>

            <!-- Difficulty-->
            <div class="flex font-semibold text-md px-5 text-black">
                Difficulty: <span class="flex font-normal text-md px-5 text-black">{{ $targetDemographic->difficulty }}</span>
            </div>
            
            <!-- Ethics-->
            <div class="flex font-semibold text-md px-5 text-black mb-4">
                Ethics: <span class="flex font-normal text-md px-5 text-black">{{ $targetDemographic->ethics }}</span>
            </div>

            @can('viewAny', Theme::class)
            <!-- Themes table-->
            <div class="flex font-semibold text-lg px-5 text-black mb-4">
                Themes:
            </div>
            <div class="flex px-5 mb-4 max-w-300 w-2/3">
                @if($targetDemographic->themes->isNotEmpty())
                <table class="w-full border  border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-5/10 text-left border border-background-darker p-2 font-semibold">Administrator</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($targetDemographic->themes as $theme)
                        @can('view',  $theme)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('themes.show', $theme) }}" 
                                class="font-semibold py-1 hover:underline text-primary">
                                    {{ $theme->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $theme->user->username}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $theme->created_at->format('Y-m-d')}}
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
            @endcan

            <!-- Areas of Interest -->
            <div x-data="{ open: false }" class="px-5 mb-4">
                <div class="flex font-semibold text-lg mb-2 text-black">
                    Areas of Interest:
                </div>
                <div class="flex mb-4 max-w-300">
                    @if($targetDemographic->areasOfInterest->isNotEmpty())
                    <table class="w-full border  border-background-darker border-t-2">
                        <thead class="bg-background-dark">
                            <tr class="border border-background-darker border-t-2 ">
                                <th class="text-left border border-background-darker p-2 font-semibold">Name</th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($targetDemographic->areasOfInterest as $area)
                            @can('view', arguments: $area)
                            <tr>
                                <td class="p-2 border border-background-dark">
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
                    @else   
                    <div class="text-background-darker">
                        none
                    </div>
                    @endif
                </div>

               
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>