@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp
<x-layout>
    <x-slot:title>{{ $step->name }}</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Step Detail -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    Step Overview
                </div>
                <div class="flex flex-row gap-4">
                    <!-- Edit Button -->
                    @can('update', $step)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <a href="{{ route('steps.edit', $step) }}" 
                            class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                Edit
                            </a>
                        </div>
                    @endcan
                    <!-- Delete Button -->
                    @can('update', $step)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('steps.destroy', $step) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this step?')">
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
                {{ $step->name }}
            </div>
            <div class="flex px-5 py-4 text-black mb-2">
                {{ $step->description }}
            </div>
            <!-- Campaign  -->
            <label class="font-semibold text-lg px-5 mb-2">From Campaign:</label>
            <div class="px-5 mb-4">
                <a href="{{ route('campaigns.show', $step->campaign) }}" 
                    class="font-semibold py-1 hover:underline text-primary">
                    {{ $step->campaign->name }}
                 </a>
            </div> 

            <!-- Assigned Coordinator-->
            <div>
                <label class="font-semibold text-lg px-5 py-4s">Assigned Coordinator:</label>
                <div class="px-5 py-4s mb-4">
                    {{ $step->user->username }}
                </div>
            </div>
            <!-- Success rate-->
            <div>
                <label class="font-semibold text-lg px-5 py-4s">Success rate:</label>
                <div class="px-5 py-4s mb-4 text-blacks">
                    {{ $step->getSuccessRateAttribute()}}%
                </div>
            </div>

            <!-- Activities table-->
            <div class="flex font-semibold text-lg px-5  text-black mb-4">
                Activities: 
            </div>
            <div class="flex w-full px-5 mb-4 overflow-x-autos">
                @if($step->activities->isNotEmpty())
                <table class="min-w-full border  border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-5/10 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($step->activities as $activity)
                        @can('view', arguments: $activity)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('activities.show', $activity) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $activity->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $activity->description}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $activity->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $activity->getSuccessRateAttribute()}}%
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
            @can('create', Activity::class)
            <div class="flex justify-between w-full px-5 mb-4">
                <div>
                </div>
                <form action="{{ route('activities.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="New Activity">
                    <input type="hidden" name="description" value="No description">
                    <input type="hidden" name="step" value="{{ $step->id }}">
                    <button type="submit" class="bg-primary hover:bg-primary-highlight text-white px-2 py-1 rounded cursor-pointer">
                        Add Activity
                    </button>
                </form>
            </div>
            @endcan
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>

