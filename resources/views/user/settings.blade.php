@extends('layouts.master')

@section('title', 'Centro impostazioni')

@section('sidebar')
    <h5>Impostazioni</h5>
    <ul class="list-group">
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 1)}}">👥 Elenco Amici</a>
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 2)}}">💬 Stato personale</a>
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 3)}}">🔒 Utenti Bloccati</a>
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 4)}}">🔔 Notifiche</a>
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 5)}}">🎨 Personalizzazione</a>
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 6)}}">🔧 Admin Upgrade</a>

    </ul>
@endsection

@section('body')
    <div class="aol-chat-box">
        @if(!isset($setting_selected))
        <h4>Centro Utente</h4>
        <p>Gestisci qui il tuo profilo e le preferenze chat.</p>
        @else
        @switch($setting_selected)

        @case(1)
        <!-- Elenco Amici -->
        <h5>👥 Amici</h5>
        <ul class="list-group mb-2">
            <li class="list-group-item">Utente1</li>
            <li class="list-group-item">Utente2</li>
        </ul>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Aggiungi nuovo amico">
            <button class="btn aol-btn-send" disabled>Aggiungi (disabled)</button>
        </div>
        @break


        @case(2)
        <!-- Stato personale -->
        <h5>💬 Stato personale</h5>
        <input type="text" class="form-control mb-3" placeholder="Es. 🎧 ascolto Musica">
        @break


        @case(3)
        <!-- Privacy -->
        <h5>🔒 Utenti bloccati</h5>
        <ul class="list-group mb-3">
            <li class="list-group-item">SpamBot42</li>
        </ul>
        <button class="btn btn-outline-danger btn-sm mb-4" disabled>Gestisci (disabled)</button>
        @break


        @case(4)
        <!-- Notifiche -->
        <h5>🔔 Suoni di notifica</h5>
        <select class="form-select mb-4">
            <option selected>✨ Ding (default)</option>
            <option>📢 AOL Classic</option>
            <option>📯 Retro Beep</option>
            <option>🔕 Nessuno</option>
        </select>
        @break

        @case(5)
        <!-- Personalizzazione chat -->
        <h5>🎨 Personalizzazione</h5>
        @php
            $font = session('font', 'Tahoma');
            $fontSize = session('font_size', 14);
            $fontColor = session('font_color', '#000000');
            $bgColor = session('bg_color', '#ffffff');

            // ADD more font HERE
            $fonts = ['Tahoma', 'Verdana', 'Comic Sans MS', 'Courier New'];
        @endphp
       
        

        <div class="chat-box" 
        style="font-family: {{ $font }}; font-size: {{ $fontSize }}px; color: {{ $fontColor }}; background-color: {{ $bgColor }}">
        Testo di esempio
        </div>
        
        <form action="{{ route('setting.update') }}" method="POST">
            @csrf
            
            {{-- BACKGROUND COLOR --}}
            <div class="mb-3">
                <label for="chatColor" class="form-label" >Colore sfondo:</label>
                <input type="color" id="chatColor" class="form-control form-control-color" name="bg_color" value="{{ $bgColor }}">
            </div>
            
            {{-- FONT --}}
            <div class="mb-3">
                <label for="chatFont" class="form-label">Font:</label>
                <select id="chatFont" name="font" class="form-select">
                    @foreach ($fonts as $f)
                        <option value="{{ $f }}" {{ $f === $font ? 'selected' : '' }}>
                            {{ $f }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FONT SIZE --}}
            <div class="mb-3">
                <label for="fontSize" class="form-label">Dimensione testo:</label>
                <input type="number" name="font_size" class="form-control" id="fontSize" value="{{ $fontSize}}">
            </div>

            {{-- FONT COLOR --}}
            <div class="mb-3">
                <label for="fontColor" class="form-label" >Colore testo:</label>
                <input type="color" id="fontColor" class="form-control form-control-color" name="font_color" value="{{ $fontColor }}">
            </div>

            <button class="btn aol-btn-send">Salva</button>
        </form>
        @break

         @case(6)
        <!-- Per diventare Admin-->
        <h5>Admin Upgrade</h5>
        @if(auth()->user()->role == 'basic_user')
            <h6>Per diventare admin devi passare il <strong>trial del fuoco</strong></h6>
            <form action="{{ route('user.evolve') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm mb-4">EVOLVE</button>
            </form>
        @elseif(auth()->user()->role == 'admin')
        <h1>La tua avarizia non ha limite. ADMIN {{auth()->user()->name}} non troverai nulla qui tranne ...</h1>
        <form action="{{ route('user.humble') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm mb-4">BE HUMBLED</button>
            </form>
        @endIf

        @break

        @default
        <h1>Impostazione invalida</h1>
        <h4>Centro Utente</h4>
        <p>Gestisci qui il tuo profilo e le preferenze chat.</p>

        @endswitch
        @endif 
    </div>
@endsection