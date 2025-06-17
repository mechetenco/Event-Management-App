<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $event['name'] ?? 'Unnamed Event' }}</h5>
        <p class="card-text">
            <strong>Description:</strong> {{ $event['description'] ?? 'No description' }}<br>
            <strong>From:</strong> {{ \Carbon\Carbon::parse($event['start_time'])->format('M d, Y h:i A') }}<br>
            <strong>To:</strong> {{ \Carbon\Carbon::parse($event['end_time'])->format('M d, Y h:i A') }}
        </p>

        <a href="{{ route('events.show', $event['id']) }}" class="btn btn-sm btn-info">View</a>

        @php $authUserId = session('user_id'); @endphp
        @if(session('api_token') && (int)($event['user_id']) === (int)($authUserId))
            <a href="{{ route('events.edit', $event['id']) }}" class="btn btn-sm btn-warning">Edit</a>

            <form action="{{ route('events.destroy', $event['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this evnt?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        @endif
    </div>
</div>
