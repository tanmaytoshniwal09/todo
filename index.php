<?php
  $server="localhost";
  $username="root";
  $password="";
  $database="todo_master";

  $conn=mysqli_connect($server,$username ,$password,$database);
  if($conn->connect_errno)
  {
    die('Connection to MYSQL Failed : '. $conn->connect_errno);
  }

  // creating a new task 
  if(isset($_POST['add']))
  {
    $item=$_POST['item'];
    if(!empty($item))
    {
        $query= "INSERT INTO todo(name) VALUES ('$item')";
        if( mysqli_query($conn, $query))
        {
            echo'<center>
            <div class="alert alert-success" role ="alert">
                Item Added Successfully!
            </div>
            </center>';
        }
        else
        {
            echo mysqli_errno($conn);
        }

    }
  }
  //  creating mark as done  
  if(isset($_GET['action']))
  {
    $itemid=$_GET['item'];
    if($_GET['action']=='done')
    {
        $query= "UPDATE todo SET status=1 where id = '$itemid'";
        if( mysqli_query($conn, $query))
        {
            echo'<center>
            <div class="alert alert-info" role ="alert">
               Item Marked as Done
            </div>
            </center>';
        }
        else
        {
            echo mysqli_errno($conn);
        }

    } 
    else if($_GET['action']=='delete')
    {
      $query="DELETE FROM todo WHERE id='$itemid'";
      if( mysqli_query($conn, $query))
          {
              echo'<center>
              <div class="alert alert-danger" role ="alert">
                  Item Deleted Successfully!
              </div>
              </center>';
          }
          else
          {
              echo mysqli_errno($conn);
          }
    }
  }
 // php database connected
?>

<!DOCTYPE html>
<html>

<head>
    <title>ToDo List Application</title>
    <!-- Set the path for Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <style>
        .done{
            text-decoration:line-through;
        }
        </style>
    </head>

<body>
    <main>
        <!-- <center>
            <div class="alert alert-success" role ="alert">
                Item Added Successfully!
            </div>
            <div class="alert alert-info" role ="alert">
                Item Marked as Done
            </div>
            <div class="alert alert-danger" role ="alert">
                Item Deleted Successfully!
            </div>
        </center> -->
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-12 col-md-3"></div>
                <div class="col-sm-12 col-md-6">
                    <!-- Corrected class name from "col md" to "col-md" -->
                    <div class="card">
                        <div class="card-header">
                            <p>ToDo List</p>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="item" placeholder="Add Todo Items">
                                </div>
                                <input type="submit" class="btn btn-dark" name="add" value="Add Item">
                            </form>


                            <div class="mt-5 mb-5">

                                <?php
                                        $query = "SELECT * FROM todo";
                                        $result = mysqli_query($conn, $query);
                                       
                                        if ($result->num_rows > 0) {
                                            $i=1;
                                            while($row=$result->fetch_assoc()){
                                                $done=$row['status']==1 ? "done" : "" ;

                                            echo '
                                                <div class="row mt-4">
                                                <div class="col-sm-12 col-md-1"><h5> '.$i.' </h5></div>
                                                <div class="col-sm-12 col-md-6"><h5 class= '.$done.'>'.$row['name'].'</h5></div>
                                                <div class="col-sm-12 col-md-5">
                                                    <a href="?action=done&item='.$row['id'].'" class="btn btn-outline-dark" >Mark as Done</a>
                                                    <a href="?action=delete&item='.$row['id'].'" class="btn btn-outline-danger">Delete</a>
                                                </div>
                                            </div>';
                                            $i++;
                                            }
                                        } else {
                                            echo '<center>
                                                <img src="folder.png" width="50px" alt="Empty List" height="60px" ><br><span>Your List Empty</span>
                                            </center>';
                                        }
                                    ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
        </center>
    </main>
    <!-- Set the path for jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Set the path for Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <!-- Set the path for Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    $(document).ready(function() {
        $(".alert").fadeTo(5000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
        });
    });
    </script>
</body>

</html>