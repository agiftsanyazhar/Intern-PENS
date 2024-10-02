<div class="card" data-aos="fade-up" data-aos-delay="300">
    <div class="card-header d-flex justify-content-between flex-wrap">
        <div class="header-title">
            <h4 class="card-title">Opportunities<br>and Customers</h4>
        </div>
        <div class="dropdown">
            <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButtonChartOpportunity" data-bs-toggle="dropdown" aria-expanded="false">
                Last 24 Hours
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButtonChartOpportunity">
                <li><a class="dropdown-item chart-opportunity" href="#">Last 24 Hours</a></li>
                <li><a class="dropdown-item chart-opportunity" href="#">Last 7 Days</a></li>
                <li><a class="dropdown-item chart-opportunity" href="#">Last 30 Days</a></li>
                <li><a class="dropdown-item chart-opportunity" href="#">Last 60 Days</a></li>
                <li><a class="dropdown-item chart-opportunity" href="#">Last 90 Days</a></li>
                <li><a class="dropdown-item chart-opportunity" href="#">All Time</a></li>
                <li><a class="dropdown-item chart-opportunity" id="custom-filter-chart-opportunity" href="#">Custom</a></li>
            </ul>
        </div>
        <!-- Custom date range picker (hidden by default) -->
        <div id="custom-date-range-chart-opportunity" style="display: none; margin-top: 10px;">
            <label>Start Date: </label>
            <input type="date" id="start-date-chart-opportunity">
            <label>End Date: </label>
            <input type="date" id="end-date-chart-opportunity">
            <button id="apply-custom-date-chart-opportunity" class="btn btn-primary">Apply</button>
        </div>
    </div>
    <div class="card-body d-flex justify-content-around text-center">
        <div>
            <h2 class="mb-2 opportunities">750K</h2>
            <p class="mb-0 text-gray">New Opportunities</p>
        </div>
        <hr class="hr-vertial">
        <div>
            <h2 class="mb-2 customers">7,500</h2>
            <p class="mb-0 text-gray">New Customers</p>
        </div>
    </div>
</div>