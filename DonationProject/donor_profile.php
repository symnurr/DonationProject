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

$sql = "SELECT * FROM donor WHERE donor_id = $donor_id";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $donor_id = $row["donor_id"];
    $firstname = $row["first_name"];
    $lastname = $row["last_name"];
}

$sql = "SELECT de.*, d.*, e.*, do.*
        FROM donor_event de
        INNER JOIN donor d
        ON de.donor_id = d.donor_id
        INNER JOIN events e
        ON de.event_id = e.event_id
        LEFT JOIN donation do
        ON do.event_id = de.event_id
        WHERE do.donor_id = '$donor_id' AND de.donor_id = '$donor_id'
        ORDER BY de.ID DESC";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
} else {
    $rows = NULL;
}

?>



<div class="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <article class="blog-post-item mt-4">
                    <div class="post-thumb">
                        <div style="width: 760px; height: 320px; border-radius: 12px; background-color: #ff6984;">
                            <img src="uploads/donate_bg.png" alt="donate_bg" width="760" height="320">
                            <p style="position: absolute; top: 7.5rem; left: 2rem; width: 44%; color: white; font-size: 18px;">
                                Sizlerin desteği ile daha güzel bir gelecek inşa ediyoruz. Yardımlarınız için minnettarız &#128124;&#10084;
                            </p>
                            <a href="#" style="position: absolute; top: 15rem; left: 2rem; 
                            background-color: #ff6984; padding: 6px; border-radius: 4px; 
                            color: white; font-weight: bold; box-shadow: 0 4px 4px rgba(0, 0, 0, 0.2)">
                                Şimdi bağış yap :)
                            </a>
                        </div>
                    </div>

                </article>
                <h3>Katıldığım Etkinlikler</h3>
                <br>
                <?php if ($rows != NULL): ?>
                    <div class="d-flex flex-column">
                        <?php

                        setlocale(LC_TIME, 'tr_TR.UTF-8');
                        for ($i = 0; $i < count($rows); $i++):

                            $id = $rows[$i]['event_id'];
                        ?>
                            <div class="d-flex flex-row" onclick="window.location.href = 'event.php?id=<?= $id ?>'"
                                style="margin-bottom: 25px; cursor: pointer; padding: 8px; box-shadow: 0 0 8px rgba(0, 0, 0, 0.25); border-radius: 8px;">
                                <img src="uploads/<?= $rows[$i]["image"]; ?>" width="300" height="240" alt="">
                                <div class="d-flex flex-column">
                                    <h3 style="margin-top: 12px; margin-left: 16px; color: black;"><?= $rows[$i]["event_name"]; ?></h3>
                                    <p style="margin-top: 8px; margin-left: 16px; font-size: 14px;">
                                        <?= $rows[$i]["description"] ?>
                                    </p>
                                    <small style="margin-left: 20rem;"><?= date("d.m.Y", strtotime($rows[$i]["created_time"])) ?></small>
                                    <span style="margin-top: 8px; margin-left: 16px; font-size: 15px; font-weight: bold;">
                                        Bağış tutarım: <?= number_format($rows[$i]["amount"], 0, ",", "."); ?>₺
                                    </span>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <div class="sidebar-wrap">
                    <div class="sidebar-widget search p-4 mb-3 border-0">
                        <a href="donor_detail.php?id=<?= $donor_id; ?>" class="btn btn-main d-block mt-2">Bakiyem &#128181;</a>
                    </div>
                    <a href="edit_donor.php?id=<?= $donor_id; ?>"
                        style="background-color: #ff6984; margin-left: 2rem; padding: 12px; color: white; font-weight: bold; border-radius: 4px;">
                        Profili düzenle
                    </a>

                    <div class="sidebar-widget latest-post border-0 p-4 mb-3">
                        <h5 class="widget-title">Yaklaşan Etkinlikler</h5>

                        <div class="media border-bottom py-3">
                            <a href="#">
                                <img src="uploads/event1.png" alt="" class="mr-4"
                                    style="width: 95px; height: 95px; object-fit: cover;">
                            </a>
                            <div class="media-body">
                                <h6 class="my-2"><a href="#">Çocuklar için Teknoloji ve Bilim Kampanyası</a></h6>
                                <span class="text-sm text-muted">Oca 5, 2025</span>
                            </div>
                        </div>

                        <div class="media border-bottom py-3">
                            <a href="#"><img class="mr-4" src="uploads/event2.png" alt=""
                                    style="width: 95px; height: 95px; object-fit: cover;"></a>
                            <div class="media-body">
                                <h6 class="my-2"><a href="#">Ağaçlandırma ve Ormanları Koruma Kampanyası</a></h6>
                                <span class="text-sm text-muted">Şub 21, 2025</span>
                            </div>
                        </div>

                        <div class="media py-3">
                            <a href="#"><img class="mr-4" src="uploads/event3.png" alt=""
                                    style="width: 95px; height: 95px; object-fit: cover;"></a>
                            <div class="media-body">
                                <h6 class="my-2"><a href="#">Sokak Hayvanlarını Koruma Kampanyası</a></h6>
                                <span class="text-sm text-muted">Şub 23, 2025</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "inc-footer.php"; ?>