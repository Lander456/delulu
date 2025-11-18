@props(['campaign', 'editable' => false])

<div class="space-y-4">
    <div>
        <label class="font-semibold">Name:</label>
        @if($editable)
            <input type="text" name="name" value="{{ old('name', $campaign->name) }}" class="w-full border rounded px-3 py-2 required">
        @else
            <div>{{ $campaign->name }}</div>
        @endif
    </div>

    <div>
        <label class="font-semibold">Description:</label>
        @if($editable)
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $campaign->description) }}</textarea>
        @else
            <div>{{ $campaign->description ?: '----' }}</div>
        @endif
    </div>

    <div>
        <label class="font-semibold">Assigned Administrator:</label>
        <div>{{ $campaign->user->username }}</div>
    </div>
</div>
