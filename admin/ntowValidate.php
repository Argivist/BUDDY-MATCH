<?php
include_once '../settings/connection.php';

// Fetch data from the peertutor and user tables
$sql = "SELECT pt.tutorID, pt.tutorID, pt.startTime, pt.endTime, pt.status, u.name, m.major
        FROM peertutor pt
        JOIN users u ON pt.tutorID = u.userID
        JOIN majors m ON u.major = m.majorID
        WHERE pt.status = 'Pending'"; // Fetch only pending status for initial display

$result = $conn->query($sql);
$timeSheet = [];

// Check if the query was successful
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $timeSheet[] = $row;
        }
    }
} else {
    // Handle query error
    echo "Error: " . $conn->error;
}

// Handle the status update via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    
    if (isset($_POST['approve'])) {
        $newStatus = 'Approved';
    } elseif (isset($_POST['reject'])) {
        $newStatus = 'Rejected';
    }

    $update_sql = "UPDATE peertutor SET status=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $newStatus, $id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to refresh the list
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Peer Tutor Hours</title>
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
            width: 600px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .time-log {
            background: #f48fb1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: left;
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
    </style>
</head>
<body>
<div class="container">
        <h1>Validate Peer Tutor Hours</h1>

        <div id="validationLogs">
            <?php foreach ($timeSheet as $entry): ?>
                <div class="time-log">
                    <strong>ID:</strong> <?php echo htmlspecialchars($entry['id']); ?><br>
                    <strong>Name:</strong> <?php echo htmlspecialchars($entry['name']); ?><br>
                    <strong>Major:</strong> <?php echo htmlspecialchars($entry['major']); ?><br>
                    <strong>Start Time:</strong> <?php echo htmlspecialchars($entry['startTime']); ?><br>
                    <strong>End Time:</strong> <?php echo htmlspecialchars($entry['endTime']); ?><br>
                    <strong>Status:</strong> <?php echo htmlspecialchars($entry['status']); ?><br>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $entry['id']; ?>">
                        <button type="submit" name="approve">Approve</button>
                        <button type="submit" name="reject">Reject</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>

