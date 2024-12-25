<?php
include_once('inc-header.php');
include_once('inc-navbar.php');
?>

<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: account.html");
    exit();
}

$donor_id = $_SESSION["user_id"];

// Step 1: Get the event_ids for this donor
$stmt = $db->prepare('SELECT event_id FROM donor_event WHERE donor_id = ?');
$stmt->bind_param('i', $donor_id);
$stmt->execute();
$result = $stmt->get_result();
$donor_events = [];

while ($row = $result->fetch_assoc()) {
    $donor_events[] = $row['event_id'];
}

// Step 2: Prepare the query to fetch events that are not in the donor_event table for this donor
if (count($donor_events) > 0) {
    $placeholders = implode(',', array_fill(0, count($donor_events), '?'));
    $stmt = $db->prepare('SELECT * FROM events WHERE event_id NOT IN (' . $placeholders . ') ORDER BY event_id DESC');
    $types = str_repeat('i', count($donor_events));
    $stmt->bind_param($types, ...$donor_events);
    $stmt->execute();
	$events = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    // If the donor has no events, just fetch all events
    $stmt = $db->query('SELECT * FROM events');
    $events = $stmt->fetch_all(MYSQLI_ASSOC);
}



?>

<style type="text/css">
	
.event-box:hover {
	box-shadow: 3px 3px 5px lightgray;
	transition: 0.2s;
}

.event-box {
	transition: 0.2s;
	box-shadow: 3px 3px 5px white;
}

</style>

<div class="container" style="margin-top: 75px;">

	<section class="section latest-blog">
		<div>

			<div class="row justify-content-center border p-5 mt-3 mb-5">
				<div class="col-lg-6">
					<div class=" text-center">
						<span class="text-color">ETKİNLİKLERİ KEŞFET</span>
						<h2>Yeni Etkinlikler Bulmanın <br> Tam Zamanı!</h2>
						<p class="mb-0">Bağış etkinliği, ihtiyaç sahiplerine destek olmayı ve toplumsal dayanışmayı güçlendirmeyi amaçlayan anlamlı bir organizasyondur. Bu etkinlik, hem bireylerin hem de kurumların katkılarıyla, toplumun farklı kesimlerine yardım eli uzatarak fark yaratmayı hedefler.</p>
					</div>
				</div>
			</div>

			<div class="row">

				<?php foreach ($events as $e): $id = $e['event_id'] ?>
					
					<div class="p-3 col-lg-4 col-sm-6 col-md-6" onclick="window.location.href = 'event.php?id=<?=$id?>'">
						<div class="event-box mb-4 border">
							<h3 class="mt-3 mb-3 text-center"><a href="blog-single.html"> <?=$e['event_name']?> </a></h3>
							<div class="blog-item mb-5 mb-lg-0">
								<img src="uploads/<?=$e['image']?>" alt="" class="img-fluid" style="height: 200px; object-fit:cover; width: 100%">
								<div class="blog-item-content">
									<div class="post-meta mt-2 row">
										<div class="col-6">
											<b>Başlangıç :</b>
										</div>
										<div class="col-6 text-right">
											<?= explode(' ', $e['created_time'])[0]?>
										</div>
										<div class="col-6">
											<b>Bitiş :</b>
										</div>
										<div class="col-6 text-right">
											<?= explode(' ', $e['end_time'])[0]?>
										</div>
										<div class="my-3 col-12 text-right">
											<form method="post" action="backend/join_event.php">
												<input type="hidden" name="event_id" value="<?=$e['event_id']?>">
												<button class="btn btn-main-2 text-white"> Etkinliğe Katıl </button>
												<a href="event.php?id=<?=$id?>" class="btn btn-main text-white"> Bağış Yap </a>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


				<?php endforeach ?>

				

			</div>
		</div>

	</section>

</div>



<?php
include_once('inc-footer.php');
?>