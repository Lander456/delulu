<x-layout>
    <form action="{{ route('activities.store') }}" method="POST">
        @csrf

        <label for="name">Activity name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">

        <label for="description">Activity description</label>
        <input type="text" name="description" value="{{ old('description') }}" class="form-control">

        <label for="step">Select campaign step</label>
        <select name="step" id="step" class="form-control">
            @foreach(auth()->user()->getSteps() as $step)
                <option value="{{ $step->id }}">{{ $step->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>

    </form>
</x-layout>
