<?php

include_once("inc-header.php");
include_once("inc-navbar.php");

include_once("backend/dbconnection.php");

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: account.html");
    exit();
}

$donor_id = $_SESSION["user_id"];

$sql = "SELECT de.*, e.*, r.*, do.*
        FROM donor_event de
        INNER JOIN events e
        ON de.event_id = e.event_id
        INNER JOIN recipient r
        ON r.recipient_id = e.recipient_id
        INNER JOIN donation do
        ON do.event_id = de.event_id
        WHERE do.donor_id = '$donor_id' AND de.donor_id = '$donor_id'";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = array();

    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    $rows[] = "";
}

$user_sql = "SELECT first_name, last_name, balance FROM donor WHERE donor_id = '$user_id'";
$user = $db->query($user_sql);

if ($user) {
    $u = $user->fetch_assoc();

    $firstname = $u["first_name"];
    $lastname = $u["last_name"];
    $balance = $u["balance"];
}

$total_donate = 0;
$max_donate = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>detail</title>

    <style>
        .d-container {
            position: absolute;
            top: 10rem;
            left: 14rem;
            width: 48%;
        }

        .sum-header {
            width: 100%;
            padding: 4px;
            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.3);
        }

        .sum-wrapper {
            width: 100%;
            padding: 8px;
            margin-top: 1rem;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
        }

        .sum-wrapper img {
            width: 72px;
            height: 72px;
            border-radius: 50%;
        }

        .side-container {
            position: fixed;
            top: 14rem;
            right: 13.66rem;
            width: 20%;
            padding: 12px;
            line-height: 3rem;
            font-size: 20px;
            color: black;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <div class="d-container d-flex flex-column align-items-start">
        <div class="sum-header d-flex flex-row align-items-center justify-content-start">
            <h3><?= strtoupper($firstname) . " " . strtoupper($lastname); ?></h3>
            <span style="position: absolute; right: 19rem;">Hesap özeti</span>
        </div>

        <?php for ($i = 0; $i < count($rows); $i++): ?>

            <div class="sum-wrapper d-flex flex-row align-items-center justify-content-evenly">
                <?php if ($rows[$i]["photo"] != NULL): ?>
                    <img src="uploads/<?= $rows[$i]["photo"] ?>" alt="int_img" style="object-fit: cover;">
                <?php else: ?>
                    <img src="uploads/default_img.png" alt="">
                <?php endif; ?>
                <span style="color: black; margin-left: 1rem; font-size: 14px;"><?= $rows[$i]["institution_name"]; ?></span>
                <p style="margin-left: 32px; margin-top: 15px; font-size: 18px; font-weight: bold;">
                    <?= $rows[$i]["event_name"]; ?>
                </p>
                <small style="position: absolute; margin-top:4rem; right: 8rem;">
                    <?= date("d.m.Y", strtotime($rows[$i]["created_time"])); ?>
                </small>
                <span style="position: absolute; right: 1rem; font-size: 18px; font-weight: bold; color: black;">
                    <?= number_format($rows[$i]["amount"], 0, ",", "."); ?>₺
                </span>
                <?php $total_donate += $rows[$i]["amount"];  ?>
            </div>

            <?php

            if ($rows[$i]["amount"] > $max_donate) {
                $max_donate = $rows[$i]["amount"];
                $max_don_event = $rows[$i]["event_name"];
            }

            ?>

        <?php endfor; ?>
    </div>

    <section class="side-container">
        <p style="font-size: 17px; text-decoration: underline;">En çok bağış yapılan etkinlik</p>
        <p style="font-weight: bold;"><i>"<?= $max_don_event ?>"</i> <small><?= $max_donate; ?>₺</small></p>
        <p>Yapılan toplam bağış: <b><?= number_format($total_donate, 0, ",", "."); ?>₺</b></p>
        <p>Bakiye: <b style="font-size: 32px; color: black;"><?= number_format(($balance - $total_donate), 0, ",", ".") ?>₺</b></p>
    </section>
</body>

</html>