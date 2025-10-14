@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp

<x-layout>
    <x-slot:title>
        Home
    </x-slot:title>
    @if($assignedActivities->isNotEmpty())
        <x-homepage.section title="Assigned activities">
            @foreach($assignedActivities as $assignedActivity)
                <x-homepage.item :name="$assignedActivity->name" :route="route('activities.show', $assignedActivity)" />
            @endforeach
        </x-homepage.section>
    @endif

    @if($ownedActivities->isNotEmpty())
        <x-homepage.section title="Owned activities">
            @foreach($ownedActivities as $ownedActivity)
                <x-homepage.item :name="$ownedActivity->name" :route="route('activities.show', $ownedActivity)" />
            @endforeach
        </x-homepage.section>
    @endif

    @if($steps->isNotEmpty())
        <x-homepage.section title="My steps">
            @foreach($steps as $step)
                <x-homepage.item :name="$step->name" :route="route('steps.show', $step)" />
            @endforeach
        </x-homepage.section>
    @endif

    @if($campaigns->isNotEmpty())
        <x-homepage.section title="My campaigns">
            @foreach($campaigns as $campaign)
                <x-homepage.item :name="$campaign->name" :route="route('campaigns.show', $campaign)" />
            @endforeach
        </x-homepage.section>
    @endif

    @if($themes->isNotEmpty())
        <x-homepage.section title="My themes">
            @foreach($themes as $theme)
                <x-homepage.item :name="$theme->name" :route="route('themes.show', $theme)" />
            @endforeach
        </x-homepage.section>
    @endif
</x-layout>
