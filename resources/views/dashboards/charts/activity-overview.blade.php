<div class="card" data-aos="fade-up" data-aos-delay="400">
    <div class="card-header d-flex justify-content-between flex-wrap">
        <div class="header-title">
            <h4 class="card-title mb-2">Activity Overview</h4>
            <p class="mb-0">
                @if ($percentageOfTenRecentOpportunities > 0)
                    <svg class ="me-2" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#1aa053" d="M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z" />
                    </svg>
                @else
                    <svg class ="me-2" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#c03221" d="M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z" transform="rotate(180, 12, 12)" />
                    </svg>
                @endif
                {{ $percentageOfTenRecentOpportunities }}% this month
            </p>
        </div>
    </div>
    <div class="card-body">
        @foreach ($tenRecentOpportunities as $item)
            <div class=" d-flex profile-media align-items-top mb-2">
                <div class="profile-dots-pills border-primary mt-1"></div>
                <div class="ms-4">
                    <h6 class=" mb-1">Rp{{ formatCurrency($item->opportunity_value) }} - {{ getOpportunityStatusNameById($item->opportunity_status_id) }}</h6>
                    <span class="mb-0">{{ $item->created_at->format('d M, H:i') }}</span>
                </div>
            </div>
        @endforeach
    </div>
</div>