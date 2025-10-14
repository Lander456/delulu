<x-layout>
    <form action="{{ route('steps.store') }}" method="POST">
        @csrf

        <label for="name">Step name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control">

        <label for="description">Step description</label>
        <input type="text" name="description" value="{{ old('description') }}" class="form-control">

        <label for="campaign">Select campaign</label>
        <select name="campaign" id="campaign" class="form-control">
            @foreach(auth()->user()->getCampaigns() as $campaign)
                <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>

    </form>
</x-layout>
