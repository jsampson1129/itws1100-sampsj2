<?php
require_once 'includes/init.inc.php';
require_once 'includes/head.inc.php';
?>

<h1>Movies & Actors Database</h1>

<div class="tabs">
  <button class="tablink" onclick="openTab(event,'Actors')">Actors</button>
  <button class="tablink" onclick="openTab(event,'Movies')">Movies</button>
  <button class="tablink" onclick="openTab(event,'MovieActors')">Movies & Actors</button>
</div>

<div id="Actors" class="tabcontent">
  <h2>Manage Actors</h2>

 
  <form method="post">
    <label>First Name: <input type="text" name="first_name" required></label><br><br>
    <label>Last Name: <input type="text" name="last_name" required></label><br><br>
    <label>Date of Birth: <input type="date" name="dob"></label><br><br>
    <button type="submit" name="add_actor">Add Actor</button>
  </form>

  <?php
  
  if (isset($_POST['add_actor'])) {
    $first = trim($_POST['first_name']);
    $last  = trim($_POST['last_name']);
    $dob   = $_POST['dob'] ?: null;  

    $stmt = $db->prepare("INSERT INTO actors (first_name, last_name, dob) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $first, $last, $dob);
    $stmt->execute();
    echo "<p style='color:green;'>Actor added successfully!</p>";
  }

 
  if (isset($_GET['del_actor'])) {
    $id = (int)$_GET['del_actor'];
    $stmt = $db->prepare("DELETE FROM actors WHERE actor_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<p style='color:red;'>Actor deleted.</p>";
  }
  ?>

  <h2>All Actors</h2>
  <table border="1" cellpadding="8" cellspacing="0" style="width:100%; margin-top:15px;">
    <tr style="background:#0066cc; color:white;">
      <th>ID</th>
      <th>First Name</th>
      <th pdata-th="Last Name</th>
      <th>Date of Birth</th>
      <th>Action</th>
    </tr>
    <?php
    $result = $db->query("SELECT * FROM actors ORDER BY last_name, first_name");
    while ($actor = $result->fetch_assoc()):
      $dob_display = $actor['dob'] ? date('F j, Y', strtotime($actor['dob'])) : '—';
    ?>
      <tr>
        <td><?= htmlspecialchars($actor['actor_id']) ?></td>
        <td><?= htmlspecialchars($actor['first_name']) ?></td>
        <td><?= htmlspecialchars($actor['last_name']) ?></td>
        <td><?= $dob_display ?></td>
        <td>
          <a href="?del_actor=<?= $actor['actor_id'] ?>" 
             onclick="return confirm('Delete <?= addslashes($actor['first_name'] . ' ' . $actor['last_name']) ?>?')"
             style="color:red;">Delete</a>
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<div id="Movies" class="tabcontent">
  <h2>Add Movie</h2>
  <form method="post">
    <label>Title: <input type="text" name="title" required></label><br>
    <label>Year: <input type="number" name="year" min="1900" max="2030" required></label><br>
    <button type="submit" name="save_movie">Add Movie</button>
  </form>

  <?php
  if (isset($_POST['save_movie'])) {
    $title = trim($_POST['title']);
    $year = (int)$_POST['year'];

    $ins = $db->prepare("INSERT INTO movies (title, year) VALUES (?, ?)");
    $ins->bind_param("si", $title, $year);
    $ins->execute();
    echo "<p style='color:green;'>Movie added!</p>";
  }

  if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $del = $db->prepare("DELETE FROM movies WHERE movie_id = ?");
    $del->bind_param("i", $id);
    $del->execute();
    echo "<p style='color:red;'>Movie deleted.</p>";
  }
  ?>

  <h2>All Movies</h2>
  <table border="1" cellpadding="8" cellspacing="0">
    <tr><th>ID</th><th>Title</th><th>Year</th><th>Action</th></tr>
    <?php
    $result = $db->query("SELECT * FROM movies ORDER BY title");
    while ($row = $result->fetch_assoc()):
    ?>
      <tr>
        <td><?= htmlspecialchars($row['movie_id']) ?></td>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['year']) ?></td>
        <td><a href="?delete=<?= $row['movie_id'] ?>" 
               onclick="return confirm('Delete this movie?')">Delete</a></td>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<div id="MovieActors" class="tabcontent">
  <h2>Movies and Their Actors</h2>
  <table border="1" cellpadding="8" cellspacing="0">
    <tr><th>Movie</th><th>Year</th><th>Actor</th><th>DOB</th></tr>
    <?php
    $sql = "SELECT m.title, m.year, a.first_name, a.last_name, a.dob
            FROM movies m
            LEFT JOIN movie_actors ma ON m.movie_id = ma.movie_id
            LEFT JOIN actors a ON ma.actor_id = a.actor_id
            ORDER BY m.title";
    $res = $db->query($sql);
    $current_movie = '';
    while ($r = $res->fetch_assoc()):
      $movie = htmlspecialchars($r['title']) . " (" . $r['year'] . ")";
      if ($movie !== $current_movie):
        echo "<tr><td rowspan='1'>$movie</td><td>" . htmlspecialchars($r['year']) . "</td>";
        $current_movie = $movie;
      else:
        echo "<tr><td></td><td></td>";
      endif;
      $actor = $r['first_name'] && $r['last_name'] 
        ? htmlspecialchars($r['first_name'] . ' ' . $r['last_name'])
        : '—';
      $dob = $r['dob'] ? $r['dob'] : '—';
      echo "<td>$actor</td><td>$dob</td></tr>";
    endwhile;
    ?>
  </table>
</div>

<style>
.tabs { overflow: hidden; background: #333; }
.tablink { background: #555; color: white; float: left; border: none; padding: 14px 20px; cursor: pointer; }
.tablink:hover { background: #777; }
.tablink.active { background: #0066cc; }
.tabcontent { display: none; padding: 20px; border: 1px solid #ccc; border-top: none; }
.tabcontent[style*="block"] { display: block !important; }
</style>

<script>
function openTab(evt, tabName) {
  document.querySelectorAll('.tabcontent').forEach(t => t.style.display = 'none');
  document.querySelectorAll('.tablink').forEach(t => t.className = t.className.replace(' active', ''));
  document.getElementById(tabName).style.display = 'block';
  evt.currentTarget.className += ' active';
}
// Open first tab by default
document.querySelector('.tablink').click();
</script>

<?php require_once 'includes/foot.inc.php'; ?>