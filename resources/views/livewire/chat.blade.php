<section>
    <div class="container py-5">

        <div class="row">

            <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                <h5 class="font-weight-bold mb-3 text-center text-lg-start">Member</h5>

                <div class="card">
                    <div class="card-body">

                        <ul class="list-unstyled mb-0">
                            <li class="p-2 border-bottom bg-body-tertiary">
                                <a href="#!" class="d-flex justify-content-between">
                                    <div class="d-flex flex-row">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp"
                                            alt="avatar" class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                            width="60">
                                        <div class="pt-1">
                                            <p class="fw-bold mb-0">John Doe</p>
                                            <p class="small text-muted">Hello, Are you there?</p>
                                        </div>
                                    </div>
                                    <div class="pt-1">
                                        <p class="small text-muted mb-1">Just now</p>
                                        <span class="badge bg-danger float-end">1</span>
                                    </div>
                                </a>
                            </li>
                            <!-- Add more member list items if needed -->
                        </ul>

                    </div>
                </div>

            </div>

            <div class="col-md-6 col-lg-7 col-xl-8">

                <ul class="list-unstyled chat-list" id="chat-list">
                    @foreach($messages as $message)
                    <li class="d-flex justify-content-between mb-4">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                            class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between p-3">
                                <p class="fw-bold mb-0">{{ $message->user->name }}</p>
                                <p class="text-muted small mb-0"><i class="far fa-clock"></i>
                                    {{ $message->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">
                                    {{ $message->message }}
                                </p>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>

                <div class="bg-white mt-auto mb-3">
                    <div data-mdb-input-init class="form-outline">
                        <textarea wire:model="messageText" wire:keydown.enter="sendMessage"
                            class="form-control bg-body-tertiary" id="textAreaExample2" rows="4"></textarea>
                        <label class="form-label" for="textAreaExample2">Message</label>
                    </div>
                </div>
                <button wire:click="sendMessage" type="button" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-info btn-rounded float-end">Send</button>
            </div>

        </div>

    </div>
</section>


