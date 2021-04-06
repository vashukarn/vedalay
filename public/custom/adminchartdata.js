var url = $('meta[name="expenseIncomeChart"]').attr("content");
$(document).ready(function () {
    $.get(url, function (response) {
        var Month = response.month;
        var Income = response.income;
        var Expense = response.expense;
        var incomedifference =
            Number(response.currentmonthincome) -
            Number(response.lastmonthincome);
        var expensedifference =
            Number(response.currentmonthexpense) -
            Number(response.lastmonthexpense);
        if (Number(response.lastmonthincome) == 0) {
            var incomepercentage = 100;
        } else {
            var incomepercentage =
                (Number(incomedifference) * 100) /
                Number(response.lastmonthincome);
        }
        if (Number(response.lastmonthexpense) == 0) {
            var expensepercentage = 100;
        } else {
            var expensepercentage =
                (Number(expensedifference) * 100) /
                Number(response.lastmonthexpense);
        }
        if (Number(incomedifference) > 0) {
            $("#incomedifference").append(
                '<span class="description-percentage text-success"><i class="fas fa-caret-up"></i> ' +
                    Math.round(incomepercentage) +
                    "%</span>"
            );
        } else if (Number(incomedifference) < 0) {
            $("#incomedifference").append(
                '<span class="description-percentage text-danger"><i class="fas fa-caret-down"></i> ' +
                    Math.round(incomepercentage) +
                    "%</span>"
            );
        } else {
            $("#incomedifference").append(
                '<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0 %</span>'
            );
        }
        $("#incomedifference").append(
            '<h5 class="description-header">Rs. ' +
                Math.round(response.currentmonthincome) +
                " - Rs. " +
                Math.round(response.lastmonthincome) +
                " = Rs. " +
                Number(incomedifference) +
                '</h5><span class="description-text">Current & Last month income</span>'
        );

        if (Number(expensedifference) > 0) {
            $("#expensedifference").append(
                '<span class="description-percentage text-danger"><i class="fas fa-caret-up"></i> ' +
                    Math.round(expensepercentage) +
                    "%</span>"
            );
        } else if (Number(expensedifference) < 0) {
            $("#expensedifference").append(
                '<span class="description-percentage text-success"><i class="fas fa-caret-down"></i> ' +
                    Math.round(expensepercentage) +
                    "%</span>"
            );
        } else {
            $("#expensedifference").append(
                '<span class="description-percentage text-warning"><i class="fas fa-caret-left"></i> 0 %</span>'
            );
        }
        $("#expensedifference").append(
            '<h5 class="description-header">Rs. ' +
                response.currentmonthexpense +
                " - Rs. " +
                response.lastmonthexpense +
                " = Rs. " +
                Number(expensedifference) +
                '</h5><span class="description-text">Current & Last month expense</span>'
        );

        $("#yearincome").append(
            '<h5 class="description-header">Rs. ' +
                response.incometotal +
                '</h5><span class="description-text">total Incomes this year</span>'
        );
        $("#yearexpense").append(
            '<h5 class="description-header">Rs. ' +
                response.expensetotal +
                '</h5><span class="description-text">TOTAL EXPENSES this year</span>'
        );

        $("#totalexpense").append("Rs. " + response.expensetotal);
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
