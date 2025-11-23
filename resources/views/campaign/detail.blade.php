<x-layout>
    <x-slot:title>{{ $campaign->name }}</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Campaign Detail -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    Campaign Overview
                </div>
                <div class="flex flex-row gap-4">
                    <!-- Edit Button -->
                    @can('update', $campaign)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <a href="{{ route('campaigns.edit', $campaign) }}" 
                            class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                Edit
                            </a>
                        </div>
                    @endcan
                    <!-- Delete Button -->
                    @can('update', $campaign)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this campaign?')">
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
                {{ $campaign->name }}
            </div>
            <div class="flex px-5 py-4 text-black mb-2">
                {{ $campaign->description }}
            </div>
            <!-- Assigned Coordinator-->
            <div>
                <label class="font-semibold text-lg px-5 py-4s">Assigned Coordinator:</label>
                <div class="px-5 py-4s mb-4">
                    {{ $campaign->user->username }}
                </div>
            </div>

            <!-- Steps table-->
            <div class="flex font-semibold text-lg px-5 text-black mb-4">
                Steps:
            </div>
            <div class="flex w-full px-5 mb-4 overflow-x-auto">
                @if($campaign->steps->isNotEmpty())
                <table class="min-w-full border  border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-2/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-2/10 text-left border border-background-darker p-2 font-semibold">Administrator</th>
                            <th class="w-4/10 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaign->steps as $step)
                        @can('view', arguments: $step)
                        <tr class="
                            {{ $step->order < optional($campaign->currentStep)->order ? 'bg-background-dark text-background-darker' : '' }}
                            {{ $step->order === optional($campaign->currentStep)->order ? 'bg-primary-highlight text-white' : '' }}
                        ">
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('steps.show', $step) }}" 
                                class="font-semibold py-1 hover:underline ">
                                    {{ $step->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $step->user->username}}
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-xs">
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
            <div class="flex justify-between w-full px-5 mb-4">
                <div>
                    <span class="font-semibold text-lg py-4">Current step:</span >
                        <div class="py-4 mb-4 inline">
                            @if($campaign->currentStep)
                                {{ $campaign->currentStep->name }}
                            @else
                                No current step
                            @endif
                        </div>
                </div>
                <form action="{{ route('steps.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="name" value="New Step">
                    <input type="hidden" name="description" value="No description">
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                    <button type="submit" class="bg-primary hover:bg-primary-highlight text-white px-2 py-1 rounded cursor-pointer">
                        Add Step
                    </button>
                </form>
            </div>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>
