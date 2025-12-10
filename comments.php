<?php

$DB_HOST = 'localhost';
$DB_USER = 'root';           
$DB_PASS = 'heartGrzyM7';   
$DB_NAME = 'mySite';

$db = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($db->connect_error) {
    die("DB connection failed: " . $db->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jack Sampson - ITWS Portfolio</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 40px auto; line-height: 1.6; }
        .comment { background: #f9f9f9; padding: 15px; margin: 15px 0; border-radius: 8px; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; }
        button { padding: 12px 24px; background: #0066cc; color: white; border: none; cursor: pointer; }
        button:hover { background: #004499; }
    </style>
</head>
<body>

<h1>Jack Sampson - ITWS Portfolio</h1>
<p>Final quiz comment system — built with Grok AI assistance</p>

<!-- Form - AI-assisted with Grok -->
<?php
if ($_POST) {
    $name = trim($_POST['visitor_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $comment = trim($_POST['comment'] ?? '');

    if ($name && $email && filter_var($email, FILTER_VALIDATE_EMAIL) && $comment) {
        $stmt = $db->prepare("INSERT INTO siteComments (visitor_name, email, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $comment);
        $stmt->execute();
        echo "<p style='color:green; font-weight:bold;'>Comment submitted! Awaiting approval.</p>";
    } else {
        echo "<p style='color:red;'>Please fill all required fields with valid data.</p>";
    }
}
?>

<form method="post">
    <input type="text" name="visitor_name" placeholder="Your Name *" required><br>
    <input type="email" name="email" placeholder="Your Email *" required><br>
    <textarea name="comment" rows="5" placeholder="Your Comment *" required></textarea><br>
    <button type="submit">Submit Comment</button>
</form>

<h2>Comments</h2>
<?php
$result = $db->query("SELECT * FROM siteComments WHERE status='approved' ORDER BY submitted_at DESC");
if ($result->num_rows == 0) {
    echo "<p>No comments yet — be the first!</p>";
} else {
    while ($c = $result->fetch_assoc()) {
        echo "<div class='comment'>
                <strong>" . htmlspecialchars($c['visitor_name']) . "</strong> 
                <small>(" . $c['submitted_at'] . ")</small><br>
                " . nl2br(htmlspecialchars($c['comment'])) . "
              </div>";
    }
}
$db->close();
?>

</body>
</html>