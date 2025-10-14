<x-layout>
    name: {{ $step->name }}<br>
    description: {{ $step->description }}<br>
    <h4>Designated activities</h4>
    <table>
        <tr>
            <th>
                Activity name
            </th>
            <th>
                Success rate
            </th>
        </tr>
    @forelse($step->activities()->get() as $activity)
        <tr>
            <td>
                {{ $activity->name }}
            </td>
            <td>
                @if($activity->success != null)
                    {{ number_format($activity->success * 100, 2) }}%
                @else
                    Activity not performed yet
                @endif
            </td>
            <td>
                <form action={{ route('activities.show', $activity) }} method="GET">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View activity</button>
                </form>
            </td>
        </tr>
    @empty
        No activities designated for this step :)
    @endforelse
    </table>
</x-layout>

