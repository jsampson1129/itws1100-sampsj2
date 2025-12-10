<?php
require_once 'iit/labs/lab09/inclassexample/includes/config.inc.php';
require_once 'iit/labs/lab09/inclassexample/includes/head.inc.php';
?>

<h1>Welcome to My ITWS Portfolio</h1>
<p>Leave a comment below — I read every one!</p>

<div id="comment-form">
  <h2>Leave a Comment</h2>
  <form id="commentForm" method="post" action="">
    <label>Name: <span style="color:red;">*</span><br>
      <input type="text" name="visitor_name" required></label><br><br>

    <label>Email: <span style="color:red;">*</span><br>
      <input type="email" name="email" required></label><br><br>

    <label>Comment: <span style="color:red;">*</span><br>
      <textarea name="comment" rows="5" required></textarea></label><br><br>

    <label>Feature Suggestion (optional):<br>
      <textarea name="feature_suggestion" rows="3"></textarea></label><br><br>

    <button type="submit" name="submit_comment">Submit Comment</button>
  </form>

  <?php
  // === AI-ASSISTED SECTION START (Grok helped with prepared statements) ===
  if (isset($_POST['submit_comment'])) {
    $name = trim($_POST['visitor_name']);
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);
    $feature = trim($_POST['feature_suggestion'] ?? '');

    $errors = [];

    if (empty($name)) $errors[] = "Name is required.";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required.";
    if (empty($comment)) $errors[] = "Comment is required.";

    if (empty($errors)) {
      $db = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD'], 'mySite');
      if ($db->connect_error) die("Connection failed: " . $db->connect_error);

      // Prepared statement — 
      $stmt = $db->prepare("INSERT INTO siteComments (visitor_name, email, comment, feature_suggestion) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("ssss", $name, $email, $comment, $feature);
      $stmt->execute();
      $stmt->close();
      $db->close();

      echo '<p style="color:green; font-weight:bold;">Thank you! Your comment is awaiting approval.</p>';
      // Clear form
      $_POST = [];
    } else {
      echo '<ul style="color:red;">';
      foreach ($errors as $e) echo "<li>$e</li>";
      echo '</ul>';
    }
  }
  // === AI-ASSISTED SECTION END ===
  ?>
</div>

<div id="comments-display">
  <h2>Visitor Comments</h2>
  <?php
  $db = new mysqli($GLOBALS['DB_HOST'], $GLOBALS['DB_USERNAME'], $GLOBALS['DB_PASSWORD'], 'mySite');
  $result = $db->query("SELECT visitor_name, email, comment, feature_suggestion, submitted_at 
                        FROM siteComments WHERE status = 'approved' 
                        ORDER BY submitted_at DESC");

  if ($result->num_rows === 0) {
    echo "<p>No comments yet — be the first!</p>";
  } else {
    while ($row = $result->fetch_assoc()) {
      $date = date('F j, Y \a\t g:i A', strtotime($row['submitted_at']));
      $feature = $row['feature_suggestion'] ? "<br><em>Feature suggestion: " . htmlspecialchars($row['feature_suggestion']) . "</em>" : "";
      echo "<div class='comment-box'>
              <strong>" . htmlspecialchars($row['visitor_name']) . "</strong> 
              <small>($date)</small><br>
              " . nl2br(htmlspecialchars($row['comment'])) . "$feature
            </div><hr>";
    }
  }
  $db->close();
  ?>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
  $("#commentForm").on("submit", function(e) {
    let valid = true;
    $(this).find("[required]").each(function() {
      if ($(this).val().trim() === "") {
        alert("Please fill in all required fields.");
        valid = false;
        return false;
      }
    });
    if (!valid) e.preventDefault();
  });
});
</script>

<style>
#comment-form, #comments-display { max-width: 800px; margin: 30px auto; }
.comment-box { background: #f9f9f9; padding: 15px; border-radius: 8px; margin: 15px 0; }
input, textarea { width: 100%; padding: 8px; margin: 5px 0; }
button { padding: 10px 20px; background: #0066cc; color: white; border: none; cursor: pointer; }
button:hover { background: #0044aa; }
</style>

<?php require_once 'includes/foot.inc.php'; ?>