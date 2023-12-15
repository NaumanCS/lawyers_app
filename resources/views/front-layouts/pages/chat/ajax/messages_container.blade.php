@php
    use App\General\ChatClass;
@endphp
@foreach ($chat as $data)
    @if ($data->sender_id == auth()->user()->id)
        @if (!empty($data->attachment))
            <div class="me-5" style="display: flex; flex-direction: column; align-items: end;">
                @foreach ($data->attachment as $image)
                    <img src="{{ $image }}" alt="image" class="w-25 mb-1">
                @endforeach
            </div>
        @endif
        <div class="d-flex flex-row justify-content-end">
            <div>
                <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-dark">
                    {{ $data->body }}
                </p>
                <p class="small me-3 mb-3 rounded-3 text-muted">
                    {{ ChatClass::getMessageTimeInFormat($data->created_at) }}
                </p>
            </div>
            <img src="{{ $data->user->image }}" alt="{{ $data->user->name }}"
                style="width: 46px;height: 46px;border-radius: 50%;" />
        </div>
    @else
        @if (!empty($data->attachment))
            <div class="me-5" style="display: flex; flex-direction: column; align-items: start;">
                @foreach ($data->attachment as $image)
                    <img src="{{ $image }}" alt="image" class="w-25 mb-1">
                @endforeach
            </div>
        @endif
        <div class="d-flex flex-row justify-content-start">
            <img src="{{ $data->user->image }}" alt="{{ $data->user->name }}"
                style="width: 46px;height: 46px;border-radius: 50%;" />
            <div>
                <p class="small p-2 ms-3 mb-1 rounded-3" style="background-color: #f5f6f7;">
                    {{ $data->body }}
                </p>
                <p class="small ms-3 mb-3 rounded-3 text-muted float-start">
                    {{ ChatClass::getMessageTimeInFormat($data->created_at) }}
                </p>
            </div>
        </div>
    @endif
@endforeach
