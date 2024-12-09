document.addEventListener('DOMContentLoaded', function () {
    var optimaalcurve = [20, 15, 12, 10, 5, 0, -5, -10, -10, -5, 0];
    var links = [40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40];
    var rechts = [40, 40, 40, 40, 40, 40, 40, 40, 40, 40, 40];
    var customLabels = ['125 Hz', '250 Hz', '500 Hz', '750 Hz', '1000 Hz', '1500 Hz', '2000 Hz', '3000 Hz', '4000 Hz', '6000 Hz', '8000 Hz'];

    var ctx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: customLabels,
            datasets: [{
                label: 'Links',
                data: links,
                borderColor: 'rgba(0, 0, 255, 1)',
                backgroundColor: 'rgba(0, 0, 255, 0.2)',
            }, {
                label: 'Rechts',
                data: rechts,
                borderColor: 'rgba(255, 0, 0, 1)',
                backgroundColor: 'rgba(255, 0, 0, 0.2)',
            }, {
                label: 'Optimaalcurve',
                data: optimaalcurve,
                borderColor: 'rgba(128, 128, 128, 1)',
                backgroundColor: 'rgba(128, 128, 128, 0.2)',
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
                    reverse: true,
                    ticks: {
                        stepSize: 5,
                        callback: function (value, index, values) {
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

    function updateChartData(ear, frequency, decibel) {
        const index = customLabels.indexOf(frequency + ' Hz');
        if (index !== -1) {
            if (ear === 'both') {
                lineChart.data.datasets[0].data[index] = decibel;
                lineChart.data.datasets[1].data[index] = decibel;
            } else {
                const datasetIndex = ear === 'links' ? 0 : 1;
                lineChart.data.datasets[datasetIndex].data[index] = decibel;
            }
            lineChart.update();
        }
    }


    const heardBtn = document.getElementById("gehoord");
    heardBtn.addEventListener("click", function () {
        const ear = document.getElementById('ear').value;
        const frequency = document.getElementById('hertz').value;
        const decibel = document.getElementById('decibel').value;
        updateChartData(ear, frequency, decibel);
    });

    document.getElementById('downloadBtn').addEventListener('click', function () {
        WriteToFile(links, rechts, optimaalcurve);
    });

    // Maak de arrays globaal toegankelijk
    window.links = links;
    window.rechts = rechts;
    window.optimaalcurve = optimaalcurve;
});
