<x-layout>
    <x-slot:title>{{ $activity->name }}</x-slot:title>
    <a href="{{ route('activities.edit', $activity) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Edit
    </a>

    <x-activity.form-section :activity="$activity" :editable="false" />

    <h4 class="text-lg font-semibold mt-6">Assigned users</h4>
    <x-shared.user-table :users="$activity->users" :activity="$activity" :showActions="true" />

    <x-activity.user-assign-form :activity="$activity" :users="$users" />
</x-layout>
