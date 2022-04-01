<div class="ml-2 my-1">
    <div class="w-full {{ $headerStyle }} max-w-100"></div>
    <div class="w-full {{ $headerStyle }} px-2 max-w-100 justify-between">
        <span>
            <span class="uppercase font-bold mr-1">{{ $method }}</span>
            <span>{{ $url }}</span>
        </span>
        <span>
            {{ $statusCode }}
        </span>
    </div>
    @if($redirectingTo)
        <div class="w-full {{ $headerStyle }} px-2 max-w-100">
            <span class="font-bold text-gray capitalize">Redirecting to:</span> {{ $redirectingTo }}
        </div>
    @endif
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

    @if(count($redirects))
        <div class="underline mt-1">Redirects:</div>
        @foreach ($redirects as $redirect)
            @if(! $loop->first)
                <br />
            @endif
            <div>
                <span class="font-bold text-gray">
                {{ $redirect['status'] }} {{ $redirect['from'] }}
                </span>
                <br/>
                <span>-><span>️ {{ $redirect['to'] }}
            </div>
        @endforeach
    @endif
</div>
