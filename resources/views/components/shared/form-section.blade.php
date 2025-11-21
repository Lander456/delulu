@props(['item', 'editable' => false])

<div class="space-y-4">
    <div>
        <label class="font-semibold">Name:</label>
        @if($editable)
            <input type="text" name="name" value="{{ old('name', $activity->name) }}" class="w-full border rounded px-3 py-2 required">
        @else
            <div>{{ $item->name }}</div>
        @endif
    </div>

    <div>
        <label class="font-semibold">Description:</label>
        @if($editable)
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $activity->description) }}</textarea>
        @else
            <div>{{ $item->description ?: '----' }}</div>
        @endif
    </div>
</div>
