<x-layout>
    <x-form title="Login into your account" description="Welcome back.">
        <form action="/login" method="POST" class="mt-10 space-y-4">
            @csrf
            <x-form.field name="email" label="Email" type="email"/>
            <x-form.field name="password" label="Password" type="password"/>

            <button type="submit" class="w-full btn mt-2 h-10">Log In</button>
        </form>
    </x-form>
</x-layout>
