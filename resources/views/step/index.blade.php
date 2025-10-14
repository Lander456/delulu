<x-layout>
    <x-slot:title>Steps</x-slot:title>
    <x-shared.index-table
        :items="$steps"
        :columns="['Name', 'Success rate', 'Responsible']"
        :fields="['name', 'success_rate', 'user.username']"
        routeName="steps.show"
        emptyMessage="No steps to show :)"
    />
</x-layout>
