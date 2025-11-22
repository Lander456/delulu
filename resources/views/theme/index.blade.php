<x-layout>
    <x-slot:title>Themes</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Assigned activities -->
        <div class = "flex flex-col flex-[3] min-w-64 px-5 py-4  bg-background">
            <div class="flex font-semibold text-2xl px-5 py-4 text-black">
                Themes
            </div>
           <hr class="border-background-darker border-t-2">
           <x-shared.index-table
                :items="$themes"
                :columns="['Name', 'Responsible']"
                :fields="['name', 'user.username']"
                routeName="themes.show"
                emptyMessage="No steps to show :)"
            />
        </div>
        <div class="flex flex-[2] bg-background px-5 py-4 justify-end" >

        </div>
    </div>
</x-layout>
