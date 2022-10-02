<?php
    session_start();
    if(!$_SESSION['id']){
        header("location:index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" 
      integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    body{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: arial, sans-serif;
    }
    span{
        color: white;
        font-size: 20px;
    }
    a{
        text-decoration: none;
        color: black;
    }
    header{
        background-color: #75E6DA;
        width: 100%;
        height: 60px;
        display: flex;
        justify-content: space-between;
        padding: 20;
    }
    ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        margin-right: 30px;
    }
    li{
        float: left;
    }
    li a{
        display: block;
        color: white;
        text-align: center;
        padding: 20px 15px 0px 0px;
        text-decoration: none;
    }
    li a:hover{
        color: #274472;
        transition: 1s;
    }
    h2{
        text-align: center;
        margin-bottom: 10px;
        margin-top: 25px;
    }
    .zahtevi{
        display: flex;
        justify-content: center;
        margin-bottom: 10px; 
    }
    table{
        margin-top: 20px;
        border-collapse: collapse;
        width: 60%;
    }
    table th{
        background-color:#fb3958;
        color: white;
    }
    td, th{
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    tr:nth-child(even) {
        background-color: #C3E0E5;
    }
    .tacno{
        color: green;
        font-size: 20px;
        cursor: pointer;
        margin-left: 30%;
    }
    .netacno{
        color: red;
        font-size: 20px;
        cursor: pointer;
    }
    h1{
        text-align: center;
    }
    footer{
        background-color: #75E6DA;
        height: 200px;
        width: 100%;
        display: flex;
        justify-content: space-evenly;
        margin-top: 200px;
    }
    footer p{
        margin-bottom: 0;
    }
</style>
</head>
<body>
    <header>
        <a href="index.php"><p style="margin-left:20px;padding: 2px 15px 0px 0px;"><span>MED</span> ORL</p></a>
        <ul>
            <li><a href="index.php">O nama</a></li>
            <li><a href="usluge.php">Usluge</a></li>
            <li><a href="vesti.php">Blog</a></li>
            <li><a href="cenovnik.php">Cenovnik</a></li>
            <li><a href="kontakt.php">Kontakt</a></li>
            <?php
                if(isset($_SESSION["id"])){
                    echo"<li><a href='profil.php'><i class='fas fa-user-alt'></i></a></li>";
                    echo"<li><a href='includes/logout.inc.php'><i class='fas fa-power-off' style='color:red'></i></a></li>";
                }
                else{
                    echo"<li><a href='login.php'>Prijavi se</a></li>";
                }
            ?>
        </ul>
    </header>

    <?php
        require_once "includes/functions.inc.php"; 
        require_once "includes/dbh.inc.php";

        $serverName = "localhost";
        $dbUsername = "Muhamed";
        $dbPassword = "projekatphp";
        $dbName = "ProjekatPhp";
        $conn = mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);
        if(!$conn){
            die("Connection failed: ".mysqli_connect_error());
        }
        $sql = "SELECT Id,Ime,Prezime,Email,Jmbg,Mesto_rodjenja,Pol,Username FROM doktor WHERE Cekiraj = 0;";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo "<h2>Zahtevi za odobravanje doktora</h2>";
            echo "<div class='zahtevi'>";
                echo "<table>";
                    echo "<tr>";
                        echo "<th>Doktor</th>";
                        echo "<th>Jmbg</th>";
                        echo "<th>Email</th>";
                        echo "<th>Mesto rodjenja</th>";
                        echo "<th>Pol</th>";
                        echo "<th>Prihvati/Izbrisi</th>";
                    echo "</tr>";
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                        echo "<td>".$row["Ime"]." ".$row["Prezime"]."</td>";
                        echo "<td>".$row["Jmbg"]."</td>";
                        echo "<td>".$row["Email"]."</td>";
                        echo "<td>".$row["Mesto_rodjenja"]."</td>";
                        echo "<td>".$row["Pol"]."</td>";
                        echo "<td><a href='includes/odobravanjeDoktora.inc.php?Jmbg=$row[Jmbg]&Email=$row[Email]&Username=$row[Username]' onclick='return checkAdd()'>
                        <i class='fa-solid fa-circle-check tacno'></i></a> / <a href='includes/neOdobravanjeDoktora.inc.php?Jmbg=$row[Jmbg]&Email=$row[Email]' 
                        onclick='return checkDelete()'><i class='fa-solid fa-circle-xmark netacno'></i></a></td>";
                    echo "</tr>";
                }   
                echo "</table>";
            echo "</div>";
        }
        else{
            echo "<h1>Trenutno nema zahteva za doktora</h1>";
        }
    ?>

    <footer>
        <div>
            <h2>Lokacija</h2>              
            <p><i class="fa-solid fa-location-dot" style="color: red;font-size: 20px"></i> Moše pijade 6</p>               
            <p><i class="fa-solid fa-location-dot" style="color: red;font-size: 20px"></i> 36300 Novi Pazar</p>               
            <p>Radno vreme: 07-22h</p>
        </div>
        <div>
            <h2>Kontakt</h2>
            <p><i class="fa-solid fa-phone" style="color: green;font-size: 20px"></i> +381 69 16 15 980</p>
            <p><i class="fa-solid fa-phone" style="color: green;font-size: 20px"></i> +381 63 86 15 980</p>
            <p><a href="mailto: medclinic@gmail.com" style="text-decoration: none;color: black"><i class="fa-solid fa-envelope" style="color: brown;font-size: 20px"></i> medclinic@gmail.com</a></p>
        </div>
        <div>
            <h2>Pratite nas</h2>
            <p><a href="https://www.instagram.com/muhamed.sadovic/"><i class="fa-brands fa-instagram" style="color: #fb3958;font-size: 20px"></i></a> 
            <a href="https://www.facebook.com/profile.php?id=100007525925196"><i class="fa-brands fa-facebook" style="color: blue;font-size: 20px"></i></a> 
            <a href="https://www.youtube.com/channel/UCKOhscLr35pxkNaUN3X6J_A"><i class="fa-brands fa-youtube" style="color: red;font-size: 20px"></i></a></p>
        </div>
    </footer>   
    <script>
        function checkDelete(){
            return confirm('Da li ste sigurni da želite da izbrišete ovaj zahtev?');
        }
        function checkAdd(){
            return confirm('Da li ste sigurni da želite da prihvatite ovaj zahtev?');
        }
    </script>  
</body>
</html>