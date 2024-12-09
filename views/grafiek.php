<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>grafiek</title>
    <link rel="stylesheet" href="/public/css/styles.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container">
    <canvas id="lineChartl" width="300" height="200"></canvas>
    <canvas id="lineChartlr" width="300" height="200"></canvas>
    <canvas id="lineChartr" width="300" height="200"></canvas>
</div>


<script>
    // Get the data from PHP passed by the controller
    var optimaalcurve = [20, 15, 12, 10, 5, 0, -5, -10, -10, 5, 0];
    var links =  [25, 10, 10, 10, 0, 5, -10, -15, -5, 5, 15];
    var rechts =  [15, 20, 15, 15, 10, 5, -15, -15, -15, 10, 15];

    // Custom labels for x-axis
    var customLabels = ['125 Hz', '250 Hz', '500 Hz', '750 Hz', '1000 Hz', '1500 Hz', '2000 Hz', '3000 Hz', '4000 Hz', '6000 Hz', '8000 Hz'];

    // Create a new Chart object for the first graph (optimaalcurve en links)
    var ctx1 = document.getElementById('lineChartl').getContext('2d');
    var lineChart1 = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: customLabels,
            datasets: [{
                label: 'Optimaalcurve',
                data: optimaalcurve,
                borderColor: 'rgba(128, 128, 128, 1)',
                backgroundColor: 'rgba(128, 128, 128, 0.2)',
                tension: 0.4 // Set tension for smooth lines
            },{
                label: 'Links',
                data: links,
                borderColor: 'rgba(0, 0, 255, 1)',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                tension: 0.4 // Set tension for smooth lines
            }]
        },
        options: {
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Decibel'
                    },
                    suggestedMin: -20,
                    suggestedMax: 40,
                    reverse: true, // Reversed y-axis
                    ticks: {
                        stepSize: 5,
                        // Adjusting y-axis ticks to match provided decibel values
                        callback: function(value, index, values) {
                            return value + ' dB';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Hz'
                    }
                }
            }
        }
    });

    // Create a new Chart object for the second graph (optimaalcurve, links, en rechts)
    var ctx2 = document.getElementById('lineChartlr').getContext('2d');
    var lineChart2 = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: customLabels,
            datasets: [{
                label: 'Optimaalcurve',
                data: optimaalcurve,
                borderColor: 'rgba(128, 128, 128, 1)',
                backgroundColor: 'rgba(128, 128, 128, 0.2)',
                tension: 0.4 // Set tension for smooth lines
            },{
                label: 'Links',
                data: links,
                borderColor: 'rgba(0, 0, 255, 1)',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
                tension: 0.4 // Set tension for smooth lines
            },{
                label: 'Rechts',
                data: rechts,
                borderColor: 'rgba(255, 0, 0, 1)',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                tension: 0.4 // Set tension for smooth lines
            }]
        },
        options: {
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Decibel'
                    },
                    suggestedMin: -20,
                    suggestedMax: 40,
                    reverse: true, // Reversed y-axis
                    ticks: {
                        stepSize: 5,
                        // Adjusting y-axis ticks to match provided decibel values
                        callback: function(value, index, values) {
                            return value + ' dB';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Hz'
                    }
                }
            }
        }
    });

    // Create a new Chart object for the third graph (optimaalcurve en rechts)
    var ctx3 = document.getElementById('lineChartr').getContext('2d');
    var lineChart3 = new Chart(ctx3, {
        type: 'line',
        data: {
            labels: customLabels,
            datasets: [{
                label: 'Optimaalcurve',
                data: optimaalcurve,
                borderColor: 'rgba(128, 128, 128, 1)',
                backgroundColor: 'rgba(128, 128, 128, 0.2)',
                tension: 0.4 // Set tension for smooth lines
            },{
                label: 'Rechts',
                data: rechts,
                borderColor: 'rgba(255, 0, 0, 1)',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
                tension: 0.4 // Set tension for smooth lines
            }]
        },
        options: {
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Decibel'
                    },
                    suggestedMin: -20,
                    suggestedMax: 40,
                    reverse: true, // Reversed y-axis
                    ticks: {
                        stepSize: 5,
                        // Adjusting y-axis ticks to match provided decibel values
                        callback: function(value, index, values) {
                            return value + ' dB';
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Hz'
                    }
                }
            }
        }
    });
</script>
</body>
</html>
