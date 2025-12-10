<?php
require_once 'labs/lab9/inclassexample/includes/config.inc.php';
require_once 'labs/lab9/inclassexample/includes/head.inc.php';
?>

<h1>Welcome to Jack Sampson's ITWS Portfolio</h1>
<p>Leave a comment below!</p>

<!-- COMMENT FORM -->
<div style="max-width:800px; margin:30px auto; font-family:Arial;">
  <h2>Leave a Comment</h2>
  <?php
  $success = false;
  $errors = [];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['visitor_name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $feature = trim($_POST['feature_suggestion'] ?? '');

    if (empty($name))    $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required.";
    if (empty($comment)) $errors[] = "Comment is required.";

    if (empty($errors)) {
      $db = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD'], 'mySite');
      if ($db->connect_error) {
        die("DB connection failed: " . $db->connect_error);
      }

      $stmt = $db->prepare("INSERT INTO siteComments (visitor_name, email, comment, feature_suggestion) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $comment, $feature);
      $stmt->execute();
      $stmt->close();
      $db->close();

      $success = true;
    }
  }
  ?>

  <?php if ($success): ?>
    <p style="color:green; font-weight:bold;">Thank you! Your comment is awaiting approval.</p>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <ul style="color:red;">
      <?php foreach ($errors as $e) echo "<li>$e</li>"; ?>
    </ul>
  <?php endif; ?>

  <form method="post">
    <label>Name *<br><input type="text" name="visitor_name" value="<?= htmlspecialchars($name ?? '') ?>" required style="width:100%;padding:8px;"></label><br><br>
    <label>Email *<br><input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required style="width:100%;padding:8px;"></label><br><br>
    <label>Comment *<br><textarea name="comment" rows="5" required style="width:100%;padding:8px;"><?= htmlspecialchars($comment ?? '') ?></textarea></label><br><br>
    <label>Feature Suggestion (optional)<br><textarea name="feature_suggestion" rows="3" style="width:100%;padding:8px;"><?= htmlspecialchars($feature ?? '') ?></textarea></label><br><br>
    <button type="submit" style="padding:10px 20px; background:#0066cc; color:white; border:none;">Submit</button>
  </form>

  <h2>Visitor Comments</h2>
  <?php
  $db = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD'], 'mySite');
  $result = $db->query("SELECT * FROM siteComments WHERE status='approved' ORDER BY submitted_at DESC");
  if ($result->num_rows == 0) {
    echo "<p>No comments yet — be the first!</p>";
  } else {
    while ($c = $result->fetch_assoc()) {
      echo "<div style='background:#f9f9f9; padding:15px; margin:15px 0; border-radius:8px;'>
              <strong>" . htmlspecialchars($c['visitor_name']) . "</strong> 
              <small>(" . date('M j, Y g:i A', strtotime($c['submitted_at'])) . ")</small><br>
              " . nl2br(htmlspecialchars($c['comment'])) . 
              ($c['feature_suggestion'] ? "<br><em>Suggestion: " . htmlspecialchars($c['feature_suggestion']) . "</em>" : "") .
            "</div>";
    }
  }
  $db->close();
  ?>
</div>

<?php require_once 'includes/foot.inc.php'; ?>