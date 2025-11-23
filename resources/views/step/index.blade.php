@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp

<x-layout>
    <x-slot:title>Steps</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Steps -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    All Steps
                </div>
                <!-- Right Button -->
                @can('create', Step::class)
                    <div class="flex flex-col  items-center w-32 text-black justify-center">
                        <a href="{{ route('steps.create') }}" 
                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                            Create New
                        </a>
                    </div>
                @endcan
            </div>
           <hr class="border-background-darker border-t-2 mb-4">

            <!-- Active Steps table-->
            <div class="flex font-semibold text-2xl px-5 text-black mb-4">
                Active Steps
            </div>  
            <div class="flex w-full px-5 mb-8 overflow-x-autos">
                @if($activeSteps->isNotEmpty())
                <table class="min-w-full border border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">From Campaign</th>
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">Coordinator</th>
                            <th class="w-4/12 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeSteps as $step)
                        @can('view', arguments: $step)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('steps.show', $step) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $step->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('campaigns.show', $step->campaign) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $step->campaign->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $step->user->username}}
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $step->description}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $step->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $step->getSuccessRateAttribute()*100 }}%
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

            <!-- Planned Steps table-->
            <div class="flex font-semibold text-2xl px-5 text-black mb-4">
                Planned Steps
            </div>
            <div class="flex w-full px-5 mb-8 overflow-x-autos">
                @if($plannedSteps->isNotEmpty())
                <table class="min-w-full border border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">From Campaign</th>
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">Coordinator</th>
                            <th class="w-4/12 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plannedSteps as $step)
                        @can('view', arguments: $step)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('steps.show', $step) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $step->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('campaigns.show', $step->campaign) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $step->campaign->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $step->user->username}}
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $step->description}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $step->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $step->getSuccessRateAttribute()*100 }}%
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

            <!-- Completed Steps table-->
            <div class="flex font-semibold text-2xl px-5 text-black mb-4">
                Completed Steps
            </div>
            <div class="flex w-full px-5 mb-8 overflow-x-autos">
                @if($completedSteps->isNotEmpty())
                <table class="min-w-full border border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">From Campaign</th>
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">Coordinator</th>
                            <th class="w-4/12 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedSteps as $step)
                        @can('view', arguments: $step)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('steps.show', $step) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $step->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('steps.show', $step) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $step->campaign->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $step->user->username}}
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $step->description}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $step->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $step->getSuccessRateAttribute()*100 }}%
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
        </div>
    </div>
</x-layout>
