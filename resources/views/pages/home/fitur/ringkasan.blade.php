@php use Illuminate\Support\Str; @endphp

<div class="container mt-4">
    <div class="row g-3">
        @foreach($ringkasan as $index => $item)
        @php
            $colors = ['text-indigo', 'text-yellow', 'text-green'];
            $color = $colors[$index % count($colors)];
        @endphp
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card card-lg h-100" style="border-radius: 24px;">
                <div class="card-body">
                    <h1 class="text-center {{ $color }}">
                        {{ $item['value'] }}@if(Str::contains(strtolower($item['label']), 'persentase'))%@endif
                    </h1>
                    <h3 class="text-muted text-center">{{ $item['label'] }}</h3>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
