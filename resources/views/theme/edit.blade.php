@php
    use App\Models\Activity;
    use App\Models\Step;
    use App\Models\Campaign;
    use App\Models\Theme;
    use App\Enums\RolesEnum;

@endphp

<x-layout>
    <div class="flex min-h-screen h-full bg-background">
        <div class="flex-row flex-[4] min-h-screen h-full bg-background">
            <form action="{{ route('themes.update', parameters: $theme) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Edit Theme -->
                <div class="flex flex-col  min-w-0 px-5 py-4 bg-background">
                    <div class="flex justify-between">
                        <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                            Edit Theme
                        </div>

                        <!-- Save Button -->
                        @can('update', $theme)
                            <div class="flex flex-col  items-center w-32 text-black justify-center">
                                
                                <button type="submit" class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                    Save
                                </button>
                            </div>
                        @endcan
                    </div>
                    <hr class="border-background-darker border-t-2 mb-6">

                    <!-- Name -->
                    <div class="px-5 py-4s">

                        <input type="text"
                        name="name"
                        id="name"
                        placeholder="Theme name"
                        value="{{ $theme->name }}"
                        required
                        class="w-1/2 w-min-64 flex font-semibold text-2xl px-5 py-2 mb-4 text-black bg-background focus:outline-none 
                        focus:ring-2 focus:ring-primary border-background-darker border-2 rounded
                        input @error('name') input-error @enderror">
                        @error('name')
                        <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Description -->
                    <label class="font-semibold text-lg px-5 py-4s mb-2">Description:</label>
                    <div class="px-5 py-4s">
                        <textarea
                        name="description"
                        id="description"
                        placeholder="Description"
                        class="min-w-64 w-full px-5 py-4 text-black mb-2 bg-background
                    focus:outline-none focus:ring-2 focus:ring-primary
                    border-background-darker border-2
                    @error('description') input-error @enderror"
                        rows="4">{{ $theme->description }}</textarea>
                        @error('username')
                        <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div> 

                    <!-- Assigned Coordinator -->
                    <label class="font-semibold text-lg px-5 mb-2">Assigned Coordinator:</label>
                    <div class="px-5 mb-4">
                        @if(auth()->check() && auth()->user()->hasRole(RolesEnum::SYSADMIN->value))
                            <select name="user_id" id="user_id" 
                                    class="w-1/4 w-min-64 px-4 py-2 bg-background border-background-darker rounded border-2">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" class="text-black" 
                                        @selected(optional($theme->user)->id === $user->id)>
                                        {{ $user->username }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            {{ $theme->user->username }}
                        @endif
                    </div> 
                </div>
            </form>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-end" ></div>
    </div>
</x-layout>