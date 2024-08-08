<?php
// Fetch FIs
include_once '../settings/connection.php';
session_start(); // Start session if not already started

$stmt=$pdo->prepare("SELECT userID, name FROM users WHERE roleID = 3");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch courses
$stmt_courses=$pdo->prepare("SELECT courseID, courseName FROM courses");
$stmt_courses->execute();
$result_courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);

$userID = $_SESSION['userID'] ?? null; // Store userID from session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and styles remain unchanged -->
</head>
<body>
    <div class="container">
        <h1>Study Support Finder</h1>

        <label for="course">Course</label>
        <select id="course" name="course">
            <?php
            foreach ($result_courses as $row) {
                echo '<option value="' . htmlspecialchars($row['courseID']) . '">' . htmlspecialchars($row['courseName']) . '</option>';
            }
            ?>
        </select>

        <label for="time">Available Date</label>
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
        const currentUserID = '<?php echo $userID; ?>'; // Pass the user ID to JavaScript

        function findSupport() {
            const supportType = "Peer Tutor";
            const course = document.getElementById('course').value;
            const time = document.getElementById('time').value;

            const data = new FormData();
            data.append('supportType', supportType);
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
        }

        function displayResults(potentialSupports) {
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';
            potentialSupports.forEach(support => {
                const resultDiv = document.createElement('div');
                resultDiv.className = 'result';
                resultDiv.innerHTML = `
                    <strong>Name:</strong> ${support.name}<br>
                    <strong>Course:</strong> ${support.courseID}<br>
                    <strong>Available Time:</strong> ${support.availableDate}<br>
                    <div>
                        <a href="rating.php?ratee=${support.userID}&rater=${currentUserID}">Rate this FI</a><br>
                        <a href="chat.php?buddy=${support.name}&buddyid=${support.userID}">Chat with <strong>Buddy</strong></a><br>
                        <a href="conference.php?buddy=${support.name}&buddyid=${support.userID}">Call <strong>Buddy</strong></a>
                    </div>
                `;
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
