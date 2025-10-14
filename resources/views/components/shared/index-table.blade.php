<div class="overflow-x-auto">
    @if($items->isEmpty())
        <p class="text-gray-600">{{ $emptyMessage ?? 'No items found.' }}</p>
    @else
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b">
                    @foreach ($columns as $column)
                        <th class="text-left p-2">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-b">
                        @foreach ($fields as $field)
                            <td class="p-2">
                                @if($field == "name" && isset($routeName))
                                    <a href="{{ route($routeName, $item) }}" class="text-blue-600 hover:underline">
                                        {{ data_get($item, $field, '----') }}
                                    </a>
                                @else
                                    {{ data_get($item, $field, '----') }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
