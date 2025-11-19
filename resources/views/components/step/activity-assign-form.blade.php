<div x-data="{ open: false }" class="mt-6">
    <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Assign Activities
    </button>

    <div x-show="open" x-transition class="mt-4">
        <form action="{{ route('steps.assignActivities', $step) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full border-collapse mb-4">
                <thead>
                <tr class="border-b">
                    <th></th>
                    <th class="text-left p-2">Activity name</th>
                </tr>
                </thead>
                <tbody>
                @foreach($activities as $activity)
                    <tr class="border-b">
                        <td class="p-2">
                            <input type="checkbox" name="activities[]" value="{{ $activity->id }}">
                        </td>
                        <td class="p-2">{{ $activity->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="flex gap-2">
                <button type="button" @click="open = false" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Confirm Selection</button>
            </div>
        </form>
    </div>
</div>
