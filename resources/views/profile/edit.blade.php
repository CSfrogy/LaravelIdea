<x-layout>
    <div class="max-w-4xl mx-auto">

        <header class="py-8 md:py-12 text-center">
            <h1 class="text-3xl font-bold">Edit Profile</h1>
            <p class="text-muted-foreground text-sm mt-2">
                Manage your account information and profile photo
            </p>
        </header>

        <div class="flex flex-col items-center gap-6">

            <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-foreground">
                @if (auth()->user()->image_path)
                    <img src="{{ Storage::url(auth()->user()->image_path) }}" class="w-full h-full object-cover"
                            alt="Profile Photo">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-muted text-4xl text-muted-foreground">
                        ?
                    </div>
                @endif
            </div>

            <x-card class="w-full max-w-md text-center">
                <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data"
                        class="flex flex-col gap-4">

                    @csrf
                    @method('PATCH')

                    <input type="file" name="image" class="border p-2 rounded w-full">

                    <button type="submit" class="btn">
                        Upload New Photo
                    </button>
                </form>
            </x-card>
        </div>

        <div class="mt-10 flex justify-center">

            <x-card class="w-full max-w-lg">

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm font-medium mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                class="w-full border p-2 rounded">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                class="w-full border p-2 rounded">
                        @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">New Password</label>
                        <input type="password" name="password" placeholder="Leave blank to keep current password"
                                class="w-full border p-2 rounded">
                        @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn w-full">
                        Update Profile
                    </button>
                </form>

            </x-card>

        </div>
    </div>
</x-layout>
