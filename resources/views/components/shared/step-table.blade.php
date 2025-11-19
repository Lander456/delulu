<table class="w-full border-collapse mt-4">
    <thead>
        <tr class="border-b">
            <th class="text-left p-2">Step name</th>
            <th class="text-left p-2">Coordinator</th>
        </tr>
    </thead>
    <tbody>
        @if($steps->isEmpty())
            <tr>
                <td colspan="2" class="p-2 text-gray-500">No steps assigned</td>
            </tr>
        @else
            @foreach($steps as $step)
                <tr class="border-b">
                    <td class="p-2">{{ $step->name }}</td>
                    <td class="p-2">{{ $step->user->username }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
