<x-layout>
    <x-slot:title>Campaigns</x-slot:title>
    <x-shared.index-table
        :items="$campaigns"
        :columns="['Name', 'Success rate', 'Theme', 'Responsible']"
        :fields="['name', 'success_rate', 'theme.name', 'user.username']"
        routeName="campaigns.show"
        emptyMessage="No campaigns to show :)"
    />
</x-layout>
