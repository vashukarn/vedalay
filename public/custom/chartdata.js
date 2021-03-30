var url = "/user/expenseIncomeChart";
$(document).ready(function () {
    $.get(url, function (response) {
        var Month = response.month;
        var Income = response.income;
        var Expense = response.expense;
        var salesChartCanvas = $("#salesChart").get(0).getContext("2d");
        var salesChartData = {
            labels: Month,
            datasets: [
                {
                    label: "Income",
                    backgroundColor: "rgba(60,141,188,0.9)",
                    borderColor: "rgba(60,141,188,0.8)",
                    pointRadius: false,
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: Income,
                },
                {
                    label: "Expenses",
                    backgroundColor: "rgba(210, 214, 222, 1)",
                    borderColor: "rgba(210, 214, 222, 1)",
                    pointRadius: false,
                    pointColor: "rgba(210, 214, 222, 1)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: Expense,
                },
            ],
        };

        var salesChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true,
            },
            scales: {
                xAxes: [
                    {
                        gridLines: {
                            display: true,
                        },
                    },
                ],
                yAxes: [
                    {
                        gridLines: {
                            display: true,
                        },
                    },
                ],
            },
        };
        var salesChart = new Chart(salesChartCanvas, {
            type: "line",
            data: salesChartData,
            options: salesChartOptions,
        });
    });
});
