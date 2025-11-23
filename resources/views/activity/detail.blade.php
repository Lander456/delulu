@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
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

            <!-- Assigned Users -->
            <div x-data="{ open: false }" class="px-5 mb-4">
                <div class="flex font-semibold text-lg mb-2 text-black">
                    Assigned Users:
                </div>
                <div class="flex mb-4 max-w-300">
                    @if($activity->users->isNotEmpty())
                    <table class="w-full border  border-background-darker border-t-2">
                        <thead class="bg-background-dark">
                            <tr class="border border-background-darker border-t-2 ">
                                <th class="w-6/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                                <th class="w-4/10 text-left border border-background-darker p-2 font-semibold">Role</th>
                                <th class="w-1/10 text-left border border-background-darker p-2 font-semibold"></th>
                            </tr>
                        </thead>
                        <tbody >
                            @foreach($activity->users as $user)
                            @can('view', arguments: $user)
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

                <!-- Add Assigned Users -->
      
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
            </div>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-center" >
            
        </div>
    </div>
</x-layout>