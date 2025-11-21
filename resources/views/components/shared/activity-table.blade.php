<table class="w-full border-collapse mt-4">
    <thead>
        <tr class="border-b">
            <th class="text-left p-2">Activity name</th>
            <th class="text-left p-2">Assigned coordinator</th>
        </tr>
    </thead>
    <tbody>
@if($activities->isEmpty())
    <tr>
        <td colspan="2" class="p-2 text-gray-500">No users assigned</td>
    </tr>
@else
    @foreach($activities as $activity)
        <tr class="border-b">
            <td class="p-2">{{ $activity->name }}</td>
            <td class="p-2">{{ $activity->step->user->username }}</td>
            <td class="p-2">
                <form action="{{ route('steps.unassignActivities', [$step, $activity]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this step?')">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-800">
                        Unassign
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        @endif
        </tbody>
        </table>
