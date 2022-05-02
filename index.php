<?php
  include_once "includes/dbs.inc.php";
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.1.1/css/all.css">
    <link rel="stylesheet" href="css/container.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script language="javascript">
        $("#download").click(function() {
        $.ajax({
            url: "addVix.class.php"
        }).done(function() { 
            $(this).addClass("done");
        });
        });
    </script>
    <title>Faculta.ro</title>
</head>
<body>
    <div class="container">
        <center>
            <h1>Caută subiecte pentru admitere</h1>
            <h2>și probabil rezolvări..</h2><br>
            <form action="" method="get">
                <button type="submit"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                <input type="search" name="find" id="search_boxSearchHelp" placeholder="Scrie aici ce cauți">
            </form>
            <div>&nbsp;</div><div class="clearfix">&nbsp;</div>
        <?php
            $ok = 0;
            if(isset($_GET["find"])){
                if(!empty($_GET["find"])){
                    $search = $_GET["find"];
                    $sqlfind = "SELECT * FROM fisiere WHERE tags LIKE '%".$search."%'";
                    $sqlfindSQL = mysqli_query($conn,$sqlfind);
                    
                    echo "Ați căutat: ".$search;
                    if (mysqli_num_rows($sqlfindSQL) > 0) {
                        echo '<table>
                                    <tr>
                                        <th>Titlu</th>
                                        <th>Universitate</th>
                                        <th>Specializare</th>
                                        <th>Descarcari</th>
                                        <th>Data</th>
                                        <th>Download</th>
                                    </tr>';
                        if(mysqli_num_rows($sqlfindSQL) > 10){
                            $pages = mysqli_num_rows($sqlfindSQL)/10;
                            if(mysqli_num_rows($sqlfindSQL)%10 > 0){
                                $pages++;
                            }
                            if(isset($_POST['pagina'])){
                                $i = $_POST['pagina'] - 1;
                            } else {
                                $i = 0;
                            }
                            $sqlfind = "SELECT * FROM fisiere WHERE id>=10*$i AND id<10*($i+1) AND tags LIKE '%".$search."%';";
                            $sqlfindSQL = mysqli_query($conn,$sqlfind);
                            while($row = mysqli_fetch_assoc($sqlfindSQL)){
                                echo "<tr>";
                                echo '<td>'.$row["titlu"].'</td>';
                                echo '<td>'.$row["universitate"].'</td>';
                                echo '<td>'.$row["specializare"].'</td>';
                                echo '<td>'.$row["descarcari"].'</td>';
                                echo '<td>'.$row["data"].'</td>';
                                echo '<td><form action="includes/addVix.inc.php" method="POST" target="_blank">
                                                <button type="submit" name="'.$row["id"].'">Download</button>
                                            </form></td>';
                                echo '</tr>';
                                $ok=1;
                            }
                            echo '<div class="container_table">
                            <form action="" method="POST" class="newsletter_conf">';
                            for($k=1;$k<=$pages;$k++){
                                if(isset($_POST['pagina'])){
                                    if($k == $_POST['pagina']){
                                        echo '<input type="submit" value="'.$k.'" name="pagina" class="pagina_curenta">';
                                    } else{
                                        echo '<input type="submit" value="'.$k.'" name="pagina" class="pagini">';
                                    }
                                } else {
                                    if($k == 1){
                                        echo '<input type="submit" value="'.$k.'" name="pagina" class="pagina_curenta">';
                                    } else {
                                        echo '<input type="submit" value="'.$k.'" name="pagina" class="pagini">';
                                    }
                                }
                            }
                            echo '</form></div>';
                        } else{
                            while($row = mysqli_fetch_assoc($sqlfindSQL)){
                                echo "<tr>";
                                echo '<td>'.$row["titlu"].'</td>';
                                echo '<td>'.$row["universitate"].'</td>';
                                echo '<td>'.$row["specializare"].'</td>';
                                echo '<td>'.$row["descarcari"].'</td>';
                                echo '<td>'.$row["data"].'</td>';
                                echo '<td><form action="includes/addVix.inc.php" method="POST" target="_blank">
                                                <button type="submit" name="'.$row["id"].'">Download</button>
                                            </form></td>';
                                echo '</tr>';
                                $ok=1;
                            }
                            if($ok == 0){
                                echo '<td>'."Nu au fost găsite subiecte.".'</td>';
                                echo '</table>';
                            } else{
                                echo '</table>';
                            }
                        }
                        
                    }
                        
                } else {
                    echo '<h5>'."Nu au fost găsite subiecte.".'</h5>';
                    exit();
                }
            }
        ?>
    </div>
    </center>
    <div>&nbsp;</div><div class="clearfix">&nbsp;</div>
</body>
</html>