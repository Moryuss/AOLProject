@extends('layouts.master')

@section('title')
    Gestione Utenti Chat
@endsection

@section('body')
    <div class="container aol-body">
        <h3 class="aol-buddy-header">Gestisci utenti nella chat: "{{ $chat->chat_name }}"</h3>

        <input type="text" id="userSearch" class="form-control mb-3 aol-input" placeholder="Cerca utente...">

        <ul class="list-group aol-buddy-list" id="userList">
            @foreach ($users as $user)
                <li class="list-group-item aol-list-item d-flex justify-content-between align-items-center">
                    <strong class="aol-user">{{ $user->name }}</strong>

                    <form action="{{ route('chat.manageUsersAction', [$chat->id, $user->id]) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="btn btn-sm {{ $chat->users->contains($user) ? 'btn-danger' : 'btn-success' }}">
                            {{ $chat->users->contains($user) ? 'Rimuovi' : 'Aggiungi' }}
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        $(document).ready(function () {
            $('#userSearch').on('keyup', function () {
                var search = $(this).val().toLowerCase();

                $('#userList li').each(function () {
                    var name = $(this).text().toLowerCase();
                    $(this).toggle(name.includes(search));
                });
            });
        });

    </script>
@endsection