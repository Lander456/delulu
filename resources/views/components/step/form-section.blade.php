@props(['step', 'editable' => false])

<div class="space-y-4">
    <div>
        <label class="font-semibold">Name:</label>
        @if($editable)
            <input type="text" name="name" value="{{ old('name', $step->name) }}" class="w-full border rounded px-3 py-2 required">
        @else
            <div>{{ $step->name }}</div>
        @endif
    </div>

    <div>
        <label class="font-semibold">Description:</label>
        @if($editable)
            <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ old('description', $step->description) }}</textarea>
        @else
            <div>{{ $step->description ?: '----' }}</div>
        @endif
    </div>
</div>
