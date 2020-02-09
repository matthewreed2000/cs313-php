<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Matthew Reed - CS313 Landing Page</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div id="page-container">
    <?php include "modules/header.php"?>
    <main id="content-wrap">
      <div class="jumbotron">
        <h1>Matthew Reed</h1>
        <p>Landing Page</p>
      </div>
      <div class="picture-menu">
        <a href="about.php">
          <img src="img/baby-me.jpg" alt="Matthew as a toddler"/>
          <p>About Me</p>
        </a>
        <a href="assignments.php">
          <img src="img/assignment.jpg" alt="A person studying or working on homework" />
          <p>Assignments</p>
        </a>
        <a href="personal">
          <img src="img/glowing-electronics.jpg" alt="A circuit with glowing components" />
          <p>Personal Project</p>
        </a>
      </div>
    </main>
    <?php include "modules/footer.html"?>
  </div>
</body>
</html>