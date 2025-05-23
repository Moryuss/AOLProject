@extends('layouts.master')

@section('title')
    Home Chat
@endsection

@section('body')
    <div class="container aol-body">
        <h3 class="aol-buddy-header">Inizia una nuova chat</h3>

        <input type="text" id="userSearch" class="form-control mb-3 aol-input" placeholder="Cerca utente...">

        <ul class="list-group aol-buddy-list" id="userList">
            @foreach ($users as $user)
                <li class="list-group-item aol-list-item">
                    <strong class="aol-user">{{ $user->name }}</strong>
                    <form action="{{ route('chat.start', $user->id) }}" method="POST" class="mt-2">
                        @csrf
                        <input type="text" name="text" class="form-control d-inline w-75 aol-input"
                            placeholder="Scrivi un messaggio...">
                        <button type="submit" class="btn btn-sm aol-btn aol-btn-send">Invia</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        document.getElementById('userSearch').addEventListener('keyup', function () {
            const search = this.value.toLowerCase();
            const users = document.querySelectorAll('#userList li');

            users.forEach(user => {
                const name = user.textContent.toLowerCase();
                user.style.display = name.includes(search) ? '' : 'none';
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('#userList form');

            forms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const input = form.querySelector('input[name="text"]');
                    if (!input.value.trim()) {
                        e.preventDefault();
                        alert('Inserisci un messaggio per chattare.');
                    }
                });
            });
        });
    </script>
@endsection