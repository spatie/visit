<div class="ml-2 my-1">
    <div class="w-full {{ $headerStyle }} max-w-100"></div>
    <div class="w-full {{ $headerStyle }} px-2 max-w-100">
        <span class="text-left w-1/2">
            <span class="uppercase font-bold mr-1">{{ $method }}</span>
            <span>{{ $url }}</span>
        </span>
        <span class="text-right w-1/2">
            {{ $statusCode }}
        </span>
    </div>
    @if (count($statResults))
        <div class="w-full {{ $headerStyle }} px-2 max-w-100">
            @foreach ($statResults as $statResult)
                <span class="font-bold text-gray capitalize">{{ $statResult->name }}:</span> {{ $statResult->value }}
            @endforeach
        </div>
    @endif
    <div class="w-full {{ $headerStyle }} max-w-100"></div>

    @if($showHeaders)
        <div class="underline mt-1">Headers:</div>
        @foreach ($headers as $name => $value)
            <div>
                <span class="font-bold text-gray capitalize">{{ $name }}:</span> {{ $value[0] }}
            </div>
        @endforeach
    @endif
</div>