<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peer Tutor Time Tracker</title>
    <style>
        /* Your existing styles */
    </style>
</head>
<body>
    <div class="container">
        <h1>Peer Tutor Time Tracker</h1>
        <form id="time-form">
            <label for="start-time">Start Time:</label>
            <input type="datetime-local" id="start-time" name="start-time" required>

            <label for="end-time">End Time:</label>
            <input type="datetime-local" id="end-time" name="end-time" required>

            <button type="submit">Record Session</button>
        </form>
        <h2>Session Logs:</h2>
        <table class="log-table" id="log-table">
            <thead>
                <tr>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script>
        document.getElementById('time-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            const startTime = document.getElementById('start-time').value;
            const endTime = document.getElementById('end-time').value;

            if (!startTime || !endTime) {
                alert('Please enter both start and end times.');
                return;
            }

            fetch('../action/time_tracker.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=record&start_time=${encodeURIComponent(startTime)}&end_time=${encodeURIComponent(endTime)}`
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Session recorded.');
                    loadLogs(); // Reload logs after recording session
                } else {
                    alert(result.message || 'Error recording session.');
                }
            });
        });

        function loadLogs() {
            fetch('../action/time_tracker.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=load_logs'
            })
            .then(response => response.json())
            .then(logs => {
                const tbody = document.querySelector('#log-table tbody');
                tbody.innerHTML = '';
                logs.forEach(log => {
                    const row = `<tr>
                                    <td>${log.start_time}</td>
                                    <td>${log.end_time}</td>
                                  </tr>`;
                    tbody.innerHTML += row;
                });
            });
        }

        // Load logs when the page loads
        document.addEventListener('DOMContentLoaded', loadLogs);
    </script>
</body>
</html>
