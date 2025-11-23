@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp

<x-layout>
    <x-slot:title>Activities</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Steps -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    All Activities
                </div>
                <!-- Right Button -->
                @can('create', Activity::class)
                    <div class="flex flex-col  items-center w-32 text-black justify-center">
                        <a href="{{ route('activities.create') }}"
                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                            Create New
                        </a>
                    </div>
                @endcan
            </div>
           <hr class="border-background-darker border-t-2 mb-4">

            <!-- Active Steps table-->
            <div class="flex font-semibold text-2xl px-5 text-black mb-4">
                Ongoing Activities
            </div>
            <div class="flex w-full px-5 mb-8 overflow-x-autos">
                @if($ongoingActivities->isNotEmpty())
                <table class="min-w-full border border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-2/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-2/10 text-left border border-background-darker p-2 font-semibold">From Step</th>
                            <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                            @can('create', Activity::class)
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Mark Complete</th>
                            @endcan

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ongoingActivities as $activity)
                        @can('view', $activity)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('activities.show', $activity) }}"
                                class="font-semibold py-1 hover:underline ">
                                    {{ $activity->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                @can('view', $activity->step)
                                <a href="{{ route('steps.show', $activity->step) }}"
                                class="font-semibold py-1 hover:underline ">
                                    {{ $activity->step->name }}
                                </a>
                                @else
                                {{ $activity->step->name }}
                                @endcan
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $activity->description}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $activity->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $activity->getSuccessRateAttribute() }}%
                            </td>
                            @can('update', $activity)
                            <td class="p-2 border font-bold text-primary border-background-dark text-center">
                                <form action="{{ route('activities.complete', $activity) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="completed" value="1">
                                    <button type="submit"
                                            class=" text-center text-primary hover:text-primary-highlight font-bold cursor-pointer">
                                        Complete
                                    </button>
                                </form>
                            </td>
                            @endcan
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

            <!-- Completed Activities table-->
            <div class="flex font-semibold text-2xl px-5 text-black mb-4">
                Completed Activities
            </div>
            <div class="flex w-full px-5 mb-8 overflow-x-autos">
                @if($completedActivities->isNotEmpty())
                <table class="min-w-full border border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-2/12 text-left border border-background-darker p-2 font-semibold">From Step</th>
                            <th class="w-4/12 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/12 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedActivities as $activity)
                        @can('view', arguments: $activity)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('activities.show', $activity) }}"
                                class="font-semibold py-1 hover:underline ">
                                    {{ $activity->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('steps.show', $activity->step) }}"
                                class="font-semibold py-1 hover:underline ">
                                    {{ $activity->step->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $activity->description}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $activity->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $activity    ->getSuccessRateAttribute() }}%
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

