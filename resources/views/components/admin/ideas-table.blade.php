@props(['ideas'])

<div class="table-wrap">
    <table>
        <thead>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Status</th>
            <th>Date</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($ideas as $idea)
            <tr>
                <td>{{ $idea->title }}</td>
                <td>{{ $idea->user->name }}</td>
                <td>
                        <span class="badge badge-{{ $idea->status->value }}">
                            {{ $idea->status->label() }}
                        </span>
                </td>
                <td class="muted">{{ $idea->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('idea.show', $idea) }}?edit=true" class="btn btn-outlined">
                        Edit Idea
                    </a>
                </td>
                <td>
                    <form method="POST" action="{{ route('idea.destroy', $idea) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outlined btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
