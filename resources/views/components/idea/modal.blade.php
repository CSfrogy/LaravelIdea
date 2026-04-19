@php use App\IdeaStatus; @endphp
@props(['idea' => new App\Models\Idea()])

<x-modal name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}"
    title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}">
    <form x-data="{
                    status: @js(old('status', $idea->status->value)),
                    newLink: '',
                    links: @js(old('links', $idea->links ?? [])),
                    newStep: '',
                    steps: @js(old('steps', $idea->steps->map->only(['id', 'description','completed']))),
                    hasImage: false
                }" method="POST" action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        x-bind:enctype="hasImage ? 'multipart/form-data' : false">
        @csrf
        @if($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-form.field label="Title" name="title" placeholder="Enter an idea for your title" autofocus required
                :value="$idea->title" />
            <div class="space-y-2">
                <label for="status" class="label">Status</label>
                <div class="flex gap-x-3">
                    @foreach(IdeaStatus::cases() as $status)
                        <button type="button" @click="status = @js($status->value)"
                            data-test="button-status-{{ $status->value }}" class="btn flex-1 h-10"
                            :class="status === @js($status->value) ? '' : 'btn-outlined'">
                            {{ $status->label() }}
                        </button>
                    @endforeach

                    <input type="hidden" name="status" :value="status" class="input">
                </div>

                <x-form.error name="{{ $status }}" />

            </div>

            <x-form.field label="Description" name="description" type="textarea" placeholder="Describe your own idea..."
                required autofocus :value="$idea->description" />
            <div class="space-y-2">
                <label for="image" class="label">Image</label>

                @if($idea->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/'.$idea->image_path) }}" alt="{{ $idea->title }}"
                            class="w-full h-48 object-cover rounded-lg" />
                        <button class="w-full h-10 btn btn-outlined" form="delete-image-form">Remove Image
                        </button>
                    </div>
                @endif

                <input type="file" name="image" accept="image/*" @change="hasImage = $event.target.files.length > 0" />


                <x-form.error name=" image" />
            </div>
            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Actionable Steps</legend>


                    <template x-for="(step, index) in steps" :key="index">
                        <div class="flex gap-x-2 items-center">
                            <input class="input" :name="`steps[${index}][description]`" x-model="step.description"
                                readonly>
                            <input type="hidden" class="input" :name="`steps[${index}][completed]`"
                                :value="step.completed ? '1' : '0'" readonly>


                            <button type="button" @click="steps.splice(index, 1)" class="form-muted-icon"
                                aria-label="Remove step">
                                <x-icons.close />
                            </button>
                        </div>
                    </template>


                    <div class="flex gap-2 items-center">
                        <input x-model="newStep" id="new-step" data-test="new-step" placeholder="What needs to be done"
                            class="input flex-1" spellcheck="false">
                        <button type="button" @click="steps.push({description: newStep.trim(), completed: false}); newStep = '';"
                            :disabled="newStep.trim().length === 0" aria-label="Add a new step" class="form-muted-icon"
                            data-test="submit-new-step-button">
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>
                </fieldset>
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>


                    <template x-for="(link, index) in links" :key="link">
                        <div class="flex gap-x-2 items-center">
                            <input class="input" name="links[]" x-model="link">


                            <button type="button" @click="links.splice(index, 1)" class="form-muted-icon"
                                aria-label="Remove link">
                                <x-icons.close />
                            </button>
                        </div>
                    </template>


                    <div class="flex gap-2 items-center">
                        <input x-model="newLink" type="url" id="new-link" data-test="new-link"
                            placeholder="http://example.com" autocomplete="url" class="input flex-1" spellcheck="false">
                        <button type="button" @click="links.push(newLink.trim()); newLink = '';"
                            :disabled="newLink.trim().length === 0" aria-label="Add link" class="form-muted-icon"
                            data-test="submit-new-link-button">
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>
                </fieldset>
            </div>


            <div class="flex justify-end gap-x-5">
                <button type="button" class="btn btn-danger btn-outlined" @click="$dispatch('close-modal')">
                    Cancel
                </button>
                <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>

        </div>
    </form>
    @if($idea->image_path)
        <form method="POST" action="{{ route('idea.image.destroy', $idea) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
