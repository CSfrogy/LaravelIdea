<x-layout>
    <div style="padding: 1.5rem; max-width: 860px;">

        <h1 style="font-size: 22px; font-weight: 500; color: var(--color-foreground); margin-bottom: 1.5rem;">
            Admin dashboard
        </h1>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 12px; margin-bottom: 1.5rem;">
            <x-card>
                <div class="stat-label">Total users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </x-card>
            <x-card>
                <div class="stat-label">Total ideas</div>
                <div class="stat-value">{{ $totalIdeas }}</div>
            </x-card>
            <x-card>
                <div class="stat-label">Pending ideas</div>
                <div class="stat-value" style="color: var(--color-error);">{{ $pendingIdeas }}</div>
            </x-card>
        </div>


        <p class="section-label">Recent ideas</p>
        <x-admin.ideas-table :ideas="$recentIdeas"/>
        @foreach($recentIdeas as $idea)
            <x-idea.modal :idea="$idea"/>
        @endforeach
    </div>
</x-layout>
