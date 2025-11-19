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
        </tr>
        @endforeach
        @endif
        </tbody>
        </table>
