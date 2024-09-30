<div class="col-md-12">
    <div class="card" data-aos="fade-up" data-aos-delay="800">
        <div class="card-header d-flex justify-content-between flex-wrap">
            <div class="header-title">
                <h4 class="card-title">Total: </h4>
                <h6 class="card-title text-success completed">Completed: </h6>
                <h6 class="card-title text-danger failed">Failed: </h6>
            </div>
            <div class="dropdown">
                <a href="#" class="text-gray dropdown-toggle" id="dropdownMenuButtonChartEarning" data-bs-toggle="dropdown" aria-expanded="false">
                    Last 24 Hours
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButtonChartEarning">
                    <li><a class="dropdown-item chart-earning" href="#">Last 24 Hours</a></li>
                    <li><a class="dropdown-item chart-earning" href="#">Last 7 Days</a></li>
                    <li><a class="dropdown-item chart-earning" href="#">Last 30 Days</a></li>
                    <li><a class="dropdown-item chart-earning" href="#">Last 60 Days</a></li>
                    <li><a class="dropdown-item chart-earning" href="#">Last 90 Days</a></li>
                    <li><a class="dropdown-item chart-earning" href="#">All Time</a></li>
                    <li><a class="dropdown-item chart-earning" id="custom-filter-chart-earning" href="#">Custom</a></li>
                </ul>
            </div>
            <!-- Custom date range picker (hidden by default) -->
            <div id="custom-date-range-chart-earning" style="display: none; margin-top: 10px;">
                <label>Start Date: </label>
                <input type="date" id="start-date-chart-earning">
                <label>End Date: </label>
                <input type="date" id="end-date-chart-earning">
                <button id="apply-custom-date-chart-earning" class="btn btn-primary">Apply</button>
            </div>
        </div>
        <div class="card-body">
            <div id="chart-earning" class="chart-earning"></div>
        </div>
    </div>
</div>