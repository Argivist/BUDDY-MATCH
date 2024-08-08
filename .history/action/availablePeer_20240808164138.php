<?phpsession_start();
require '../settings/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supportType = $_POST['supportType'] ?? '';
    $course = $_POST['course'] ?? '';
    $time = $_POST['time'] ?? '';

    // Choose query based on support type
    if ($supportType === 'FI') {
        $query = "SELECT u.userID, u.name, uc.courseID, p.availableDate
                  FROM users u
                  JOIN userprofiles p ON u.userID = p.userID
                  JOIN usercourses uc ON u.userID = uc.userID
                  WHERE u.roleID = 4 AND uc.courseID = ? AND p.availableDate LIKE ?";
    } else if ($supportType === 'Peer Tutor') {
        $query = "SELECT u.userID, u.name, uc.courseID, p.availableDate
                  FROM users u
                  JOIN userProfiles p ON u.userID = p.userID
                  JOIN userCourses uc ON u.userID = uc.userID
                  WHERE u.roleID = 3 AND uc.courseID = ? AND p.availableDate LIKE ?";
    } else {
        echo json_encode([]);
        exit;
    }

    $stmt = $pdo->prepare($query);
    $likeTime = '%' . $time . '%';
    $stmt->execute([$course, $likeTime]);

    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($matches);
} else {
    http_response_code(405); // Method Not Allowed
}

?>
