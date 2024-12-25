<?php

include_once('inc-header.php');
include_once('inc-navbar.php');
include_once('assets/erolib/main.html');



if (isset($_GET['id'])) 
{
	$event_id = $_GET['id'];

	$stmt = $db->prepare('
		SELECT r.*, e.*, d.*, donor.*, e.event_id as e_ID FROM events e
		INNER JOIN recipient r on r.recipient_id = e.recipient_id
		LEFT JOIN donation d on d.event_id = e.event_id
		LEFT JOIN donor on donor.donor_id = d.donor_id
		WHERE e.event_id = ?
		');
	$stmt->bind_param('i', $event_id);
	$stmt->execute();
	$event = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
else
{
	echo "<div class='alert alert-danger text-center' style='margin: 200px 30%'> GEÇERSİZ ID! <br> lütfen başka bir etkinlik için tekrar deneyiniz. </div>";
	die();
}

?>



<div class="container" style="margin-top: 150px">

	<!-- Kişisel Bilgiler -->
	<div class="ero-card1">
	    <div class="ero-card1-header"> 
	        <h5 class="text-white"> <?=$event[0]['event_name']?> </h5> 
	        <i> <?=$event[0]['description']?> </i>
	    </div>
	    <div class="ero-card1-body">
	        <p class="ero-card1-text mb-4"> Günün Sözü : "Yeni bir bağış günüme daha merhaba" </p>
	        <div class="ero-card1-innerbody">

	        	<h5> Etkinlik Sahibi Kurum </h5>
				<div class="row m-0 mb-5 border p-3 align-items-center">

					<div class="col-12 col-lg-1 p-0">
						<img src="uploads/<?=$event[0]['photo']?>" style="height: 100px; object-fit: cover; width: 100%">
					</div>
					
					<div class="col-12 col-lg-7">
						<p class="my-1" style="font-weight: bold;"> <?=$event[0]['institution_name']?> </p>
						<p> <b>Amaç: </b> <?=$event[0]['purpose']?> </p>
					</div>

					<div class="col-12 col-lg-4 text-right">
						<p class="my-1" style="font-weight: bold;"> Kuruluş Tarihi </p>
						<p> <?=$event[0]['created_time']?> </p>
					</div>

				</div>

				<h5> Etkinlik Hakkında </h5>
				<div class="row m-0 mb-5 border px-3 py-4">
					
					<div class="col-12 col-lg-6">
						<h3 class="text-center" style="font-weight: bold;"> <?=$event[0]['event_name']?> </h3>
						<p class="text-center text-black"> <?=$event[0]['description']?> </p>
						<p style="text-indent: 30px; text-align: justify;">
							<?=$event[0]['description']?>
							<?=$event[0]['description']?>
							<?=$event[0]['description']?>
							<?=$event[0]['description']?>
							<?=$event[0]['description']?>
							<?=$event[0]['description']?>
						</p>
					</div>

					<div class="col-12 col-lg-6">
						<img src="uploads/<?=$event[0]['image']?>?>" class="w-100" style="object-fit: contain;">
					</div>

				</div>

				<h5> Etkinlik Detayları </h5>
				<div class="row m-0 mb-5 border px-3 py-4">
					
					<div class="col-12 col-lg-3">
						<p class="my-1" style="font-weight: bold;"> Başlama Tarihi </p>
						<p class="my-1" > <?=$event[0]['created_time']?> </p>
					</div>

					<div class="col-12 col-lg-3">

						<?php

						$stmt = $db->prepare('
						    SELECT COUNT(*) AS count, COALESCE(SUM(d.amount), 0) AS total_amount 
						    FROM donor_event de
						    LEFT JOIN donation d ON de.donor_id = d.donor_id AND de.event_id = d.event_id
						    WHERE de.event_id = ?
						');
						$stmt->bind_param('i', $event_id);
						$stmt->execute();
						$result = $stmt->get_result();
						$row = $result->fetch_assoc();
						$count = $row['count'];
						$total_amount = $row['total_amount'];



						?>

						<p class="my-1" style="font-weight: bold;"> Toplam Katılımcı </p>
						<p class="my-1" > <?=$count?> Kişi </p>
					</div>

					<div class="col-12 col-lg-3">
						<p class="my-1" style="font-weight: bold;"> Toplam Bağış Miktarı </p>
						<p class="my-1" > ₺<?=$total_amount?> </p>
					</div>

					<div class="col-12 col-lg-3">
						<p class="my-1" style="font-weight: bold;"> Bitiş Tarihi </p>
						<p class="my-1" > <?=$event[0]['end_time']?> </p>
					</div>

				</div>

				<h5> Bağışta Bulunun </h5>
				<div class="row m-0 mb-5 border px-3 py-4">
					
					<form method="post" action="backend/process_donation.php" class="col-12 col-lg-6">
						<input type="hidden" name="event_id" value="<?=$event[0]['e_ID']?>">
					    <div class="form-group">
					        <label for="donorName" class="text-dark">Adınız</label>
					        <input type="text" class="form-control" id="donorName" name="donor_name" placeholder="Adınızı girin" required>
					    </div>
					    <div class="form-group">
					        <label for="donorEmail" class="text-dark">E-posta</label>
					        <input type="email" class="form-control" id="donorEmail" name="donor_email" placeholder="E-posta adresinizi girin" required>
					    </div>
					    <div class="form-group">
					        <label for="donationAmount" class="text-dark">Bağış Tutarı (₺) </label>
					        <input type="number" class="form-control" min="10" value="10" id="donationAmount" name="donation_amount" placeholder="Bağış miktarını girin" required>
					    </div>
					    <div class="form-group">
					        <label for="donorNote" class="text-dark">Not</label>
					        <textarea type="email" class="form-control" id="donorNote" name="donor_note" placeholder="Bağışınız hakkında düşüncelerinizi buraya yazabilirsiniz." maxlength="200" rows="4"></textarea>
					    </div>
					    <button type="submit" class="btn btn-main-2"> <i class="fa fa-heart"></i> Bağış Yap</button>
					</form>

					<div class="col-12 col-lg-6 d-flex align-items-center justify-content-center">
						<img src='assets/our/img/donate.png' class="w-100 h-100" style="object-fit: cover;">
						<div class="position-absolute" style="text-shadow: 2px 2px 3px black;">
							<p class="text-white text-center" style="font-size: 24px;"> Bağışlarınız için teşekkür ederiz... </p>
						</div>
					</div>

				</div>

				<h5> Yapılan Bağışlar </h5>
				<div class="mb-5">

					<?php $counter = 0; foreach ($event as $donate): ?>
						
						<?php if ($donate['amount'] <= 0) continue; ?>

						<?php $counter++ ?>

						<div class="row m-0 mb-3 d-flex border p-3">
							
							<div class="col-12 col-lg-1 align-items-center">
								<img src="assets/our/img/recipient_icon.png" class="w-100" style="height: 50px; object-fit: contain; border-radius: 50%;">
							</div>

							<div class="col-12 col-lg-6">
								<p class="m-0 text-dark" style="font-weight: bold;"> <?=$donate['first_name'] . ' ' . $donate['last_name'] ?> </p>
								<p class="m-0"> <?=$donate['note']?> </p>
							</div>

							<div class="col-12 col-lg-3">
								<p class="m-0 text-dark" style="font-weight: bold;"> Bağış Tarihi </p>
								<p class="m-0"> <?=$donate['donation_date']?> </p>

							</div>

							<div class="col-12 col-lg-2 text-right">
								<p class="m-0 text-dark" style="font-weight: bold;"> Bağış Miktarı </p>
								<p class="m-0"> ₺ <?=$donate['amount']?> </p>
							</div>

						</div>

					<?php endforeach; ?>

					<?php
						if ($counter < 0) {
							?>
							<div class="my-3 alert alert-danger"> Henüz bir bağış yapılmamış... </div>
							<?php
							}
					?>

				</div>

	        </div>
	    </div>
	</div>

</div>



<?php
include_once('inc-footer.php');
?>