<?php

include_once('inc-header.php');
include_once('inc-navbar.php');
include_once('assets/erolib/main.html');

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: account.html");
    exit();
}

$recipient_id = $_SESSION["user_id"];


$stmt = $db->prepare('
	SELECT r.*, e.* FROM recipient r
	LEFT JOIN events e on e.recipient_id = r.recipient_id 
	WHERE r.recipient_id = ?
	');
$stmt->bind_param('i', $recipient_id);
$stmt->execute();
$recipient = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>



<div class="container" style="margin-top: 150px">

	<!-- Kişisel Bilgiler -->
	<div class="ero-card1">
	    <h5 class="ero-card1-header"> 
	        KİŞİSEL BİLGİLERİM
	    </h5>
	    <div class="ero-card1-body">
	        <p class="ero-card1-text mb-4"> Günün Sözü : "Yeni bir bağış günüme daha merhaba" </p>
	        <div class="ero-card1-innerbody">

				<div class="row m-0 mb-4 border p-3">

					<div class="col-12 col-lg-2">
						<img src="uploads/<?=$recipient[0]['photo']?>" style="height: 100px; object-fit: cover; width: 100%">
					</div>
					
					<div class="col-12 col-lg-6">
						<p class="my-1" style="font-weight: bold;"> <?=$recipient[0]['institution_name']?> </p>
						<p> <?=$recipient[0]['activity']?> </p>
					</div>

					<div class="col-12 col-lg-4 text-right">
						<p class="my-1" style="font-weight: bold;"> Kuruluş Tarihi </p>
						<p> <?=$recipient[0]['created_time']?> </p>
					</div>

				</div>

				<div>
					<button class="btn btn-primary" disabled> <i class="fa fa-user"></i> Profili Düzenle </button>
				</div>

	        </div>
	    </div>
	</div>

	<!-- Etkinlik Oluştur -->
	<div class="ero-card1">
	    <h5 class="ero-card1-header"> 
	        HIZLI ETKİNLİK OLUŞTUR
	    </h5>
	    <div class="ero-card1-body">
	        <form action="backend/createEvent.php" method="POST" enctype="multipart/form-data">
	            <div class="ero-card1-innerbody">
	                <div class="row m-0 mb-4 border p-3">
	                    <div class="col-12 col-lg-6">
	                        <label for="event_name" class="my-1" style="font-weight: bold;">Etkinlik Adı</label>
	                        <input type="text" id="event_name" name="event_name" class="form-control" required>
	                    </div>

	                    <div class="col-12 col-lg-6">
	                        <label for="location" class="my-1" style="font-weight: bold;">Etkinlik Yeri</label>
	                        <input type="text" id="location" name="location" class="form-control" required>
	                    </div>

	                    <div class="col-12 col-lg-6">
	                        <label for="description" class="my-1" style="font-weight: bold;">Açıklama</label>
	                        <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
	                    </div>

	                    <div class="col-12 col-lg-6">
	                        <label for="end_time" class="my-1" style="font-weight: bold;">Bitiş Tarihi</label>
	                        <input type="datetime-local" id="end_time" name="end_time" class="form-control" required>
	                    </div>

	                    <div class="col-12 col-lg-6">
	                        <label for="image" class="my-1" style="font-weight: bold;">Etkinlik Resmi</label>
	                        <input type="file" id="image" name="image" class="form-control" required>
	                    </div>

	                    <div class="col-12 text-center mt-3">
	                        <button type="submit" class="btn btn-primary">Etkinlik Oluştur</button>
	                    </div>
	                </div>
	            </div>
	        </form>
	    </div>
	</div>


	<!-- Etkinlikler -->
	<div class="ero-card1">
	    <h5 class="ero-card1-header"> 
	        ETKİNLİKLERİM
	    </h5>
	    <div class="ero-card1-body">
	        <p class="ero-card1-text mb-4"> Buradan yeni etkinlik oluşturabilir veya daha önceden oluşturulmuş etkinliklerinize göz atabilirsiniz! </p>
	        <div class="ero-card1-innerbody">
				<div class="row">

						<?php foreach ($recipient as $event): ?>

						<div class="col-12 col-lg-6 mb-3 p-2">
							
							<div class="event-box row m-0 py-3 px-1">

								<div class="col-12 col-lg-6">
									<img src="uploads/<?=$event['image']?>?>" style="height: 200px; width: 100%; object-fit: cover;">
								</div>

								<div class="col-12 col-lg-6">
									<p class="m-0" style="font-weight: bold;"> <?=$event['event_name']?> </p>
									<p> <small> <?=$event['description']?> </small> </p>
									<a href="event.php?id=<?=$event['event_id']?>" class="btn btn-main-2 btn-sm" disabled> <i class="fa fa-user"></i> Etkinliğe Git </a>
								</div>

							</div>

						</div>

						<?php endforeach ?>

				</div>

	        </div>
	    </div>
	</div>

</div>



<?php
include_once('inc-footer.php');
?>