@if ($notifications->isEmpty())
    <div class="d-flex justify-content-center">
        <p>No Notifications Found.</p>
    </div>
@else
    @foreach ($notifications as $notification)
        <a href="{{ route('opportunity-state.show', $notification->opportunity_state_id) }}" class="text-black" onclick="event.preventDefault(); document.getElementById('read-notification-{{ $notification->id }}').submit();">
            <form action="{{ route('notification.mark-as-read', $notification->id) }}" method="post" id="read-notification-{{ $notification->id }}" style="display: none;">
                @csrf
                @method('PUT')
            </form>
            <div class="pt-2 pb-2 border-bottom">
                <div class="d-flex justify-content-between">
                    <h6 class="fw-bold">{{ $notification->opportunityState->title }}</h6>
                    <small class="float-right">
                        @if ($notification->created_at->format('Y-m-d') == now()->format('Y-m-d'))
                            {{ $notification->created_at->diffForHumans() }}
                        @elseif ($notification->created_at->diffInDays(now()) < 7)
                            {{ $notification->created_at->format('l') }}
                        @else
                            {{ $notification->created_at->format('Y/m/d') }}
                        @endif
                    </small>
                </div>
                <small>Status: {{ getOpportunityStatus($notification->opportunityState->opportunity_status_id) }}</small>
                <p class="mb-0">{{ $notification->opportunityState->description }}</p>
            </div>
        </a>
    @endforeach
@endif
