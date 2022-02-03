<x-guest-layout>
    <h2>Login</h2>

    @if ($errors->any())

        <div>
            <div>Something went wrong</div>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>

                @endforeach
            </ul>
        </div>

    @endif

    <form action="/login" method="POST">
        @csrf

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}">
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>


        <div>
            <button>login</button>
        </div>
    </form>
</x-guest-layout>