
@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
    use App\Enums\RolesEnum;

@endphp
<x-layout>
    <x-slot:title>{{ $user->username }}</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Step Detail -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    User Overview
                </div>
                <div class="flex flex-row gap-4">
                    <!-- Edit Button -->
                    @can('update', $user)
                        <div class="flex flex-col items-center text-black justify-center">
                            <a href="{{ route('users.edit', $user) }}" 
                            class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                Edit
                            </a>
                        </div>
                    @endcan
                    <!-- Delete Button -->
                    @can('update', $user)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this user?')">
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
            <div class="flex font-semibold text-2xl px-5 text-black mb-6">
                {{ $user->username }}
            </div>
            <!-- Role-->
            <div class="flex font-semibold text-md px-5 text-black ">
                Role: <span class="flex font-normal text-md px-5 text-black ">{{ $user->role }}</span>
            </div>
            <!-- Email-->
            <div class="flex font-semibold text-md px-5 text-black mb-10">
                Email: <span class="flex font-normal text-md px-5 text-black ">{{ $user->email }}</span>
            </div>

            @if( $user->id != auth()->user()->id &&  
                    (auth()->user()->hasRole(RolesEnum::SYSADMIN->value) 
                    || auth()->user()->hasRole(RolesEnum::ADMIN->value) ))
            <label class="font-semibold text-lg px-5 mb-2">Change role:</label>
            <div class="px-5 mb-4">
                <form action="{{ route('users.assignRole', $user) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <select name="role" class="w-1/4 w-min-64 px-4 py-2 bg-background border-background-darker rounded border-2">
                        @foreach(RolesEnum::cases() as $role)
                            @if(auth()->user()->hasRole(RolesEnum::ADMIN->value) && $role->value == RolesEnum::SYSADMIN->value)
                                @continue
                            @endif
                            <option value="{{ $role->value }}"
                                @if($user->hasRole($role->value)) selected @endif>
                                {{ $role->value}}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-primary text-white px-3 py-1 rounded hover:bg-primary-highlight cursor-pointer">
                        Change role
                    </button>
                </form>
            </div>
            @endif


            @if($user->getCampaigns()->isNotEmpty())
            <!-- Campaing table-->
            <div class="flex font-semibold text-lg px-5 text-black mb-4">
                In Campaigns:
            </div>
            <div class="flex px-5 mb-4 max-w-300">
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
                        @foreach($user->getCampaigns() as $campaign)
                        @can('view',  $campaign)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('campaigns.show', $campaign) }}" 
                                class="font-semibold py-1 hover:underline text-primary">
                                    {{ $campaign->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                @can('view', $user)
                                <a href="{{ route('users.show', $user) }}" 
                                class="font-semibold text-primary py-1 hover:underline hover:text-primary-highlight">
                                    {{ $campaign->user->username }}
                                </a>
                                @else
                                <span class="font-semibold text-black py-1">{{ $campaign->user->username }}</span>
                                @endcan
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
            </div>
            @endif

           @if($user->steps->isNotEmpty())
            <!-- Campaing table-->
            <div class="flex font-semibold text-lg px-5 text-black mb-4">
                Coordinates Steps:
            </div>
            <div class="flex px-5 mb-4 max-w-300">
                <table class="w-full border  border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-5/10 text-left border border-background-darker p-2 font-semibold">Cordinator</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($user->steps as $step)
                        @can('view',  $step)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                <a href="{{ route('steps.show', $step) }}" 
                                class="font-semibold py-1 hover:underline text-primary">
                                    {{ $step->name }}
                                </a>
                            </td>
                            <td class="p-2 border border-background-dark">
                                @can('view', $user)
                                <a href="{{ route('users.show', $user) }}" 
                                class="font-semibold text-primary py-1 hover:underline hover:text-primary-highlight">
                                    {{ $step->user->username }}
                                </a>
                                @else
                                <span class="font-semibold text-black py-1">{{ $step->user->username }}</span>
                                @endcan
                            </td>
                            <td class="p-2 border border-background-dark">
                                {{ $step->created_at->format('Y-m-d')}}
                            </td>
                            <td class="p-2 border border-background-dark text-center">
                                {{ $step->getSuccessRateAttribute()}}%
                            </td>
                        </tr>
                        @endcan
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            
            @if($user->activities->isNotEmpty())
            <!-- Assigned to Activities table-->
            <div class="flex font-semibold text-lg px-5 text-black mb-4">
                Assigned to Activities:
            </div>
            <div class="flex px-5 mb-4 max-w-300">
                <table class="w-full border  border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-5/10 text-left border border-background-darker p-2 font-semibold">Description</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Started</th>
                            <th class="w-1/10 text-left border border-background-darker p-2 font-semibold">Success rate</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($user->activities as $activity)
                        @can('view',  $campaign)
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
            </div>
            @endif

            
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>

