<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" href="IMAGES/logo.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" href="CSS/main.css">
    <meta name="description" content="კულინარიული რეცეპტების საიტი, კულინარიული ნივთების მაღაზია">
    <meta name="keywords" content="კულინარია, რეცეპტები, მაღაზია, საკვები, დესერტები, ხორცეული, სწრაფი კვება, ჩიზქეიქი, აჭარული ხაჭაპური, პასტა, ბრაუნი, ჰუმუსი, კარტოფილი, მოკა, კექსი, კოქტეილები, სტეიკი, პიცა, ცომეული, ტორტი, მაფინი, სალათი, მარწყვი, ბურგერი, FOOD FOR ALL,food for all, ფუდ ფორ ოლ">
    <meta name="author" content="Mariam Markozashvili">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER PROFILE</title>
</head>
<body>
<?php 
 include_once('connection.php');

 if($_SESSION['user'] == ''){
    header('location:login.php');
 }
?>
<div id="container" class="cont">
          <!--header-->
        <header id="headerWrapper">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php" class="logo-img">
                        <img src="IMAGES/logo.png" alt="FOOD FOR ALL">
                    </a>
                    <a href="index.php" class="logo-name">
                        FOOD FOR ALL
                    </a>
                </div>
                <ul id="logout-btn">
                    <li>
                        <a href="profile.php?logout='1'">
                           გამოსვლა
                        </a>
                    </li>
                </ul>
            </nav>
        </header>
          <!--end of header-->
<?php

$con = mysqli_connect('localhost','root','','mmbase');
$session_user = $_SESSION['user'];
$select = "SELECT * FROM `user` WHERE username = '$session_user'";
$result = mysqli_query($con,$select);
$row = mysqli_fetch_assoc($result);

?>
<div class="info">
<img  class="img-150" src="img/<?php echo $row['user_img']?>">

<p class="bg_black"><?php echo $row['username']; ?></p>
<p><?php echo $row['email']; ?></p>

</div>
    <form method="post" action="profile.php" id="save_form">
    <input type="password" id="password_old" name="password_old" placeholder="ძველი პაროლი">
    <input type="password" id="password_new" name="password_new" placeholder="ახალი პაროლი">
    <button name="change">პაროლის შეცვლა</button>
    </form>
    <p class="errors">
    <?php

    if(count($errors) > 0 ){
        foreach ($errors as $error) {
            echo $error.'<br/>';
        }
    }
   
    ?>
     </p>
    <a href="profile.php?delete='1'" class="delete">ანგარიშის გაუქმება</a>
   
    <p class="success"> <?php  echo $changed; ?> </p>

</div>
</body>
</html>