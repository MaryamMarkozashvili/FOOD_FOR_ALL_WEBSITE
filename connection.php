
<?php
/*სესიის გახსნა*/
session_start();
/*მონაცემთა ბაზის დაკავშირება*/
$con = mysqli_connect('localhost','root','','mmbase');
/*ცვლადები შეტყობინებების  დასაბეჭდად*/
$success=''; /*წარმატებული რეგისტრაციისას*/
$changed=''; /*წარმატებით პაროლის შეცვლისას*/
$written=''; /*მომხმარებლის მონაცემების წარმატებით ჩაწერისას ტექსტურ ფაილში*/
/*შეცდომების მასივი*/
$errors=array();
/*თუ მონაცემთა ბაზასთან დაკავშირება ვერ მოხერხდა*/
if(!$con){
 echo 'Database Not Connected !!!';
}
/*რეგისტრაცია*/
if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
/*ფორმის ვალიდაცია*/
    if($_FILES['image']['name'] == ''){
        array_push($errors,'ფოტო არ არის არჩეული');
    }

    if($username == ''){
        array_push($errors,'მომხმარებლის ველი ცარიელია');
    }

    if($email == ''){
        array_push($errors,'ელ-ფოსტის ველი ცარიელია');
    }

    if($password1 == ''){
        array_push($errors,'პაროლის ველი ცარიელია');
    }

    if($password2 == ''){
        array_push($errors,'გაიმეორეთ პაროლის ველი ცარიელია');
    }

    if($password1 !== $password2){
        array_push($errors,'პაროლები არ ემთხვევა');
    }

    $select = "SELECT * FROM `user` WHERE username = '$username' or email = '$email'";
    $result = mysqli_query($con,$select);

/*თუ უკვე დარეგისტრირებული მომხმარებელი ცდის დარეგისტრირებას*/
    if(mysqli_num_rows($result)){

        array_push($errors,'ასეთი მომხმარებელი უკვე არსებობს');
    }
/*მომხმარებლის რეგისტრაციის თარიღი*/
    $date = date_default_timezone_set('Asia/tbilisi');
    $d = date('m/d/Y');

/*თუ არანაირი შეცდომა არ არსებობს დარეგისტრირდეს მომხმარებელი*/
    if(count($errors) == 0 ){
        $image = $_FILES['image']['name'];
        $target = "img/".basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $pass = md5($password1);
        $insert = "INSERT INTO `user` (`username`,`email`,`password`,`user_img`,`registration_time`) VALUES ('$username','$email','$pass','$image','$d')";
        if(mysqli_query($con,$insert)){
            $success='წარმატებით მოხდა რეგისტრაცია';
        }else{
            echo 'ვერ მოხდა რეგისტრაცია';
        }
    }

}
/*მომხმარებლის ანგარიშში შესვლა*/
if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username == ''){
        array_push($errors,'მომხმარებლის ველი ცარიელია');
    }
    if($password == ''){
        array_push($errors,'პაროლის ველი ცარიელია');
    }

    if(count($errors) == 0 ){
        $pass = md5($password);
        $select = "SELECT * FROM `user` WHERE username='$username' and `password`='$pass'";
        $result = mysqli_query($con,$select);

        if(mysqli_num_rows($result)){

            if($username == 'admin'){
                header('location:admin.php');
                $_SESSION['admin'] = $username;
            }else{
                header('location:profile.php');
                $_SESSION['user'] = $username;
            }

        }
    }

}
/*მომხმარებლის პაროლის შეცვლა*/
if(isset($_POST['change'])){
    $password_old = $_POST['password_old'];
    $password_new = $_POST['password_new'];

    if($password_old == ''){
        array_push($errors,'ძველი პაროლის ველი ცარიელია');
    }
    if($password_new == ''){
        array_push($errors,'ახალი პაროლის ველი ცარიელია');
    }

    if($password_old != '' and $password_new != ''){
        $session_user = $_SESSION['user'];
        $pass_old = md5($password_old);
        $select = "SELECT * FROM `user` WHERE username='$session_user' and password = '$pass_old'";
        $result = mysqli_query($con,$select);
        if(!mysqli_num_rows($result)){
            array_push($errors,'ძველი პაროლი არასწორია');
        }
    }

    if(count($errors) == 0 ){
        $pass_old = md5($password_old);
        $pass_new = md5($password_new);
        $select = "SELECT * FROM `user` WHERE username='$session_user' and password = '$pass_old'";
        $result = mysqli_query($con,$select);
        if(mysqli_num_rows($result)){
            $update = "UPDATE `user` SET password='$pass_new' WHERE username='$session_user'";
            if(mysqli_query($con,$update)){
                $changed='წარმატებით შეიცვალა';
            }
        }
    }

}
/*მომხმარებლის მონაცემების ჩაწერა ფაილში*/
if(isset($_POST['save'])){
    $select = "SELECT * FROM `user` WHERE username != 'admin' ORDER BY (id) DESC";
    $result = mysqli_query($con,$select);
    $row = mysqli_fetch_assoc($result);

    $user_information = ' username: '.$row['username'].' email: '.$row['email'].' Md5: '.$row['password'].' date: '.$row['registration_time']."  \r\n ";
    $myFile = "user.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, $user_information);
    fclose($fh);
    $written='მონაცემები წარმატებით შეინახა';

}
/*ანგარიშიდან გამოსვლა*/

if(isset($_GET['logout'])){
    unset($_SESSION['user']);
    session_destroy();
    header('location:login.php');
}
/*მომხმარებლის მიერ საკუთარი ანგარიშის წაშლა, ანუ გაუქმება*/
if(isset($_GET['delete'])){
    $session = $_SESSION['user'];
    $delete = "DELETE FROM `user` WHERE username = '$session'";
    mysqli_query($con,$delete);
    unset($_SESSION['user']);
    session_destroy();
    header('location:login.php');
}

?>