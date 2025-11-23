@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;

    $userPivot = optional($activity->users->find(auth()->user()->id))->pivot;
@endphp
<x-slot:title>{{ $activity->name }}</x-slot:title>
<x-layout>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Activity Detail -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    Activity Overview
                </div>
                <div class="flex flex-row gap-4">

                    <!-- Request Button -->
                    @if(!$activity->users->contains(auth()->user()) && ! $activity->activityRequests->contains(fn($ar) => $ar->user_id === auth()->id()))
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('activities.request', $activity) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                    Request to join
                                </button>
                            </form>
                        </div>
                    
                    @elseif($userPivot && $userPivot->completed === null)
                        <!-- Complete button -->
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('activities.mark', $activity) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                    Mark as Successful
                                </button>
                                <input type="hidden" name="completed" value="1">
                            </form>
                        </div>
                        
                        <!-- Failed button -->
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('activities.mark', $activity) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                    Mark as Unsuccessful
                                </button>
                                <input type="hidden" name="completed" value="0">
                            </form>
                        </div>
                    @endif
                    
                    <!-- Edit Button -->
                    @can('update', $activity)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <a href="{{ route('activities.edit', $activity) }}" 
                            class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                Edit
                            </a>
                        </div>
                    @endcan
                    <!-- Delete Button -->
                    @can('update', $activity)
                        <div class="flex flex-col  items-center text-black justify-center">
                            <form action="{{ route('activities.destroy', $activity) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this activity?')">
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
                {{ $activity->name }}
            </div>
            <div class="flex px-5 py-4 text-black mb-2">
                {{ $activity->description }}
            </div>
            <!-- Assigned Coordinator-->
            <div>
                <label class="font-semibold text-lg px-5 py-4s">Assigned Coordinator:</label>
                <div class="px-5 py-4s mb-4">
                    {{ $activity->step->user->username }}
                </div>
            </div>
            @can('view', $activity->step)
            <!-- From step-->
            <div>
                <label class="font-semibold text-lg px-5 py-4s">From Step:</label>
                <div class="px-5 py-4s mb-4">
                    <a href="{{ route('steps.show', $activity->step) }}" 
                        class="font-semibold py-1 hover:underline text-primary">
                            {{ $activity->step->name }}
                     </a>
                    
                </div>
            </div>
            <!-- Success rate-->
            <div>
                <label class="font-semibold text-lg px-5 py-4s">Success rate:</label>
                <div class="px-5 py-4s mb-4 text-blacks">
                    {{ $activity->getSuccessRateAttribute()}}%
                </div>
            </div>
            @endcan
            @can('update', $activity)
            <!-- Assigned Users -->
            <div x-data="{ open: false }" class="px-5 mb-4 w-2/3">
                <div class="flex font-semibold text-lg mb-2 text-black">
                    Assigned Users:
                </div>
                <div class="flex mb-4 max-w-300">
                    @if($activity->users->isNotEmpty())
                    <table class="w-full border  border-background-darker border-t-2">
                        <thead class="bg-background-dark">
                            <tr class="border border-background-darker border-t-2 ">
                                <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                                <th class="w-4/10 text-left border border-background-darker p-2 font-semibold">Role</th>
                                <th class="w-2/10 text-left border border-background-darker p-2 font-semibold">State</th>
                                <th class="w-1/10 text-left border border-background-darker p-2 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($activity->users as $user)
                            
                            <tr>
                                <td class="p-2 border border-background-dark">
                                    <a href="{{ route('users.show', $user) }}" 
                                    class="font-semibold py-1 hover:underline text-primary">
                                        {{ $user->username }}
                                    </a>
                                </td>
                                <td class="p-2 border border-background-dark">
                                    {{ $user->role }}
                                </td>
                                <td class="p-2 border border-background-dark">
                                    @if(is_null($user->pivot->completed))
                                        Not done
                                    @elseif($user->pivot->completed)
                                        Success
                                    @else
                                        Failed
                                    @endif
                                </td>
                                @can('update', $activity)
                                <td class="p-2 border font-bold text-primary border-background-dark text-center">
                                    <form action="{{ route('activities.unassignUser', ['activity' => $activity->id, 'user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="areasOfInterest[]" value="{{ $user->id}}">
                                        <button type="submit"
                                                class=" text-center text-primary hover:text-primary-highlight font-bold cursor-pointer">
                                            Remove
                                        </button>
                                    </form>
                                </td>
                                @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else   
                    <div class="text-background-darker">
                        none
                    </div>
                    @endif
                </div>

                <!-- Add Assigned Users -->
                @can('update', $activity)
                <button @click="open = !open" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                    Assigned Users
                </button>

                <div x-show="open" x-transition class="mt-4 mb-4">
                    @if($users->isNotEmpty())
                    <form action="{{ route('activities.assignUsers', $activity) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <table class="border w-full max-w-96 border-background-darker border-t-2 mb-4">
                            <thead class="bg-background-dark">
                                <tr class="border border-background-darker border-t-2">
                                    <th class="text-left p-2 border border-background-darker">Name</th>
                                    <th class="w-4/10 text-left border border-background-darker p-2 font-semibold">Role</th>
                                    <th class="w-12"></th>
                                </tr>   
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr class="p-2 border border-background-dark">
                                        <td class="p-2">{{ $user->username }}</td>
                                        <td class="p-2 border border-background-dark">
                                            {{ $user->role }}
                                        </td>
                                        <td class="p-2 flex justify-center">
                                            <input type="checkbox" class="w-4 h-4" name="users[]" value="{{ $user->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="flex gap-2">
                            <button type="button" @click="open = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">Confirm Selection</button>
                        </div>
                    </form>
                    @else
                        <div x-show="open" class="text-background-darker mb-4">
                            none to add
                        </div>
                    @endif
                </div>
                @endcan
            </div>

            
            <!-- Join Request -->
            <div x-data="{ open: false }" class="px-5 mb-4">
                <div class="flex font-semibold text-lg mb-2 text-black">
                    Requests to join:
                </div>
                <div class="flex mb-4 max-w-300">
                    @if($activity->activityRequests->isNotEmpty())
                    <table class="w-full border  border-background-darker border-t-2">
                        <thead class="bg-background-dark">
                            <tr class="border border-background-darker border-t-2 ">
                                <th class="w-6/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                                <th class="w-4/10 text-left border border-background-darker p-2 font-semibold">Role</th>
                                <th class="w-1/10 text-left border border-background-darker p-2 font-semibold"></th>
                                 <th class="w-1/10 text-left border border-background-darker p-2 font-semibold"></th>
                            </tr>   
                        </thead>
                        <tbody >
                            @foreach($activity->activityRequests as $request)
                            
                            <tr>
                                <td class="p-2 border border-background-dark">
                                    <a href="{{ route('users.show', $request->user) }}" 
                                    class="font-semibold py-1 hover:underline text-primary">
                                        {{ $request->user->username }}
                                    </a>
                                </td>
                                <td class="p-2 border border-background-dark">
                                    {{ $request->user->role }}
                                </td>
                                <td class="p-2 border font-bold text-primary border-background-dark text-center">
                                    <form action="{{ route('activityRequest.approve', ['activityRequest' => $request->id]) }}" method="POST">
                                        @csrf   
                                        @method('PATCH')
                                        <button type="submit"
                                                class=" text-center text-primary hover:text-primary-highlight font-bold cursor-pointer">
                                            Approve
                                        </button>
                                    </form>
                                </td>
                                <td class="p-2 border font-bold text-primary border-background-dark text-center">
                                    <form action="{{ route('activityRequest.reject', ['activityRequest' => $request->id]) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                class=" text-center text-primary hover:text-primary-highlight font-bold cursor-pointer">
                                            Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
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
            </div>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>