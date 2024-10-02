<div class="col-md-12 col-lg-6">
    <div class="card" data-aos="fade-up" data-aos-delay="1000">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <div class="header-title">
                <h4 class="card-title">Earnings Detail</h4>
            </div>
            <div class="dropdown">
                <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButtonEarningOverview" data-bs-toggle="dropdown" aria-expanded="false">
                    Last 24 Hours
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButtonEarningOverview">
                    <li><a class="dropdown-item earning-overview" href="#">Last 24 Hours</a></li>
                    <li><a class="dropdown-item earning-overview" href="#">Last 7 Days</a></li>
                    <li><a class="dropdown-item earning-overview" href="#">Last 30 Days</a></li>
                    <li><a class="dropdown-item earning-overview" href="#">Last 60 Days</a></li>
                    <li><a class="dropdown-item earning-overview" href="#">Last 90 Days</a></li>
                    <li><a class="dropdown-item earning-overview" href="#">All Time</a></li>
                    <li><a class="dropdown-item earning-overview" id="custom-filter-earning-overview" href="#">Custom</a></li>
                </ul>
            </div>
            <!-- Custom date range picker (hidden by default) -->
            <div id="custom-date-range-earning-overview" style="display: none; margin-top: 10px;">
                <label>Start Date: </label>
                <input type="date" id="start-date-earning-overview">
                <label>End Date: </label>
                <input type="date" id="end-date-earning-overview">
                <button id="apply-custom-date-earning-overview" class="btn btn-primary">Apply</button>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
                <div id="earning-overview" class="earning-overview"></div>
            </div>
        </div>
    </div>
</div>