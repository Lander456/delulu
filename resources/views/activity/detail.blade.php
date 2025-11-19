<x-layout>
    <x-slot:title>{{ $activity->name }}</x-slot:title>
    @can('update', $activity)
        <a href="{{ route('activities.edit', $activity) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Edit
        </a>
    @endcan

    <x-shared.form-section :item="$activity" :editable="false" />

    <div>
        <label class="font-semibold">Assigned Coordinator:</label>
        <div>{{ $activity->step->user->username }}</div>
    </div>

    @can('update', $activity)
        <h4 class="text-lg font-semibold mt-6">Assigned users</h4>
        <x-shared.user-table :users="$activity->users" :activity="$activity" :showActions="true" />
        <x-activity.user-assign-form :activity="$activity" :users="$users" />
    @endcan
</x-layout>
