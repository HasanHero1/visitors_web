<?php
    $servername  = "localhost";
    $username    = "root";
    $password    = "";
    $dbname      = "account";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(isset($_GET['vkey'])){
        /* Get the verification key and match with database verification key */
        $vkey = $_GET['vkey'];
        $sql = "SELECT vstatus, vkey FROM signup WHERE vstatus = 0 AND vkey='$vkey' LIMIT 1";
        $query = mysqli_query($conn,$sql);
        if(mysqli_num_rows($query)>0){
            $sql = "UPDATE signup SET vstatus = 1 WHERE vkey='$vkey' LIMIT 1";
            $query = mysqli_query($conn,$sql);
            if($query){
                echo '<div class="bs-example">
                        <div class="alert alert-warning alert-dismissible fade show">
                            <strong>Success</strong> Please Check Your Email To complete the registration
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    </div>';
           }
       }
   }
?>
