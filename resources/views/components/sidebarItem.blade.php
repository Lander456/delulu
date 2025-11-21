@php
    use App\Models\Step;
    use App\Models\Campaign;
    $steps = $campaign->steps;
@endphp

<div x-data="{ open: false }" class="flex w-full flex-col">   

    <!-- Campaing item -->
    <div class="flex w-full">

        
        <button @click="open = !open" class="flex justify-between items-center py-2 px-2 w-full hover:bg-primary-highlight">
            <a href="{{ route('campaigns.show', $campaign) }}" class="font-semibold py-1 text-white block  hover:underline">
                {{ $campaign->name }}
            </a>
            <svg :class="{ 'rotate-180': open }" class="w-6 h-6 transform transition-transform" fill="none" stroke="white" >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
    </div>

    <!-- Dropdown menu -->
    <div>

        @if(count($steps))
        
        <div x-show="open" x-transition class="mt-1 space-y-1">
            
            
            @foreach($steps as $step)
            <div class="hover:bg-primary-highlight ">
                <a href="{{ route('steps.show', $step)}}" class="block px-2 py-1 text-sm ml-4 text-white">
                    {{ $step->name }}
                </a>
            </div>
            @endforeach
        </div>
        @endif
    
    </div>
    
    
    <hr class="border-background border-t-3">
</div>