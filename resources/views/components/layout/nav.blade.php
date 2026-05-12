<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a href="/">
               @if(auth()->check() && auth()->user()->image_path)
                <img src="{{ Storage::url(auth()->user()->image_path) }}"
                class="w-10 h-10 rounded-full object-cover border"
                alt="Profile">
               @else
                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center border">
                    🐱
                </div>
                @endif
            </a>
        </div>

        <div class="flex gap-3 items-center">
            @auth
                <form method="POST" action="/logout">
                    @csrf
                    <button class="btn" type="submit">Log Out</button>
                </form>
               <!-- ====edit user profile==== -->
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <a href="{{ route('profile.edit') }}" class="btn" style="text-decoration: none; display: inline-block;">Edit Profile</a>
                </form>
            @endauth

            @guest
                <a href="/login">Sign In</a>
                <a href="/register" class="btn">Register</a>
            @endguest
        </div>
    </div>
</nav>
