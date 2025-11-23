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
            <form action="{{ route('targetDemographics.update', parameters: $targetDemographic) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Edit Information Source -->
                <div class="flex flex-col  min-w-0 px-5 py-4 bg-background">
                    <div class="flex justify-between">
                        <div class="flex font-semibold text-3xl px-5 py-4 text-black">
                            Edit Target Demographic
                        </div>

                        <!-- Save Button -->
                        @can('update', $targetDemographic)
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
                        placeholder="Target Demographic name"
                        value="{{ $targetDemographic->name }}"
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
                        rows="4">{{ $targetDemographic->description }}</textarea>
                        @error('username')
                        <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div> 

                    <!-- Amount -->
                    <div class="px-5 py-2">
                        <label for="amount" class="font-semibold mb-1">Amount:</label>
                        <input type="number"
                            name="amount"
                            id="amount"
                            value="{{ old('amount', $targetDemographic->amount) }}"
                            class="w-1/5 px-1 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-primary
                            @error('amount') input-error @enderror">
                        @error('amount')
                            <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Difficulty -->
                    <div class="px-5 py-2">
                        <label for="difficulty" class="font-semibold mb-1">Difficulty:</label>
                        <input type="number"
                            name="difficulty"
                            id="difficulty"
                            value="{{ old('difficulty', $targetDemographic->difficulty) }}"
                            class="w-1/5 px-1 py-1 border rounded focus:outline-none focus:ring-2 focus:ring-primary
                            @error('difficulty') input-error @enderror">
                        @error('difficulty')
                            <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Ethics -->
                    <div class="px-5 py-2">
                        <label for="ethics" class="font-semibold text-lg mb-1">Ethics:</label>
                        <input type="text"
                            name="ethics"
                            id="ethics"
                            value="{{ old('ethics', $targetDemographic->ethics) }}"
                            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-primary
                            @error('ethics') input-error @enderror">
                        @error('ethics')
                            <span class="text-error text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </form>
        </div>
        <div class="flex flex-[1] bg-background px-5 py-4 justify-end" ></div>
    </div>
</x-layout>