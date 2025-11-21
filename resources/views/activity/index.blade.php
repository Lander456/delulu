<x-layout>
    <x-slot:title>Activities</x-slot:title>
    <div class="container mx-auto px-4">

        <h2 class="text-2xl font-bold mb-3">Ongoing Activities</h2>

        @if ($ongoingActivities->isEmpty())
            <p class="text-gray-600 mb-6">No ongoing activities.</p>
        @else
            <table class="w-full mb-10 border-collapse">
                <thead>
                <tr class="border-b font-semibold bg-gray-100">
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Description</th>
                    <th class="p-2 text-left">Created At</th>
                    <th class="p-2 text-right">Actions</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($ongoingActivities as $activity)
                    <tr class="border-b">
                        <td class="p-2">{{ $activity->name }}</td>
                        <td class="p-2">{{ $activity->description }}</td>
                        <td class="p-2">{{ $activity->created_at->format('Y-m-d') }}</td>

                        @can('update', $activity)
                            <td class="p-2 text-right space-x-2">

                                {{-- Mark as Completed --}}
                                <form action="{{ route('activities.complete', $activity) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="completed" value="1">
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Mark Completed
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                            onclick="return confirm('Delete this activity?')">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif



        {{-- =====================
            COMPLETED ACTIVITIES
        ===================== --}}
        <h2 class="text-2xl font-bold mb-3">Completed Activities</h2>

        @if ($completedActivities->isEmpty())
            <p class="text-gray-600">No completed activities.</p>
        @else
            <table class="w-full border-collapse">
                <thead>
                <tr class="border-b font-semibold bg-gray-100">
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Description</th>
                    <th class="p-2 text-left">Completed At</th>
                    @if(auth()->user()->is_admin)
                        <th class="p-2 text-right">Actions</th>
                    @endif
                </tr>
                </thead>

                <tbody>
                @foreach ($completedActivities as $activity)
                    <tr class="border-b">
                        <td class="p-2">{{ $activity->name }}</td>
                        <td class="p-2">{{ $activity->description }}</td>
                        <td class="p-2">{{ $activity->updated_at->format('Y-m-d') }}</td>

                        @if(auth()->user()->is_admin)
                            <td class="p-2 text-right">
                                {{-- Delete --}}
                                <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                            onclick="return confirm('Delete this activity?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

    </div>
</x-layout>
