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

@section('title', 'Centro impostazioni')

@section('sidebar')
    <h5>Impostazioni</h5>
    <ul class="list-group">
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 1)}}">👥 Elenco Amici</a>
        <a class="list-group-item aol-list-item" href="{{route('settings.sidebarSetting', 2)}}">💬 Stato personale</a>
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
           @foreach(auth()->user()->friends as $friend)
            <li class="list-group-item">
                <span class="badge bg-primary">{{ $friend->status }}</span>
                {{ $friend->name }}  ---- ID:  <strong>{{ $friend->id }}</strong>
                
                <form action="{{ route('friend.remove', $friend->id) }}" method="POST" class="float-end">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm">Rimuovi</button>
                </form>
            </li>
           @endforeach
        </ul>
        <div class="input-group mb-3">
            <form action="{{ route('friend.add') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="id_friend" class="form-label">Seleziona Utente</label>
                    <select name="id_friend" class="form-select" required>
                        <option value="">-- Scegli un utente --</option>
                                @foreach($allUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Aggiungi Amico</button>
                       <!-- Messaggi di stato/errore -->
                @if(session('status'))
                    <div class="alert alert-success mt-2">
                        {{ session('status') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-2">
                        {{ session('error') }}
                    </div>
                @endif
                    </form>
        </div>
        @break


        @case(2)
        <!-- Stato personale -->
        <h5>💬 Stato personale</h5>
        <form action="{{ route('user.status.update') }}" method="POST">
            @csrf
            <input type="text" class="form-control mb-3" name="status" placeholder="Es. 🎧 ascolto Musica" value="{{ auth()->user()->status ?? '' }}">
            <button class="btn aol-btn-send mb-4">Aggiorna</button>
        </form>

        <div> <h6><i class="bi bi-person-bounding-box"></i> ID utente: <strong>{{ auth()->user()->id }}</strong></h6></div>

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
        @if(auth()->user()->role == 'basic_user')
            <div class="card mb-4">
                <div class="card-header">Diventa Admin</div>
                <div class="card-body">
                    <form action="{{ route('admin.upgrade') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="secret_password" class="form-label">Password Segreta</label>
                            <input type="password" class="form-control" name="secret_password" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Verifica e Diventa Admin</button>
                    </form>
                </div>
            </div>

        @elseif(auth()->user()->role === 'admin')
            <div class="card">
                <div class="card-header">Promuovi Utente</div>
                <div class="card-body">
                    <form action="{{ route('admin.promote') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Seleziona Utente</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Scegli un utente --</option>
                                @foreach($basicUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} (ID: {{ $user->id }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-danger">Promuovi ad Admin</button>
                    </form>
                </div>
            </div>
        @endif

    <!-- Messaggi di stato -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

        @break

        @default
        <h1>Impostazione invalida</h1>
        <h4>Centro Utente</h4>
        <p>Gestisci qui il tuo profilo e le preferenze chat.</p>

        @endswitch
        @endif 
    </div>
@endsection