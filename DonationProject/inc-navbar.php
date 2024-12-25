<?php
include_once("backend/dbconnection.php");

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: account.html");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM donor WHERE donor_id = '$user_id'";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    $donor = $result->fetch_assoc();
} 
else 
{
    $sql = "SELECT * FROM recipient WHERE recipient_id = '$user_id'";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $recipient = $result->fetch_assoc();
    }
    else
    {
        echo "<div class='alert alert-danger text-center' style='margin: 200px 30%'> GEÇERSİZ GİRİŞ! <br> lütfen daha sonra tekrar deneyiniz. </div>";
        die();
    } 
}

?>
<!-- NAVBAR  -->
<div class="main-navigation main_menu " id="mainmenu-area" style="position: fixed; width: 100%;">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="index.php">
                <h1 style="color: #ff6984;">D<span style="color: black;">estekeli</span></h1>
            </a>
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu-alt"></span>
            </button>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <!-- Links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ">
                        <a href="index.php" class="nav-link js-scroll-trigger">
                            Anasayfa
                        </a>
                    </li>

                    <li class="nav-item ">
                        <?php
                            if (isset($donor)) 
                            {
                                ?>
                                <a href="events.php" class="nav-link js-scroll-trigger"> Etkinlikler </a>
                                <?php
                            }
                            else
                            {
                                ?>
                                <a href="recipient.php?id=<?= $user_id ?>" class="nav-link js-scroll-trigger"> Profilim </a>
                                <?php
                            }
                        ?>
                    </li>

                    <li class="nav-item mt-2 mr-2">
                        <?php if (isset($donor)): ?>
                            <a href="donor_profile.php?id=<?= $user_id ?>" style="text-decoration: none; color: white; background-color: #ff6984; 
                                padding: 8px; border-radius: 50%;">
                                <?= mb_strtoupper(mb_substr($donor["first_name"], 0, 1)) . mb_strtoupper(mb_substr($donor["last_name"], 0, 1)) ?>
                            </a>
                        <?php 
                            else: 

                            $namee = "";
                            foreach (explode(" ", $recipient["institution_name"]) as $word) 
                            {
                                $namee .= strtoupper($word[0]);
                            }
                        ?>
                            <a href="recipient.php?id=<?= $user_id ?>" style="text-decoration: none; color: white; background-color: #ff6984; 
                                padding: 8px; border-radius: 50%;">
                                <?=$namee ?>
                            </a>
                        <?php endif ?>
                        
                    </li>
                </ul>

                <ul class="list-inline header-contact float-lg-right">
                    <li class="list-inline-item">
                        <a href="#" class="btn btn-solid-border btn-sm"><i
                                class="ti-headphone-alt mr-2"></i>0 (216) 444 0000</a>
                    </li>
                    <li class="list-inline-item">
                        <a href="backend/logout.php" class="btn btn-main-2 btn-sm">Çıkış yap</a>
                    </li>
                </ul>
            </div> <!-- / .navbar-collapse -->
        </nav>
    </div> <!-- / .container -->
</div>