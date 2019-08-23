$(document).ready(function () {
    $('.carousel').carousel({
        interval: false
    });
    $('#dataTable').DataTable();
    $('[data-toggle="tooltip"]').tooltip();
    $('.counter-count').each(function () {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: (Math.random() * 2000) + 3000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    $(document).ready(function () {
        $('#exporter').on('click', function () {
            $('#printable').tableExport({type: 'excel'});
        })
    });
});


function updateChartData(chart, labels, dataName, data) {
    let datasets = chart.data.datasets;
    chart.data.labels = labels;
    for (let i = 0; i < datasets.length; i++) {
        if (datasets[i].label === dataName) {
            datasets[i].data = data;
        }
    }
    chart.update();
}

function addDataset(chart, dataName, color = [78, 115, 223]) {
    let opacity = 0.07;
    if (chart.config.type === 'bar') {
        opacity = 0.75;
    }
    chart.data.datasets.push(
        {
            label: dataName,
            data: [],
            lineTension: 0.3,
            backgroundColor: "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + ", " + opacity + ")",
            borderColor: "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + ", 0.85)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + ", 0.85)",
            pointBorderColor: "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + ", 0.85)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + ", 0.85)",
            pointHoverBorderColor: "rgba(" + color[0] + ", " + color[1] + ", " + color[2] + ", 0.85)",
            pointHitRadius: 10,
            pointBorderWidth: 2
        }
    );
    chart.update();
}

function showNodes(nodes) {
    for (let i = 0; i < nodes.length; i++) {
        nodes[i].removeClass("d-none")
    }
}

function makeChart(target, graphType, xLabel, yLabel) {
    return new Chart(target, {
        // The type of chart we want to create
        type: graphType,

        // The data for our dataset
        data: {
            labels: [],
            datasets: []
        },

        // Configuration options go here
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: xLabel
                    },
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    scaleLabel: {
                        display: true,
                        labelString: yLabel
                    },
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        beginAtZero: true

                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
            }
        },
    });
}