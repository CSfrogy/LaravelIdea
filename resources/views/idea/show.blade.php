<x-layout>
    <div class="py-8 max-w-4xl mx-auto">
        <div class="flex justify-between items-center">
            <button class="btn btn-ghost">
                <a href="{{ route('idea.index') }}" class="flex items-center gap-x-2 text-sm font-medium">
                    <x-icons.arrow-back/>
                    Back to Ideas
                </a>
            </button>

            <div class="gap-3 flex items-center">
                <button
                        x-data
                        class="btn btn-outlined"
                        data-test="edit-idea-button"
                        @click="$dispatch('open-modal','edit-idea')"
                >
                    <x-icons.external/>
                    Edit Idea
                </button>
                <form method="POST" action="{{ route('idea.destroy', $idea) }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outlined btn-danger">Delete</button>
                </form>
            </div>

        </div>
        <div class="mt-8 spacy-y-6">
            @if($idea->image_path)
                <div class="rounded-lg overflow-hidden shadow-md border border-border">
                    <img src="{{ asset('storage/'.$idea->image_path) }}" alt="Image"
                            class="w-full max-h-[480px] object-cover "/>
                </div>
            @endif
            <h1 class="font-bold text-4xl">{{ $idea->title }}</h1>

            <div class="mt-2 flex gap-x-3 items-center">
                <x-idea.status :status="$idea->status->value">{{ $idea->status->label() }}</x-idea.status>
                <div class="text-muted-foreground text-sm">{{ $idea->created_at->diffForHumans() }}</div>
            </div>

            @if($idea->description)
                <x-card class="mt-6">
                    <div class="text-foreground max-w-none cursor-pointer">{{ $idea->description }}</div>
                </x-card>
            @endif
            @if($idea->steps->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Actionable Steps</h3>
                    <div class="mt-5 space-y-2">
                        @foreach($idea->steps as $step)
                            <x-card>
                                <form method="POST" action="{{ route('step.update', $step) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center gap-x-3">
                                        <button type="submit" role="checkbox"
                                                class="size-5 flex items-center justify-center rounded-lg text-primary-foreground border border-primary {{ $step->completed ? 'bg-primary' : 'border border-primary' }}">
                                            &check;
                                        </button>
                                        <span
                                                class="{{ $step->completed ? 'line-through text-muted-foreground' : ''}}">{{ $step->description }}</span>
                                    </div>
                                </form>
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($idea->links?->count())
                <div>
                    <h3 class="font-bold text-xl mt-6">Links</h3>
                    <div class="mt-5 space-y-2">
                        @foreach($idea->links as $link)
                            <x-card :href="$link" class="text-primary-hover font-medium flex gap-x-3 items-center">
                                <x-icons.external/>
                                {{ $link }}
                            </x-card>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>


        <x-idea.modal :idea="$idea"/>
    </div>
</x-layout>
