@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp
<x-layout>


    <x-slot:title>
        Home
    </x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Assigned activities -->
        <div class = "flex flex-col flex-[3] min-w-64 px-5 py-4  bg-background">
            <div class="flex font-semibold text-2xl px-5 py-4 text-black">
                My Activities
            </div>
            <hr class="border-background-darker border-t-2">

            <!-- Item grid-->
            <div class="flex flex-col flex-1 gap-2 h-full  px-2 py-4">
                @if($assignedActivities->isNotEmpty())
                    @foreach($assignedActivities as $assignedActivity)
                    @can('view', $assignedActivity)
                        
                        <div class="flex flex-row bg-white px-2 py-2 text-black justify-between rounded border-background-darker border-2">
                            
                            <!-- Item body -->
                            <div class="flex flex-col w-128 min-w-0">
                                <div class="flex ">
                                    <span class="font-semibold text-lg "> 
                                        {{ $assignedActivity->step->campaign->name }} -
                                    </span>
                                    <span class="flex font-semibold text-lg px-2" > 
                                        {{ $assignedActivity->name }} 
                                    </span>
                                </div>
                                <div class="text-sm truncate w-full max-w-lg">
                                    {{ $assignedActivity->description }} 
                                </div>
                            </div>
                            
                            <!-- Right Button -->
                            <div class="flex flex-col  items-center w-32  text-black justify-center">
                                <a href="{{ route('activities.show', $assignedActivity) }}" 
                                class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                    View
                                </a>
                            </div>
                        </div>
                    
                    @endcan
                    @endforeach 
                @endif
            </div>
           

        </div>
        <!-- Active steps-->
        <div class="flex flex-[2] bg-background px-5 py-4 justify-end" >
            <div class="flex flex-col w-94">

                <div class="flex font-semibold text-2xl px-5 py-4 text-black">
                    My Steps
                </div>
                <hr class="border-background-darker border-t-2">
                
                <!-- Item grid-->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-2 py-4">
                    @if($steps->isNotEmpty())
                        @foreach($steps as $step)
                        @can('view', $step)
                            <a href="{{ route('steps.show', $step) }}" 
                               class="h-32 bg-background-dark hover:bg-background-darker rounded-2xl p-4">
                                <div class="flex font-semibold text-lg ">
                                    {{ $step->name }}
                                </div>
                                <div class="flex text-sm text-gray-600">
                                    {{ $step->campaign->name }}
                                </div>
                            </a>
                        @endcan
                        @endforeach
                    @endif
                    
                    
                </div>
            </div> 
        </div>
    </div>
    


</x-layout>
