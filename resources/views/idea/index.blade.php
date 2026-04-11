@php use App\IdeaStatus; @endphp
<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Meet our news</h1>
            <p class="text-muted-foreground text-sm mt-2">Learn something new for yourself.</p>
        </header>

        <div>
            <a href="/ideas" class="btn {{request()->has('status') ? 'btn-outlined' : '' }}">All</a>

            @foreach(IdeaStatus::cases() as $status)
                <a href="/ideas?status={{  $status->value }}"
                        class="btn {{ request('status') === $status->value ? '' : 'btn-outlined'}}"
                >
                    {{ $status->label() }} <span
                            class="text-xs pl-3">{{ $statusCounts->get($status->value) }}</span></a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($ideas as $idea)
                    <x-card href="{{ route('idea.show', $idea) }}">
                        <h3 class="text-foreground text-lg">{{ $idea->title }}</h3>

                        <x-idea.status class="mt-2" status="{{ $idea->status }}">
                            {{ $idea->status->label()}}
                        </x-idea.status>

                        <div class="mt-5 line-clamp-3">{{ $idea->description }}</div>
                        <div class="mt-4">{{ $idea->created_at->diffForHumans() }}</div>
                    </x-card>
                @empty
                    <x-card>
                        <p>No Ideas yet!</p>
                    </x-card>
                @endforelse
            </div>
        </div>
    </div>
</x-layout>
