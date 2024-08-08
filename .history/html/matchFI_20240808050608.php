<?php
// Fetch FIs
include_once '../settings/connection.php';
//$sql = "SELECT id, fname, lname FROM facultyinterns";
$stmt=$pdo->prepare("SELECT fiID, fname, lname FROM facultyinterns");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch courses
$stmt_courses=$pdo->prepare("SELECT id, course_name FROM courses");
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
        <label for="supportType">Select Type</label>
    <select id="supportType" name="supportType">
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</option>';
            }
        } else {
            echo '<option value="">No Faculty Interns Available</option>';
        }
        $conn->close();
        ?>
    </select>

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

        <label for="time">Available Time</label>
        <input type="text" id="time" placeholder="Enter available times (e.g., 2-4 PM)">

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

    <!-- <script>
        const fIs = [
            ['Dr. Smith', 'Applied Calculus', '2-4 PM'],
            ['Prof. Johnson', 'Data Structures', '9-11 AM'],
            ['Dr. Lee', 'Algorithms', '1-3 PM'],
            ['Dr. Brown', 'Calculus 1', '11-1 PM'],
            ['Prof. Green', 'OOP', '2-4 PM']
        ];

        const peerTutors = [
            ['Alice', 'Engineering Calculus', '3-5 PM'],
            ['Bob', 'Calculus 1', '10-12 AM'],
            ['Charlie', 'Python', '4-6 PM'],
            ['Dave', 'Data Structures', '9-11 AM'],
            ['Eve', 'Algorithms', '1-3 PM']
        ];

        function findSupport() {
            const supportType = document.getElementById('supportType').value;
            const course = document.getElementById('course').value;
            const time = document.getElementById('time').value;

            let potentialSupports = [];
            let supports = supportType === 'FI' ? fIs : peerTutors;

            for (let i = 0; i < supports.length; i++) {
                if (supports[i][1] === course && supports[i][2].includes(time)) {
                    potentialSupports.push(supports[i]);
                }
            }

            if (potentialSupports.length === 0) {
                displayNoMatchMessage();
                return;
            }

            displayResults(potentialSupports);
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
    </script> -->
</body>
</html>