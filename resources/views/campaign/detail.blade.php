<x-layout>
    <x-slot:title>{{ $campaign->name }}</x-slot:title>
    @can('update', $campaign)
        <a href="{{ route('campaigns.edit', $campaign) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Edit
        </a>
    @endcan

    <x-campaign.form-section :campaign="$campaign" :editable="false" />

    <h4 class="text-lg font-semibold mt-6">Assigned steps</h4>
    <x-shared.step-table :steps="$campaign->steps" :showActions="true" />

    @can('update', $campaign)

    @endcan
</x-layout>
