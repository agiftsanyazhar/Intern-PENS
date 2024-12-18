(function (jQuery) {
    "use strict";

    function formatCurrency(value) {
        if (value >= 1000000000000) {
            return `${(value / 1000000000000).toFixed(2).replace(".", ",")}T`;
        } else if (value >= 1000000000) {
            return `${(value / 1000000000).toFixed(2).replace(".", ",")}M`;
        } else if (value >= 1000000) {
            return `${(value / 1000000).toFixed(2).replace(".", ",")}Jt`;
        } else if (value >= 1000) {
            return `${(value / 1000).toFixed(2).replace(".", ",")}Rb`;
        }
        return value;
    }

    if (document.querySelectorAll("#chart-earning").length) {
        let selectedTimeFilter = "last_24_hours"; // Default time filter

        const updateChart = (timeFilter, startDate = null, endDate = null) => {
            let url = `/earning?filter=${timeFilter}`;
            if (timeFilter === "custom" && startDate && endDate) {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }

            fetch(url, {
                method: "GET",
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((response) => response.json())
                .then((data) => {
                    const categories = Object.keys(data.totalEarnings); // Use dates as categories
                    const totalSeries = Object.values(data.totalEarnings);
                    const completedSeries = Object.values(
                        data.completedEarnings
                    );
                    const failedSeries = Object.values(data.failedEarnings);

                    // Update the chart with multiple series
                    const newOptions = {
                        series: [
                            { name: "Total Earning", data: totalSeries },
                            { name: "Completed", data: completedSeries },
                            { name: "Failed", data: failedSeries },
                        ],
                        xaxis: { categories: categories },
                    };

                    chart.updateOptions(newOptions);

                    // Utility function to filter out non-numeric values and sum the numeric ones
                    const sumSeries = (series) => {
                        return series
                            .filter((value) => !isNaN(value)) // Keep only numeric values
                            .reduce((a, b) => a + Number(b), 0); // Sum up the numbers
                    };

                    // 1. Calculate totalSum: sum of completedSeries + failedSeries
                    // 2. Calculate completedSum: sum of completedSeries only
                    // 3. Calculate failedSum: sum of failedSeries only
                    const totalSum = sumSeries(totalSeries);
                    const completedSum = sumSeries(completedSeries);
                    const failedSum = sumSeries(failedSeries);

                    // Now update the DOM with the respective sums
                    document.querySelector(
                        ".card-title"
                    ).textContent = `Total Earning: Rp${formatCurrency(
                        totalSum
                    )}`;
                    document.querySelector(
                        ".completed"
                    ).textContent = `Completed: Rp${formatCurrency(
                        completedSum
                    )}`;
                    document.querySelector(
                        ".failed"
                    ).textContent = `Failed: Rp${formatCurrency(failedSum)}`;
                })
                .catch((error) => console.error("Error:", error));
        };

        const chart = new ApexCharts(document.querySelector("#chart-earning"), {
            series: [
                { name: "Total Earning", data: [] },
                { name: "Completed", data: [] },
                { name: "Failed", data: [] },
            ],
            chart: { height: 350, type: "area", toolbar: { show: false } },
            colors: ["#3a57e8", "#1aa053", "#c03321"],
            dataLabels: { enabled: false },
            stroke: { curve: "smooth", width: 3 },
            yaxis: {
                labels: {
                    formatter: (value) => `Rp${formatCurrency(value)}`,
                },
            },
            xaxis: { categories: [] },
            grid: { show: false },
            tooltip: {
                enabled: true,
                y: {
                    formatter: (value) => `Rp${formatCurrency(value)}`,
                },
            },
        });

        chart.render();

        // Initial chart update
        updateChart(selectedTimeFilter);

        const dropdownItems = document.querySelectorAll(".chart-earning");
        dropdownItems.forEach((item) => {
            item.addEventListener("click", (e) => {
                e.preventDefault();

                selectedTimeFilter = item.textContent
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, "_");

                if (selectedTimeFilter === "custom") {
                    document.getElementById(
                        "custom-date-range-chart-earning"
                    ).style.display = "block";
                } else {
                    document.getElementById(
                        "custom-date-range-chart-earning"
                    ).style.display = "none";
                    updateChart(selectedTimeFilter);
                }

                const dropdownToggle = document.querySelector(
                    "#dropdownMenuButtonChartEarning"
                );
                dropdownToggle.textContent = item.textContent;
            });
        });

        // Custom date range apply logic (unchanged)
        document
            .getElementById("apply-custom-date-chart-earning")
            .addEventListener("click", () => {
                const startDate = document.getElementById(
                    "start-date-chart-earning"
                ).value;
                const endDate = document.getElementById(
                    "end-date-chart-earning"
                ).value;

                if (startDate && endDate) {
                    updateChart("custom", startDate, endDate);
                } else {
                    alert("Please select both start and end dates.");
                }
            });
    }

    if (document.querySelectorAll("#performance-earning").length) {
        // Dropdown items event listener
        const dropdownItems = document.querySelectorAll(".performance-earning");
        const customFilter = document.getElementById("custom-filter");
        const customDateRange = document.getElementById(
            "custom-date-range-performance-earning"
        );
        const applyCustomDateBtn = document.getElementById(
            "apply-custom-date-performance-earning"
        );

        let selectedFilter = "yoy"; // Default to YoY

        const fetchPerformanceMetrics = (
            filter,
            startDate = null,
            endDate = null
        ) => {
            let url = `/performance?filter=${filter}`;

            if (filter === "custom" && startDate && endDate) {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }

            fetch(url, {
                method: "GET",
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((response) => response.json())
                .then((data) => {
                    // Update the badge and the total value displayed in the view
                    updateMetricsDisplay(data, filter);
                })
                .catch((error) => console.error("Error:", error));
        };

        // Function to update the metrics in the view
        const updateMetricsDisplay = (data, filter) => {
            const badge = document.querySelector(".badge");
            const totalValue = document.querySelector(
                ".performance-earning h2"
            );

            switch (filter) {
                case "yoy":
                    badge.textContent = `YoY ${data.yoy.percentage}%`;
                    totalValue.textContent = `Rp${formatCurrency(
                        data.yoy.current_value
                    )}`;
                    break;
                case "ytd":
                    badge.textContent = `YTD ${data.ytd.percentage}%`;
                    totalValue.textContent = `Rp${formatCurrency(
                        data.ytd.current_value
                    )}`;
                    break;
                case "qoq":
                    badge.textContent = `QoQ ${data.qoq.percentage}%`;
                    totalValue.textContent = `Rp${formatCurrency(
                        data.qoq.current_value
                    )}`;
                    break;
                case "mom":
                    badge.textContent = `MoM ${data.mom.percentage}%`;
                    totalValue.textContent = `Rp${formatCurrency(
                        data.mom.current_value
                    )}`;
                    break;
            }

            if (data[filter].percentage === 0) {
                badge.classList.remove("bg-success", "bg-danger");
                badge.classList.add("bg-dark");
            } else if (data[filter].percentage > 0) {
                badge.classList.remove("bg-dark", "bg-danger");
                badge.classList.add("bg-success");
            } else {
                badge.classList.remove("bg-dark", "bg-success");
                badge.classList.add("bg-danger");
            }
        };

        // Initialize with YoY data
        fetchPerformanceMetrics("yoy");

        // Dropdown click handler
        dropdownItems.forEach((item) => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                selectedFilter = this.textContent
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, "_");

                // Hide custom date range if not custom filter
                if (selectedFilter !== "custom") {
                    customDateRange.style.display = "none";
                    fetchPerformanceMetrics(selectedFilter);
                } else {
                    customDateRange.style.display = "block";
                }

                // Update dropdown button text
                document.querySelector(
                    "#dropdownMenuButtonPerformanceEarning"
                ).textContent = this.textContent;
            });
        });

        // Apply custom date range
        applyCustomDateBtn.addEventListener("click", function () {
            const startDate = document.getElementById(
                "start-date-performance-earning"
            ).value;
            const endDate = document.getElementById(
                "end-date-performance-earning"
            ).value;

            if (startDate && endDate) {
                fetchPerformanceMetrics("custom", startDate, endDate);
            } else {
                alert("Please select both start and end dates.");
            }
        });
    }

    if (document.querySelectorAll(".chart-opportunity").length) {
        let selectedFilter = "last_24_hours"; // Default filter

        // Function to fetch data based on selected filter
        const fetchOpportunityData = (
            filter,
            startDate = null,
            endDate = null
        ) => {
            let url = `/opportunity?filter=${filter}`; // Define the URL for the request

            if (filter === "custom" && startDate && endDate) {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }

            // Fetch data from the server
            fetch(url, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    document.querySelector(".opportunities").textContent =
                        formatCurrency(data.new_opportunities);
                    document.querySelector(".customers").textContent =
                        data.new_customers;
                })
                .catch((error) => console.error("Error fetching data:", error));
        };

        fetchOpportunityData(selectedFilter);

        // Dropdown click handler
        const dropdownItems = document.querySelectorAll(".chart-opportunity");
        dropdownItems.forEach((item) => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                selectedFilter = this.textContent
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, "_");

                if (selectedFilter === "custom") {
                    document.getElementById(
                        "custom-date-range-chart-opportunity"
                    ).style.display = "block";
                } else {
                    document.getElementById(
                        "custom-date-range-chart-opportunity"
                    ).style.display = "none";
                    fetchOpportunityData(selectedFilter); // Fetch data for non-custom filters
                }

                // Update dropdown button text
                document.querySelector(
                    "#dropdownMenuButtonChartOpportunity"
                ).textContent = this.textContent;
            });
        });

        // Custom date range apply logic
        document
            .getElementById("apply-custom-date-chart-opportunity")
            .addEventListener("click", function () {
                const startDate = document.getElementById(
                    "start-date-chart-opportunity"
                ).value;
                const endDate = document.getElementById(
                    "end-date-chart-opportunity"
                ).value;

                if (startDate && endDate) {
                    fetchOpportunityData("custom", startDate, endDate); // Fetch data for custom date range
                } else {
                    alert("Please select both start and end dates.");
                }
            });
    }

    if (document.querySelectorAll("#earning-overview").length) {
        let selectedFilter = "last_24_hours"; // Default filter

        // Function to fetch earnings data and update the chart
        const fetchEarningOverviewData = (
            filter,
            startDate = null,
            endDate = null
        ) => {
            let url = `/earning-overview?filter=${filter}`; // Define the URL for the request

            if (filter === "custom" && startDate && endDate) {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }

            // Fetch data from the server
            fetch(url, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    // Update the pie chart with new data (percentages)
                    updateEarningOverviewChart(data);
                })
                .catch((error) => console.error("Error fetching data:", error));
        };

        // Initialize the chart with default values
        const initializeChart = (earningsData) => {
            const earnings = earningsData || [0, 0, 0, 0, 0]; // Actual earnings
            const percentages = [0, 0, 0, 0, 0]; // Placeholder percentages for the initial state

            var options = {
                series: percentages, // Series represents percentages
                chart: {
                    width: 380,
                    type: "pie",
                },
                labels: [
                    "Inquiry",
                    "Follow Up",
                    "Staled",
                    "Completed",
                    "Failed",
                ],
                colors: ["#feb019", "#008ffb", "#775dd0", "#1aa053", "#c03321"],
                legend: {
                    position: "bottom",
                    markers: {
                        width: 10,
                        height: 10,
                    },
                    itemMargin: {
                        horizontal: 5,
                        vertical: 5,
                    },
                    onItemClick: {
                        toggleDataSeries: false, // Disable toggle behavior
                    },
                },
                responsive: [
                    {
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200,
                            },
                            legend: {
                                position: "bottom",
                            },
                        },
                    },
                ],
            };

            return new ApexCharts(
                document.querySelector("#earning-overview"),
                options
            );
        };

        // Function to update both percentages and earnings
        const updateEarningOverviewChart = (data) => {
            const percentages = [
                data.inquiryPercentage,
                data.followUpPercentage,
                data.staledPercentage,
                data.completedPercentage,
                data.failedPercentage,
            ];

            const earnings = [
                data.inquiryEarnings,
                data.followUpEarnings,
                data.staledEarnings,
                data.completedEarnings,
                data.failedEarnings,
            ];

            // Update the chart with percentages, but keep earnings for tooltips
            chart.updateOptions({
                series: percentages, // Pass percentages for the pie chart
                tooltip: {
                    y: {
                        formatter: function (value, { seriesIndex, w }) {
                            // Show actual earnings in the tooltip
                            return `Rp${formatCurrency(earnings[seriesIndex])}`;
                        },
                    },
                },
            });
        };

        // Initialize the chart
        let chart = initializeChart();
        chart.render();

        // Fetch data for the default filter and update the chart
        fetchEarningOverviewData(selectedFilter);

        // Dropdown click handler
        const dropdownItems = document.querySelectorAll(".earning-overview");
        dropdownItems.forEach((item) => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                selectedFilter = this.textContent
                    .trim()
                    .toLowerCase()
                    .replace(/\s+/g, "_");

                if (selectedFilter === "custom") {
                    document.getElementById(
                        "custom-date-range-earning-overview"
                    ).style.display = "block";
                } else {
                    document.getElementById(
                        "custom-date-range-earning-overview"
                    ).style.display = "none";
                    fetchEarningOverviewData(selectedFilter); // Fetch data for non-custom filters
                }

                // Update dropdown button text
                document.querySelector(
                    "#dropdownMenuButtonEarningOverview"
                ).textContent = this.textContent;
            });
        });

        // Custom date range apply logic
        document
            .getElementById("apply-custom-date-earning-overview")
            .addEventListener("click", function () {
                const startDate = document.getElementById(
                    "start-date-earning-overview"
                ).value;
                const endDate = document.getElementById(
                    "end-date-earning-overview"
                ).value;

                if (startDate && endDate) {
                    fetchEarningOverviewData("custom", startDate, endDate); // Fetch data for custom date range
                } else {
                    alert("Please select both start and end dates.");
                }
            });
    }

    // if (document.querySelectorAll("#d-activity").length) {
    //     const options = {
    //         series: [
    //             {
    //                 name: "Successful deals",
    //                 data: [30, 50, 35, 60, 40, 60, 60, 30, 50, 35],
    //             },
    //             {
    //                 name: "Failed deals",
    //                 data: [40, 50, 55, 50, 30, 80, 30, 40, 50, 55],
    //             },
    //         ],
    //         chart: {
    //             type: "bar",
    //             height: 230,
    //             stacked: true,
    //             toolbar: {
    //                 show: false,
    //             },
    //         },
    //         colors: ["#3a57e8", "#4bc7d2"],
    //         plotOptions: {
    //             bar: {
    //                 horizontal: false,
    //                 columnWidth: "28%",
    //                 endingShape: "rounded",
    //                 borderRadius: 5,
    //             },
    //         },
    //         legend: {
    //             show: false,
    //         },
    //         dataLabels: {
    //             enabled: false,
    //         },
    //         stroke: {
    //             show: true,
    //             width: 2,
    //             colors: ["transparent"],
    //         },
    //         xaxis: {
    //             categories: ["S", "M", "T", "W", "T", "F", "S", "M", "T", "W"],
    //             labels: {
    //                 minHeight: 20,
    //                 maxHeight: 20,
    //                 style: {
    //                     colors: "#8A92A6",
    //                 },
    //             },
    //         },
    //         yaxis: {
    //             title: {
    //                 text: "",
    //             },
    //             labels: {
    //                 minWidth: 19,
    //                 maxWidth: 19,
    //                 style: {
    //                     colors: "#8A92A6",
    //                 },
    //             },
    //         },
    //         fill: {
    //             opacity: 1,
    //         },
    //         tooltip: {
    //             y: {
    //                 formatter: function (val) {
    //                     return "$ " + val + " thousands";
    //                 },
    //             },
    //         },
    //     };

    //     const chart = new ApexCharts(
    //         document.querySelector("#d-activity"),
    //         options
    //     );
    //     chart.render();
    //     document.addEventListener("ColorChange", (e) => {
    //         const newOpt = { colors: [e.detail.detail1, e.detail.detail2] };
    //         chart.updateOptions(newOpt);
    //     });
    // }
})(jQuery);
