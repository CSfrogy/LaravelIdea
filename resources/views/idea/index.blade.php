@php use App\IdeaStatus; @endphp
<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Meet our news</h1>
            <p class="text-muted-foreground text-sm mt-2">Learn something new for yourself.</p>


            <x-card x-data @click="$dispatch('open-modal','create-idea')" is="button" type="button"
                    data-test="create-idea-button" class="mt-5 cursor-pointer h-32 text-center w-full">
                <h1 class="text-2xl">What is Your Idea?</h1>
                <p class="text-muted-foreground">Click here to open the form for idea!</p>
            </x-card>
        </header>

        <div>
            <a href="/ideas" class="btn {{request()->has('status') ? 'btn-outlined' : '' }}">All</a>

            @foreach(IdeaStatus::cases() as $status)
                <a href="/ideas?status={{  $status->value }}"
                        class="btn {{ request('status') === $status->value ? '' : 'btn-outlined'}}">
                    {{ $status->label() }} <span
                            class="text-xs pl-3">{{ $statusCounts->get($status->value) }}</span></a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6">
                @forelse($ideas as $idea)
                    <x-card href="{{ route('idea.show', $idea) }}">
                        @if($idea->image_path)
                            <div class="mb-4 -mx-4 -mt-4 rounded-t-lg overflow-hidden">
                                <img src="{{ asset('storage/'.$idea->image_path) }}" alt="Image"
                                        class="w-full h-48 object-cover "/>
                            </div>
                        @endif
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

        <x-idea.modal/>
    </div>
</x-layout>
