<!DOCTYPE html>
<html>
<head>
    <title>Larager Debug Logs</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-zinc-800 text-zinc-100">

    <h1 class="text-4xl my-12 text-center font-bold">Larager Debug Logs</h1>

    <div class="flex flex-col gap-4 max-w-screen-lg mx-auto pb-8 px-2">

        @if(count($logs))
        @foreach ($logs as $log)

        @php
        $color = match ($log->level) {
        'EMERGENCY' => 'red',
        'ERROR' => 'rose',
        'INFO' => 'purple',
        'DEBUG' => 'amber',
        'CRITICAL' => 'pink',
        'NOTICE' => 'blue',
        default => 'white',
        };
        @endphp
        @component('larager::components.logCard',['log'=>$log,'color'=>$color])
        @endcomponent


        @endforeach
        @else
        <p>No logs to show.</p>
        @endif
    </div>

</body>
</html>
