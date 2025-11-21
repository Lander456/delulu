<x-layout>
    <x-slot:title>Themes</x-slot:title>
    <x-shared.index-table
        :items="$themes"
        :columns="['Name', 'Responsible']"
        :fields="['name', 'user.username']"
        routeName="steps.show"
        emptyMessage="No steps to show :)"
    />
</x-layout>
