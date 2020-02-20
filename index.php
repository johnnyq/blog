<?php

include("admin/config.php");

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="plugins/summernote-master/dist/summernote-bs4.min.css">
    <title>Blog</title>
  </head>
  <body>

    <div class="bg-dark text-center p-5 mb-5">
      <h1 class="text-white display-4">PittPC Blog</h1>
      <h3 class="text-white-50">The one stop shop for all your tech ideas and needs</h3>
    </div>

      <div class="container">

        <div class="row">
            <div class="col-md-9">
                <?php

                $query = mysqli_query($db_conn,"SELECT * FROM blog"); 

                while($row = mysqli_fetch_array($query)){
          
              $blog_id = $row['blog_id'];
              $title = $row['blog_title'];
              $body = $row['blog_body'];
              $created_at = $row['blog_created_at'];
              $email = $row['user_email'];

                ?>
                  <div class="mb-5">
                    <h5 class="text-center text-secondary"><?php echo date("F d, Y", strtotime($created_at)); ?></h5>
                    <h1 class="text-center mb-3"><?php echo $title; ?></h1>
                    
                      <?php echo $body; ?>
                  </div>

            <?php 
            } 
            ?>

            
            <nav>
              <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                  <a class="page-link" href="#">Next</a>
                </li>
              </ul>
            </nav>

            </div>

            <div class="col-md-3">
            <div class="mb-3 text-center">
                  <h1><span class="badge badge-dark btn-block mb-3">Tags</span></h1>

                    <?php

                    $query = mysqli_query($db_conn,"SELECT * FROM blog");
                    while($row = mysqli_fetch_array($query)){
            
                      $blog_id = $row['blog_id'];
                      $title = $row['blog_title'];
                  
                    ?>

                      <p><?php echo $title; ?></p>
                   
                    <?php
                    }
                    ?>
                
                </div>

            </div>

        </div>
          
      </div>

    </div>

    <script src="js/jquery.min.js"></script>  
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="plugins/summernote-master/dist/summernote-bs4.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#summernote').summernote({
          height: 800,
        });
      });
    </script>

  </body>
</html>