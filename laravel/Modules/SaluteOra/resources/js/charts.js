// Configurazione globale per Chart.js
Chart.defaults.font.family = "'Inter', 'system-ui', '-apple-system', 'sans-serif'";
Chart.defaults.font.size = 12;
Chart.defaults.color = '#374151';

// Plugin per i colori personalizzati
Chart.register(ChartColorSchemes);

// Plugin per le etichette
Chart.register(ChartDataLabels);

// Configurazione globale per le etichette
Chart.defaults.plugins.datalabels = {
    color: '#374151',
    font: {
        weight: 'bold'
    },
    padding: 6
};

// Funzione per inizializzare un grafico
function initChart(ctx, config) {
    return new Chart(ctx, {
        ...config,
        options: {
            ...config.options,
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                ...config.options?.plugins,
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 13
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 12,
                    cornerRadius: 4
                }
            }
        }
    });
}

// Funzione per aggiornare un grafico
function updateChart(chart, data) {
    chart.data = data;
    chart.update();
}

// Funzione per distruggere un grafico
function destroyChart(chart) {
    if (chart) {
        chart.destroy();
    }
}

// Funzione per creare un grafico a linee
function createLineChart(ctx, data, options = {}) {
    return initChart(ctx, {
        type: 'line',
        data: data,
        options: {
            ...options,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#E5E7EB',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Funzione per creare un grafico a barre
function createBarChart(ctx, data, options = {}) {
    return initChart(ctx, {
        type: 'bar',
        data: data,
        options: {
            ...options,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#E5E7EB',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Funzione per creare un grafico a torta
function createPieChart(ctx, data, options = {}) {
    return initChart(ctx, {
        type: 'pie',
        data: data,
        options: {
            ...options,
            plugins: {
                ...options.plugins,
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(1) + "%";
                        return percentage;
                    }
                }
            }
        }
    });
}

// Funzione per creare un grafico a ciambella
function createDoughnutChart(ctx, data, options = {}) {
    return initChart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
            ...options,
            plugins: {
                ...options.plugins,
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value * 100 / sum).toFixed(1) + "%";
                        return percentage;
                    }
                }
            }
        }
    });
} 