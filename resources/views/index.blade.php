@extends('layouts.master')

@section('title')
    Home Chat
@endsection

@section('sidebar')
    {{-- Qui poi metterȯ la possibilitȧ di cambiare user, per ora è un fake che trovi in chat controller --}}
    <h5>Chat & Groups di {{$user->username}} </h5>
    <ul class="list-group">
        @if(!isset($chats))
            <a class="list-group-item aol-list-item" href="#">New Chat</a>
        @else
            @foreach ($chats as $chat)
                <a class="list-group-item aol-list-item"
                    href="{{route('chat.specificChat', ['chat_selected' => $chat->id])}}">{{ $chat->chat_name }}</a>
            @endforeach
        @endif
        {{-- <li class="list-group-item aol-list-item">Utente1</li>
        <li class="list-group-item aol-list-item">Utente2</li>
        <li class="list-group-item aol-list-item aol-group">Gruppo1</li>
        <li class="list-group-item aol-list-item aol-group">Gruppo2</li> --}}
    </ul>
@endsection


@section('body')

@php
    $font = session('font', 'Tahoma');
    $fontSize = session('font_size', 14);
    $fontColor = session('font_color', '#000000');
    $bgColor = session('bg_color', '#ffffff');

    // TEMPORANEO
    $myId = 1;
@endphp

<div class="chat-box aol-chat-box"
    style="font-family: {{ $font }}; font-size: {{ $fontSize }}px; color: {{ $fontColor }}; background-color: {{ $bgColor }}">

    @if(!isset($msgs))
        <h1>Inizia a chattare!</h1>
    @else
    @foreach ($msgs as $msg)
        @foreach ($usernames as $u)
            @if ($u->id == $msg->sender_id)
                @php
                    $isMine = $u->id == $myId;
                    $alignment = $isMine ? 'text-end' : 'text-start';
                    $colorClass = 'user-color-' . ($u->id % 10);   //style.css HA I COLORI
                @endphp
                <p class="{{ $alignment }}">
                    <strong class="{{ $colorClass }}">{{ $u->username }}:</strong>
                    {{ $msg->getText() }}
                </p>
                @break
            @endif
        @endforeach
    @endforeach

    @endIf
</div>
<div class="input-group mt-3">
    <input type="text" class="form-control" placeholder="Scrivi qui il messaggio">
    <button class="btn aol-btn"><i class="bi bi-emoji-smile-fill"></i></button>
    <button class="btn aol-btn"><i class="bi bi-fonts"></i></button>
    <button class="btn aol-btn"><i class="bi bi-file-earmark-arrow-up-fill"></i></button>
    <button class="btn aol-btn-send"><i class="bi bi-caret-right-fill"></i></button>
</div>
@endsection