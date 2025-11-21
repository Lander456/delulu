<x-layout>
    <x-slot:title>{{ $step->name }}</x-slot:title>
    @can('update', $step)
        <a href="{{ route("steps.edit", $step) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Edit
        </a>
    @endcan

    <x-shared.form-section :item="$step" :editable="false"/>

    <div>
        <label class="font-semibold">Assigned Coordinator:</label>
        <div>{{ $step->user->username }}</div>
    </div>

    <div>
        <h4 class="font-semibold">Assigned Activities:</h4>
        <x-shared.activity-table :activities="$step->activities" :step="$step" :showActions="true" />
        <x-step.activity-assign-form :step="$step" :activities="$step->activities"/>
    </div>

</x-layout>

