<x-layout>
    <x-slot:title>Activities</x-slot:title>
    <x-shared.index-table
        :items="$activities"
        :columns="['Name', 'Success rate', 'Responsible']"
        :fields="['name', 'success', 'step.user.username']"
        routeName="activities.show"
        emptyMessage="No activities to show :)"
    />
</x-layout>
