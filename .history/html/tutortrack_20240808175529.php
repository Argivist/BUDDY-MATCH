<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peer Tutor Time Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fce4ec;
            color: #880e4f;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #f8bbd0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 500px;
            text-align: center;
        }
        button {
            background: #d81b60;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #ad1457;
        }
        .log-table {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }
        .log-table th, .log-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .log-table th {
            background-color: #f06292;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Peer Tutor Time Tracker</h1>
        <form id="time-form">
            <button type="button" onclick="startSession()">Start Session</button>
            <button type="button" onclick="endSession()">End Session</button>
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
        function startSession() {
            fetch('../action/time_tracker.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=start'
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Session started.');
                } else {
                    alert('Error starting session.');
                }
            });
        }

        function endSession() {
            fetch('../action/time_tracker.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=end'
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Session ended.');
                    loadLogs(); // Reload logs after ending session
                } else {
                    alert('Error ending session.');
                }
            });
        }

        function loadLogs() {
            fetch('time_tracker.php', {
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
