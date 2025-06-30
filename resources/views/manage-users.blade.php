@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@extends('layouts.master')

@section('title')
    Gestione Utenti Chat
@endsection

@section('body')
    <div class="container aol-body">
        <h3 class="aol-buddy-header">Gestisci utenti nella chat: "{{ $chat->chat_name }}"</h3>

        {{-- <input type="text" id="userSearch" class="form-control mb-3 aol-input" placeholder="Cerca utente..."> --}}

        <ul class="list-group aol-buddy-list" id="userList">
            @foreach ($users as $user)
                <li class="list-group-item aol-list-item d-flex justify-content-between align-items-center"
                    data-username="{{ strtolower($user->name) }}">

                    <strong class="aol-user">{{ $user->name }}</strong>

                    <form
                        action="{{ route($userIdsInChat && in_array($user->id, $userIdsInChat) ? 'chat.removeUser' : 'chat.addUser', [$chat->id, $user->id]) }}"
                        method="POST">
                        @csrf
                        <button type="submit"
                            class="btn btn-sm {{ $userIdsInChat && in_array($user->id, $userIdsInChat) ? 'btn-danger' : 'btn-success' }}">
                            {{ $userIdsInChat && in_array($user->id, $userIdsInChat) ? 'Rimuovi' : 'Aggiungi' }}
                        </button>
                    </form>

                </li>
            @endforeach
        </ul>
    </div>

    {{--
    <script>
        $('#userSearch').on('keyup', function () {
            var search = $(this).val().toLowerCase();

            $('#userList li').each(function () {
                var name = $(this).data('username');
                $(this).toggle(name.includes(search));
            });
        });

    </script> --}}
@endsection