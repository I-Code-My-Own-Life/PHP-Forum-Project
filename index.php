<?php include "partials/_dbconnet.php" ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>iDiscuss - Programming forums</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
  <!-- Navbar :  -->
  <?php include "partials/_navbar.php"; ?>
  <!-- Slider :  -->
  <?php include "partials/_slider.php"; ?>
  <!-- Forum content : ( Catgeories )  -->
  <div class="container my-5">
    <h2 class="text-center">iDiscuss - Browse Categories</h2>
    <div class="row">
      <?php 
      // Fetching all the categories : 
      $sql = "SELECT * FROM `categories`";
      $result = mysqli_query($conn,$sql);
      if(!$result){
        echo "Can't fetch categories";
      }
      else{
        for($i = 0; $i < mysqli_num_rows($result); $i++){
          $category = mysqli_fetch_assoc($result);
          $cateogry_name = $category["category_name"];
          $cateogry_description = $category["category_decription"];
          $category_id = $category["category_id"];
          echo '
          <div class="col-md-4 my-3">
            <div class="card" style="width: 18rem;">
              <img src="https://source.unsplash.com/300x200/?coding,'.$cateogry_name.'" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">  <a href="threadlist.php?id='.$category_id.'">'.$cateogry_name.'</a></h5>
                <p class="card-text">'. substr($cateogry_description,0,110).'...'.'</p>
                <a href="threadlist.php?id='.$category_id.'" class="btn btn-primary">View threads</a>
              </div>
            </div>
          </div>';
        }
      }
      ?>
    </div>
  </div>
  <!-- Footer :  -->
  <?php include "partials/_footer.php"; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
<script>
  let logoutBtn = document.getElementById("logoutBtn");
  logoutBtn.addEventListener("click",(event) => {
    location.href = "/PhpForum/partials/_logout.php";
  })
</script>

</html>
