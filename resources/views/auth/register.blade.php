<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' - Delulu' : 'Delulu' }}</title>
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
</head>
<body>

    <div class="min-h-screen flex flex-col items-center justify-center bg-background">

        <div class=" w-80">
            
            <!-- Header -->
            <div class="shadow-md p-3 text-center font-semibold text-4xl tracking-wide text-white bg-primary">
                DELULU
            </div>

            <!-- Register body -->
            <div class="bg-white p-6 rounded-b shadow-md ">
                
                <!-- Form body -->
                <div class=" flex justify-center">
                    <form method="POST" action="/register" class="w-full">
                        @csrf
                        
                        <!-- Username -->
                        <div class="mb-2">
                            <label for="username" class="block text-md font-semibold w-full text-left mb-1">
                                Username
                            </label>
                            
                            <input type="text"
                                name="username"
                                id="username"
                                placeholder="John Desinformation"
                                value="{{ old('username') }}"
                                required
                                class="w-full px-3 py-1 mb-2 bg-background focus:outline-none focus:ring-2 focus:ring-primary
                                    input @error('username') input-error @enderror">
                                @error('username')
                                    <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                        </div>

                         <!-- Email -->
                        <div class="mb-2">
                            <label for="email" class="block text-md font-semibold w-full text-left mb-1">
                                Email Address
                            </label>
                            
                            <input type="text"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-3 py-1 mb-2 bg-background focus:outline-none focus:ring-2 focus:ring-primary
                                    input @error('email') input-error @enderror">
                                @error('email')
                                    <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                                @enderror
                        </div>
                           
                        <!-- Password -->
                        <div class="mb-2">
                            <label for="password" class="block text-md font-semibold w-full text-left mb-1">
                                Password
                            </label>
                            
                            <input type="password"
                            id="password"
                            name="password"
                            class="w-full px-3 py-1 mb-2 bg-background focus:outline-none focus:ring-2 focus:ring-primary
                            @error('password') input-error @enderror"
                            required>
                            @error('password')
                                <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-2">
                            <label for="password" class="block text-md font-semibold w-full text-left mb-1">
                                Confirm Password
                            </label>
                            
                            <input type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="w-full px-3 py-1 mb-2 bg-background focus:outline-none focus:ring-2 focus:ring-primary
                            @error('password_confirmation') input-error @enderror"
                            required>
                            @error('password_confirmation')
                                <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Login button -->
                        <button type="submit"
                                class="bg-primary text-white w-full p-2 rounded-b mb-8 cursor-pointer hover:bg-primary-highlight">
                            Register
                        </button>

                    </form>

                </div>

                <p class="text-center text-sm">
                Already a seasoned gaslighter? 
                <a href="/login" class="font-bold link link-primary text-primary underline">Sign In</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
