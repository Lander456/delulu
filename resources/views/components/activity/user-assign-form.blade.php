<div x-data="{ open: false }" class="mt-6">
    <button @click="open = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Add Users
    </button>

    <div x-show="open" x-transition class="mt-4">
        <form action="{{ route('activities.assignUsers', $activity) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="w-full border-collapse mb-4">
                <thead>
                    <tr class="border-b">
                        <th></th>
                        <th class="text-left p-2">Username</th>
                        <th class="text-left p-2">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b">
                            <td class="p-2">
                                <input type="checkbox" name="users[]" value="{{ $user->id }}">
                            </td>
                            <td class="p-2">{{ $user->username }}</td>
                            <td class="p-2">{{ $user->role }}</td>
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
