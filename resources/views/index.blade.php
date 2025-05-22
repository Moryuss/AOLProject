@extends('layouts.master')

@section('title')
    Home Chat
@endsection

@section('sidebar')
    {{-- Qui poi metterȯ la possibilitȧ di cambiare user, per ora è un fake che trovi in chat controller --}}
    @if (auth()->check())
        <h5>Chat & Groups di {{auth()->user()->name}} </h5>
        <ul class="list-group">
            @if(!isset($chats))
                <a class="list-group-item aol-list-item" href="#">New Chat</a>
            @else
                @foreach ($chats as $chat)
                    <a class="list-group-item aol-list-item"
                        href="{{route('chat.specificChat', ['chat_selected' => $chat->id])}}">{{ $chat->chat_name }}</a>

                @endforeach
            @endif
        </ul>
    @else
        <h5>Login to see chats</h5>
    @endif

@endsection


@section('body')

@php
    $font = session('font', 'Tahoma');
    $fontSize = session('font_size', 14);
    $fontColor = session('font_color', '#000000');
    $bgColor = session('bg_color', '#ffffff');

    // TEMPORANEO; Usato SOLO per mettere a destra il proprio nome. Le chat del user sono decise da $user, variabile di sessione
    $myId = 3;
@endphp

<div class="chat-box aol-chat-box"
    style="font-family: {{ $font }}; font-size: {{ $fontSize }}px; color: {{ $fontColor }}; background-color: {{ $bgColor }}">
    {{--
    <pre>{{ dd($msgs) }}</pre> //Debug, il msg c'è --}}

    @if(!isset($msgs) || $msgs->isEmpty())
        <h1>Inizia a chattare!</h1>
    @else
    @foreach ($msgs as $msg)
        @php
            $u = $msg->user; // Ottieni l'utente direttamente dalla relazione
            $isMine = $u->id == $myId;
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
        <form action="{{ route('message.store') }}" method="POST" class="input-group mt-3">
            @csrf
            <input type="hidden" name="id_sender" value="{{ auth()->user()->id }}">
            @if (isset($current_chat_id))
                <input type="hidden" name="id_chat" value="{{ $current_chat_id }}">
            @endif
            <input type="text" name="text" class="form-control" placeholder="Scrivi qui il messaggio" required>

            <button class="btn aol-btn"><i class="bi bi-emoji-smile-fill"></i></button>
            <button class="btn aol-btn"><i class="bi bi-fonts"></i></button>
            <button class="btn aol-btn"><i class="bi bi-file-earmark-arrow-up-fill"></i></button>
            <button class="btn aol-btn-send"><i class="bi bi-caret-right-fill"></i></button>
        </form>
    @else
        <h5>Login to write</h5>
    @endif
</div>



@endsection