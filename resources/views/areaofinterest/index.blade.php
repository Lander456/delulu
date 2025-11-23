@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
    use App\Models\AreaOfInterest;
@endphp

<x-layout>
    <x-slot:title>Areas of Interest</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Assigned activities -->
        <div class = "flex flex-col min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    Areas of Interest
                </div>
                <!-- Right Button -->
                @can('create', AreaOfInterest::class)
                    <div class="flex flex-col  items-center w-32 text-black justify-center">
                        <a href="{{ route('areasOfInterest.create') }}" 
                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                            Create New
                        </a>
                    </div>
                @endcan
            </div>
           <hr class="border-background-darker border-t-2">
            <!-- Item grid-->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 px-2 py-4">
                @if($areas->isNotEmpty())
                    @foreach($areas as $area)
                    @can('view', $area)
                        <a href="{{ route('areasOfInterest.show', $area) }}" 
                            class="h-48 overflow-hidden bg-white hover:bg-background rounded-2xl p-4 border-background-darker border-2">
                            <div class="flex font-semibold text-lg ">
                                {{ $area->name }}
                            </div>
                            <div class="flex text-xsm ">
                                {{ $area->description }}
                            </div>
                        </a>
                    @endcan
                    @endforeach
                @endif
                
                
            </div>
        </div>
    </div>
</x-layout>
