<!-- Can be accessed by both the admin and normal users -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title> Home </title>

  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/css/medium-editor.min.css" integrity="sha512-zYqhQjtcNMt8/h4RJallhYRev/et7+k/HDyry20li5fWSJYSExP9O07Ung28MUuXDneIFg0f2/U3HJZWsTNAiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/js/medium-editor.min.js" integrity="sha512-5D/0tAVbq1D3ZAzbxOnvpLt7Jl/n8m/YGASscHTNYsBvTcJnrYNiDIJm6We0RPJCpFJWowOPNz9ZJx7Ei+yFiA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
  
  <header id="page-header" class="header">
    <div class="inner">

      <div class="logo-container">
        <a href="./index.php" class="logo">Fake Blog</a>
      </div>

      <nav class="nav main-menu menu">
        <ul class="links-list">

          <li class="navlink"> <a href="">Home</a> </li>
          <?php
            include("./php/components/header.php");
          ?>

        </ul>
      </nav>

    </div>
  </header>

  <main class="main" id="page-content">

    <section id="landing-section">
      <div class="inner">
        
        <h1 class="main-heading">Fake Blog</h1>
        <h2 class="sub-heading">
          Welcome to my fake blog, a site built to try my hand at creating a blog system in HTML,
          CSS, JavaScript and PHP.
        </h2>

      </div>
    </section>

  </main>

</body>
</html>