<?php
session_start();
require '../settings/connection.php';  // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Getting the profile from the db
    $stmt = $pdo->prepare("SELECT * FROM userprofiles WHERE userID = ?");
    $stmt->execute([$_SESSION['userID']]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    $className = $profile['courseID']; // TODO: Add the courseName field to the userprofiles table    
    $major = $profile['major'];
    $timeToStudy = $profile['timeToStudy'];
    $stressed = $profile['stressLevel'];
    $interest = $profile['interests'];
    $date = $profile['availableDate'];
    $yearGroup = $profile['gradYear'];
    


    // Validate inputs
    if (!$className || !$major || !$timeToStudy || !$stressed || !$interest || !$date || !$yearGroup) {
        die("All fields are required.");
    }

    // Fetch users who are students and whose graduation year, major, courses, and availability match the input criteria
    $stmt = $pdo->prepare("
        SELECT u.userID, u.name, u.major, up.studyHabits, up.interests, up.gradYear, up.stressLevel, up.availableDate,
        c.courseName
        FROM users u
        JOIN userprofiles up ON u.userID = up.userID
        JOIN usercourses uc ON u.userID = uc.userID
        JOIN courses c ON uc.courseID = c.courseID
        WHERE u.major = ? "
    );
    $stmt->execute([$major, $yearGroup, $className, $date]);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);


    // Process matching considering the date and interests
    $potentialStudyBuddies = array_filter($users, function ($user) use ($date) {
        return $user['availableDate'] === $date;
    });

    if (empty($potentialStudyBuddies)) {
        die("No study buddies are available on the selected date with the selected course and major.");
    }

    // Scoring and sorting based on time to study, stress level, and interest
    $scoreList = [];
    foreach ($potentialStudyBuddies as $buddy) {
        $timeDiff = abs($timeToStudy - $buddy['timeToStudy']);
        $stressDiff = abs($stressed - $buddy['stressLevel']);
        $interestDiff = ($interest === $buddy['interests']) ? 0 : 1;
        $score = (1 - $timeDiff / 10) * 0.4 + (1 - $stressDiff / 5) * 0.3 + (1 - $interestDiff) * 0.3;
        $scoreList[] = ['userID' => $buddy['userID'], 'score' => $score];
    }

    usort($scoreList, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    // Store results in session
    $_SESSION['matching_results'] = $scoreList;
    
    // Redirect to the display results page
    header('Location: ../html/displayResults.php');
    exit();
}
?>
