<?php

include_once("backend/dbconnection.php");

include_once("inc-header.php");
include_once("inc-navbar.php");

$donor_id = $_GET["id"];

$sql = "SELECT * FROM donor WHERE donor_id = '$donor_id'";

$result = $db->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    $firstname = $row["first_name"];
    $lastname = $row["last_name"];
    $birthday = $row["birthday"];
    $jobtitle = $row["job_title"];
    $institution = $row["institution"];
    $email = $row["email"];
    $phone = $row["phone"];
    $password = $row["password"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="col-md-6 right-box" style="margin-top: 8rem; margin-left: 24rem;">
        <form action="backend/edit_donor.php" method="post" id="donorSignupForm">
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-lg bg-light fs-6" name="firstname"
                    value="<?= $firstname; ?>" placeholder="İsim">
            </div>
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-lg bg-light fs-6" name="lastname"
                    value="<?= $lastname; ?>" placeholder="Soyisim">
            </div>
            <div class="input-group mb-1">
                <input type="date" class="form-control form-control-lg bg-light fs-6" name="birthday"
                    value="<?= $birthday; ?>" placeholder="">
            </div>
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-lg bg-light fs-6" name="jobtitle"
                    value="<?= $jobtitle; ?>" placeholder="Meslek">
            </div>
            <div class="input-group mb-1">
                <input type="text" class="form-control form-control-lg bg-light fs-6" name="institution"
                    value="<?= $institution; ?>" placeholder="Çalıştığın Kurum">
            </div>
            <div class="input-group mb-1">
                <input type="email" class="form-control form-control-lg bg-light fs-6" name="email"
                    value="<?= $email; ?>" placeholder="Email">
            </div>
            <div class="input-group mb-1">
                <input type="tel" class="form-control form-control-lg bg-light fs-6" name="phone"
                    value="<?= $phone; ?>" placeholder="555-555-55-55">
            </div>
            <div class="input-group mb-1">
                <input type="password" class="form-control form-control-lg bg-light fs-6" name="password"
                    value="<?= $password; ?>" placeholder="Şifre">
            </div>
            <div class="input-group mb-2">
                <button class="btn btn-lg btn-primary w-100 fs-6 mt-5" type="submit" name="islem"
                    value="signup">Profili düzenle</button>
            </div>
        </form>
    </div>
</body>

</html>