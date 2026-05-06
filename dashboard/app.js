fetch('../api.php')
.then(res => res.json())
.then(data => {
    document.getElementById('logs').innerText = "Total Logs: " + data.total_logs;
    document.getElementById('alerts').innerText = "Alerts: " + data.total_alerts;

    const labels = data.top_ips.map(x => x.ip);
    const counts = data.top_ips.map(x => x.count);

    new Chart(document.getElementById('chart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Top IP Activity',
                data: counts
            }]
        }
    });
});
