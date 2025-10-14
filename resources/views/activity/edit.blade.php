<x-layout>
    <x-slot:title>{{ $activity->name }}</x-slot:title>

    <form action="{{ route('activities.update', $activity) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <x-activity.form-section :activity="$activity" :editable="true" />

        <div>
            <label class="font-semibold">Step</label>
            <select name="step_id" class="w-full border rounded px-3 py-2">
                @foreach(App\Models\Step::all() as $step)
                    <option value="{{ $step->id }}" @selected($activity->step_id == $step->id)>
                        {{ $step->name }} ({{ $step->user->username }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('activities.show', $activity) }}" class="text-gray-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    </form>
</x-layout>
