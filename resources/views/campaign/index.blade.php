@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp

<x-layout>
    <x-slot:title>Campaigns</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Campaigns -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    All Campaigns
                </div>
                <!-- Right Button -->
                @can('create', Theme::class)
                    <div class="flex flex-col  items-center w-32 text-black justify-center">
                        <a href="{{ route('campaigns.create') }}"
                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                            Create New
                        </a>
                    </div>
                @endcan
            </div>
           <hr class="border-background-darker border-t-2 mb-4">

            <!-- Campaigns table-->
            <div class="flex w-full px-5 mb-4 overflow-x-autos">
                @if($campaigns->isNotEmpty())
                <table class="min-w-full border border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-2/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Coordinator</th>
                            <th class="w-4/10 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $campaign)
                        @can('view', $campaign)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('campaigns.show', $campaign) }}"
                                class="font-semibold py-1 hover:underline ">
                                    {{ $campaign->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $campaign->user->username}}
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $campaign->description}}
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $campaign->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $campaign->getSuccessRateAttribute()}}%
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
