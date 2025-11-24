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
            <form action="{{ route('users.update', parameters: $user) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Edit Information Source -->
                <div class="flex flex-col  min-w-0 px-5 py-4 bg-background">
                    <div class="flex justify-between">
                        <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                            Edit user
                        </div>

                        <!-- Save Button -->
                        @can('update', $user)
                            <div class="flex flex-col  items-center w-32 text-black justify-center">
                                
                                <button type="submit" class="flex bg-primary text-white px-4 py-2 rounded hover:bg-primary-highlight">
                                    Save
                                </button>
                            </div>
                        @endcan
                    </div>
                    <hr class="border-background-darker border-t-2 mb-6">

                    <!-- Username -->
                    <div class="px-5 py-4s">

                        <input type="text"
                        name="username"
                        id="username"
                        placeholder="Username"
                        value="{{ $user->username }}"
                        required
                        class="w-1/2 w-min-64 flex font-semibold text-2xl px-5 py-2 mb-4 text-black bg-background focus:outline-none 
                        focus:ring-2 focus:ring-primary border-background-darker border-2 rounded
                        input @error('name') input-error @enderror">
                        @error('name')
                        <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="px-5 py-2 w-1/2">
                        <label for="email" class="font-semibold text-lg ">Email:</label>
                        <input type="text"
                            name="email"
                            id="email"
                            value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary
                            @error('email') input-error @enderror">
                        @error('email')
                            <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                   <!-- Password -->
                    <div class="px-5 py-2 w-1/2">
                        <label for="password" class="block text-md font-semibold w-full text-left mb-1">
                            Password
                        </label>
                        <input type="password"
                        id="password"
                        name="password"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary
                            @error('password') input-error @enderror">
                        @error('password')
                            <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="px-5 py-2 w-1/2">
                        <label for="password" class="block text-md font-semibold w-full text-left mb-1">
                            Confirm Password
                        </label>
                        
                        <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary
                            @error('password') input-error @enderror">
                        @error('password_confirmation')
                            <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </form>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-end" ></div>
    </div>
</x-layout>