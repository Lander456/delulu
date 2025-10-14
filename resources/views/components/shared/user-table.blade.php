<table class="w-full border-collapse mt-4">
    <thead>
        <tr class="border-b">
            <th class="text-left p-2">Username</th>
            <th class="text-left p-2">Role</th>
        </tr>
    </thead>
    <tbody>
        @if($users->isEmpty())
            <tr>
                <td colspan="2" class="p-2 text-gray-500">No users assigned</td>
            </tr>
        @else
            @foreach($users as $user)
                <tr class="border-b">
                    <td class="p-2">{{ $user->username }}</td>
                    <td class="p-2">{{ $user->role }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
