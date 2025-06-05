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
    Home Chat
@endsection

@section('sidebar')
    @if (auth()->check())
        <input type="text" id="chatSearch" class="form-control mb-3 aol-input" placeholder="Cerca chat...">
        <h5>Chat & Groups di {{auth()->user()->name}} </h5>
        <ul class="list-group aol-group" id="chatList">

            @foreach ($chats as $chat)
                <li class="list-group-item aol-list-item">
                    <a href="{{ route('chat.specificChat', ['chat_selected' => $chat->id]) }}"
                        class="d-block text-decoration-none text-body">
                        {{ $chat->chat_name }}
                    </a>
                </li>
            @endforeach

        </ul>
    @else
        <h5>Login to see chats</h5>
    @endif

    <script>
        $(document).ready(function () {
            $('#chatSearch').on('keyup', function () {
                var search = $(this).val().toLowerCase();

                $('#chatList li').each(function () {
                    var name = $(this).text().toLowerCase();
                    $(this).toggle(name.includes(search));
                });
            });
        });

    </script>
@endsection


@section('navbar')
    @if (isset($current_chat) && @auth()->user()->role == 'admin')
        <!-- Modal: Rename Chat Logic -->
        <div class="modal fade" id="renameChatModal" tabindex="-1" aria-labelledby="renameChatModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('chat.rename') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_chat" value="{{ $current_chat->id }}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title aol-text" id="renameChatModalLabel">Rinomina Chat:
                                {{$current_chat->chat_name}}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="chat_name" class="form-label aol-text">Nuovo nome</label>
                                <input type="text" class="form-control" name="chat_name" id="chat_name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                            <button type="submit" class="btn btn-primary">Salva</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Serve controllare dato che appena entrati non c'è alcuna chat selezionata --}}

        <li class="nav-item"><a class="nav-link" href="{{ route('chat.manageUsers', $current_chat) }}">
                [Add/remove user to chat]
                {{-- VEDI qui se è ok mandare tutta la chat o basta l' id --}}
            </a></li>
        <li class="nav-item">
            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#renameChatModal">
                [Change Chat Name]
            </a>
        </li>

    @endif
@endsection


@section('body')

@php
    $font = session('font', 'Tahoma');
    $fontSize = session('font_size', 14);
    $fontColor = session('font_color', '#000000');
    $bgColor = session('bg_color', '#ffffff');

    // TEMPORANEO; Usato SOLO per mettere a destra il proprio nome. Le chat del user sono decise da $user, variabile di sessione

@endphp
@if (isset($current_chat))
    <h4 class="aol-chat-name">Chat: {{$current_chat->chat_name}}</h4>
@endif
<div class="chat-box aol-chat-box" id="messages-container"
    style="font-family: {{ $font }}; font-size: {{ $fontSize }}px; color: {{ $fontColor }}; background-color: {{ $bgColor }}; overflow-y: auto;">


    @if(!isset($msgs) || $msgs->isEmpty())
        <h1>Inizia a chattare!</h1>
    @else
    @foreach ($msgs as $msg)
        @php
            $u = $msg->user; // Ottieni l'utente direttamente dalla relazione
            $isMine = $u->id == auth()->user()->id;
            $alignment = $isMine ? 'text-end' : 'text-start';
            $colorClass = 'user-color-' . ($u->id % 10);   //style.css ha i colori
        @endphp

        <p class="{{ $alignment }}">
            <strong class="{{ $colorClass }}">{{ $u->name }}:</strong>
            {{ $msg->text }}
        </p>
    @endforeach


    @endIf
</div>
<div class="input-group mt-3">
    @if (auth()->check())
        <form action="{{ route('message.store') }}" method="POST" class="input-group mt-3 ">
            @if (isset($current_chat))
                @csrf
                <input type="hidden" name="id_sender" value="{{ auth()->user()->id }}">

                <input type="hidden" name="id_chat" value="{{ $current_chat->id }}">

                <input type="text" name="text" class="form-control aol-input" placeholder="Scrivi qui il messaggio" required>

                <button class="btn aol-btn"><i class="bi bi-emoji-smile-fill"></i></button>
                <button class="btn aol-btn"><i class="bi bi-fonts"></i></button>
                <button class="btn aol-btn"><i class="bi bi-file-earmark-arrow-up-fill"></i></button>
                <button class="btn aol-btn-send"><i class="bi bi-caret-right-fill"></i></button>
            @endif
        </form>
    @else
        <h5>Login to write</h5>
    @endif
</div>

<script>
    $(document).ready(function () {
        // Salva e ripristina il contenuto del campo input
        function saveInputContent() {
            const inputValue = $('input[name="text"]').val();
            const hasFocus = $('input[name="text"]').is(':focus');
            sessionStorage.setItem('messageInput', inputValue); //storage!
            sessionStorage.setItem('inputHasFocus', hasFocus);
        }

        function restoreInputContent() {
            const savedValue = sessionStorage.getItem('messageInput');
            const hadFocus = sessionStorage.getItem('inputHasFocus') === 'true';

            if (savedValue) {
                $('input[name="text"]').val(savedValue);
            }

            if (hadFocus) {
                $('input[name="text"]').focus();
            }
        }

        // Vai in fondo alla chat
        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }

        // Salva il contenuto ogni volta che l'utente scrive
        $('input[name="text"]').on('input focus blur', function () {
            saveInputContent();
        });

        // Cancella il contenuto salvato quando si invia il messaggio
        $('form').on('submit', function () {
            sessionStorage.removeItem('messageInput');
            sessionStorage.removeItem('inputHasFocus');
        });

        // Ripristina tutto al caricamento della pagina
        restoreInputContent();
        scrollToBottom();

        // Aggiorna la pagina ogni 3 secondi
        setInterval(function () {
            window.location.reload();
        }, 20000);
    });
</script>

@endsection