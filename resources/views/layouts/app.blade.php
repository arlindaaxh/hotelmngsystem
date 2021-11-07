<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fortify Example</title>
</head>
<body>
    <div>
        Nav goes here for app layout

        <ul>
            <li>
                <form methods="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        this.closest('form').submit();">
                        Logout
                    </a>

                </form>
            </li>
        </ul>
    </div>

    <div>
        {{ $slot }}
    </div>
    
</body>
</html>