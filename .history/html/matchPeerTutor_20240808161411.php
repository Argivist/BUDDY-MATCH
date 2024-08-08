<?php
// Fetch FIs
include_once '../settings/connection.php';
//$sql = "SELECT id, fname, lname FROM peertutor";
$stmt=$pdo->prepare("SELECT userID, name FROM users WHERE roleID = 3");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch courses
$stmt_courses=$pdo->prepare("SELECT courseID, courseName FROM courses");
$stmt_courses->execute();
$result_courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Support Finder</title>
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
            width: 300px;
            text-align: center;
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

        input, select {
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
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
        }

        .success-message {
            color: green;
        }

        .failure-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Study Support Finder</h1>

        <!-- <label for="supportType">Select Type</label> -->
        <!-- <label for="supportType">Select Peer Tutor</label>
        
        <select id="supportType" name="supportType">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['userID']) . '">' . htmlspecialchars($row['name']) . '</option>';
                }
            } else {
                echo '<option value="">No Peer Tutor Available Available</option>';
            }
            ?>
        </select> -->


        <label for="course">Course</label>
        <select id="course" name="course">
            <?php
            if ($result_courses->num_rows > 0) {
                while ($row = $result_courses->fetch_assoc()) {
                    echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['course_name']) . '</option>';
                }
            } else {
                echo '<option value="">No Courses Available</option>';
            }
            ?>
        </select>

        <label for="time">Available Data</label>
        <input type="date" id="time" name="time">
        

        <button onclick="findSupport()">Find Support</button>

        <div class="result-container" id="result-container" style="display: none;">
            <h2>Matching Supports:</h2>
            <div id="results"></div>
        </div>

        <div id="success-message" class="message success-message" style="display: none;">
            Match found! Here are the details:
        </div>

        <div id="failure-message" class="message failure-message" style="display: none;">
            No supports available for this course and time.
        </div>
    </div>

    <script>
        

        

        function findSupport() {
            // const supportType = document.getElementById('supportType').value;
            const supporttype="Peer Tutor";
            const course = document.getElementById('course').value;
            const time = document.getElementById('time').value;

            // let potentialSupports = [];
            // let supports = supportType === 'FI' ? fIs : peerTutors;

            //getting peer tutors using availablePeer.php
            const data = new FormData();
            data.append('supportType', supporttype);
            data.append('course', course);
            data.append('time', time);

            fetch('../action/availablePeer.php', {
                method: 'POST',
                body: data
            })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        displayResults(data);
                    } else {
                        displayNoMatchMessage();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            // for (let i = 0; i < supports.length; i++) {
            //     if (supports[i][1] === course && supports[i][2].includes(time)) {
            //         potentialSupports.push(supports[i]);
            //     }
            // }

            // if (potentialSupports.length === 0) {
            //     displayNoMatchMessage();
            //     return;
            // }

            // displayResults(potentialSupports);
        }

        function displayResults(potentialSupports) {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';
            potentialSupports.forEach(support => {
                const resultDiv = document.createElement('div');
                resultDiv.className = 'result';
                resultDiv.innerHTML = `<strong>Name:</strong> ${support[0]}<br>
                                       <strong>Course:</strong> ${support[1]}<br>
                                       <strong>Available Time:</strong> ${support[2]}`;
                resultsContainer.appendChild(resultDiv);
            });
            document.getElementById('result-container').style.display = 'block';
            document.getElementById('success-message').style.display = 'block';
            document.getElementById('failure-message').style.display = 'none';
        }

        function displayNoMatchMessage() {
            document.getElementById('result-container').style.display = 'none';
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('failure-message').style.display = 'block';
        }
    </script>
</body>
</html>