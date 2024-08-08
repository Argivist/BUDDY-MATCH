<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            margin-top: 10;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .result-container {
            margin-top: 20px;
            background: #f48fb1;
            padding: 10px;
            border-radius: 5px;
        }

        .result {
            margin-bottom: 10px;
            padding: 10px;
            background: #f06292;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
            margin-top: 10px;
        }

        .chat-box {
            display: none;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            margin-top: 20px;
        }

        /* active button */
        .active {
            background: #ad1457;
        }

        /* drmant */
        .drmant {
            background: #f06292;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <button onclick="viewAllUsers()">View All Users</button>
        <button onclick="viewReportedUsers()">View Reported Users</button>
        <div class="result-container" id="result-container" style="display: none;">
            <h2>Users:</h2>
            <div id="results"></div>
        </div>
    </div>

    <script>
        const users = [
            { 
                name: 'Sindhu', 
                major: 'Computer Science', 
                reported: false 
            },
            { 
                name: 'Tejal', 
                major: 'IMS', 
                reported: true, 
                reportDetails: [
                    { category: 'Improper behavior', reason: 'Rude comments during study session' }
                ]
            },
            { 
                name: 'Rhea', 
                major: 'IMS', 
                reported: false 
            },
            { 
                name: 'John', 
                major: 'Computer Science', 
                reported: true, 
                reportDetails: [
                    { category: 'Didn\'t show up', reason: 'Did not attend scheduled study session' },
                    { category: 'Bullying', reason: 'Used offensive language' }
                ]
            }
        ];

        function viewAllUsers() {
            displayResults(users);
        }

        function viewReportedUsers() {
            const reportedUsers = users.filter(user => user.reported);
            displayResults(reportedUsers);
        }

        function displayResults(userList) {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';
            userList.forEach(user => {
                const resultDiv = document.createElement('div');
                resultDiv.className = 'result';
                resultDiv.innerHTML = `<strong>Name:</strong> ${user.name}<br>
                                       <strong>Major:</strong> ${user.major}<br>`;
                if (user.reported) {
                    user.reportDetails.forEach(detail => {
                        resultDiv.innerHTML += `<strong>Reported Category:</strong> ${detail.category}<br>
                                                <strong>Reason:</strong> ${detail.reason}<br>`;
                    });
                }
                resultDiv.innerHTML += `<button onclick="removeUser('${user.name}')">Remove User</button>`;
                resultsContainer.appendChild(resultDiv);
            });
            document.getElementById('result-container').style.display = 'block';
        }

        function removeUser(userName) {
            const userIndex = users.findIndex(user => user.name === userName);
            if (userIndex !== -1) {
                users.splice(userIndex, 1);
                alert(`${userName} has been removed.`);
                viewAllUsers(); // Refresh the list
            } else {
                alert('User not found.');
            }
        }
    </script>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>