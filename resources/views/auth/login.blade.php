
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div>
        <label for="identification">Usuario</label>
        <input type="identification" name="identification" value="{{ old('identification') }}" required autofocus>
        @error('identification')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" required>
    </div>

    <button type="submit">Login</button>
</form>