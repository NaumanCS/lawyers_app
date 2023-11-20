@php
    use App\General\ChatClass;
@endphp
@foreach ($chat as $data)
    @if ($data->sender_id == auth()->user()->id)
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

{{-- <div class="d-flex flex-row justify-content-start">
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar 1"
        style="
            width: 45px;
            height: 100%;
        " />
    <div>
        <p class="small p-2 ms-3 mb-1 rounded-3" style="
                background-color: #f5f6f7;
            ">
            Duis aute irure dolor in
            reprehenderit in
            voluptate velit esse
            cillum dolore eu fugiat
            nulla pariatur.
        </p>
        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
            12:00 PM | Aug 13
        </p>
    </div>
</div>

<div class="d-flex flex-row justify-content-end">
    <div>
        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">
            Excepteur sint occaecat
            cupidatat non proident,
            sunt in culpa qui
            officia deserunt mollit
            anim id est laborum.
        </p>
        <p class="small me-3 mb-3 rounded-3 text-muted">
            12:00 PM | Aug 13
        </p>
    </div>
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
        style="
            width: 45px;
            height: 100%;
        " />
</div>

<div class="d-flex flex-row justify-content-start">
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar 1"
        style="
            width: 45px;
            height: 100%;
        " />
    <div>
        <p class="small p-2 ms-3 mb-1 rounded-3" style="
                background-color: #f5f6f7;
            ">
            Sed ut perspiciatis unde
            omnis iste natus error
            sit voluptatem
            accusantium doloremque
            laudantium, totam rem
            aperiam, eaque ipsa quae
            ab illo inventore
            veritatis et quasi
            architecto beatae vitae
            dicta sunt explicabo.
        </p>
        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
            12:00 PM | Aug 13
        </p>
    </div>
</div>

<div class="d-flex flex-row justify-content-end">
    <div>
        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">
            Nemo enim ipsam
            voluptatem quia voluptas
            sit aspernatur aut odit
            aut fugit, sed quia
            consequuntur magni
            dolores eos qui ratione
            voluptatem sequi
            nesciunt.
        </p>
        <p class="small me-3 mb-3 rounded-3 text-muted">
            12:00 PM | Aug 13
        </p>
    </div>
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
        style="
            width: 45px;
            height: 100%;
        " />
</div>

<div class="d-flex flex-row justify-content-start">
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar 1"
        style="
            width: 45px;
            height: 100%;
        " />
    <div>
        <p class="small p-2 ms-3 mb-1 rounded-3" style="
                background-color: #f5f6f7;
            ">
            Neque porro quisquam
            est, qui dolorem ipsum
            quia dolor sit amet,
            consectetur, adipisci
            velit, sed quia non
            numquam eius modi
            tempora incidunt ut
            labore et dolore magnam
            aliquam quaerat
            voluptatem.
        </p>
        <p class="small ms-3 mb-3 rounded-3 text-muted float-end">
            12:00 PM | Aug 13
        </p>
    </div>
</div>

<div class="d-flex flex-row justify-content-end">
    <div>
        <p class="small p-2 me-3 mb-1 text-white rounded-3 bg-primary">
            Ut enim ad minima
            veniam, quis nostrum
            exercitationem ullam
            corporis suscipit
            laboriosam, nisi ut
            aliquid ex ea commodi
            consequatur?
        </p>
        <p class="small me-3 mb-3 rounded-3 text-muted">
            12:00 PM | Aug 13
        </p>
    </div>
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
        style="
            width: 45px;
            height: 100%;
        " />
</div> --}}
