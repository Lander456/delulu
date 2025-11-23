@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
@endphp

<x-layout>
    <x-slot:title>Users</x-slot:title>
    <div class="flex min-h-screen h-full bg-background">
        <!-- Users -->
        <div class = "flex flex-col flex-[4] min-w-64 px-5 py-4  bg-background">
            <div class="flex justify-between">
                <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                    All Users
                </div>
            </div>
           <hr class="border-background-darker border-t-2 mb-4">

            <!-- User table-->
            <div class="flex w-2/3 px-5 mb-4 overflow-x-autos">
                @if($users->isNotEmpty())
                <table class="min-w-full border border-background-darker border-t-2 ">
                    <thead class="bg-background-dark">
                        <tr class="border border-background-darker border-t-2">
                            <th class="w-3/10 text-left border border-background-darker p-2 font-semibold">Name</th>
                            <th class="w-4/10 text-left border border-background-darker p-2 font-semibold">Role</th>                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="p-2 border border-background-dark">
                                @can('view', $user)
                                <a href="{{ route('users.show', $user) }}" 
                                class="font-semibold text-primary py-1 hover:underline hover:text-primary-highlight">
                                    {{ $user->username }}
                                </a>
                                @else
                                <span class="font-semibold text-black py-1">{{ $user->username }}</span>
                                @endcan
                            </td>
                            <td class="p-2 border border-background-dark truncate max-w-md">
                                {{ $user->role}}
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="text-background-darker">
                    none
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
