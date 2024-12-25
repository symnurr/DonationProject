<?php
include_once('inc-header.php');
include_once('inc-navbar.php');
?>

<div>


	<section class="banner">
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-md-8 col-lg-5">
					<div class="banner-content">
						<span style="color: #ff6984;">Çevrim İçi Bağış Platformu</span>
						<h1>Bağış Yapmak İstiyorum!</h1>
						<p>"Bağış yapıp destek olmak istiyorum ama güvenilir bir yer bulamıyorum." mu diyorsun? E gel ne bekliyosun!</p>
						<a href="events.php" class="btn btn-main-2">Bağış Yap <i class="fa fa-angle-right ml-2"></i></a>
					</div>
				</div>
				<div class="col-lg-7 col-md-12">
					<div class="banner-img mt-5 mt-lg-0">
						<img src="assets/our/img/donate.webp" alt="" class="img-fluid w-100" style="height: 400px; object-fit: contain;">
					</div>
				</div>
			</div> <!-- / .row -->
		</div> <!-- / .container -->
	</section>



	<section class="feature">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-sm-6 col-md-6">
					<div class="feature-item">
						<i class="ti-heart c1"></i>
						<h4>Toplumsal <br>Dayanışmayı Güçlendirin</h4>
						<a href="#" class="">Detayları Gör</a>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-6">
					<div class="feature-item">
						<i class="ti-gift c2"></i>
						<h4>İhtiyaç <br>Sahiplerine Destek Olun</h4>
						<a href="#" class="">Detayları Gör</a>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-6">
					<div class="feature-item">
						<i class="ti-hand-open c3"></i>
						<h4>Sosyal <br>Sorumluluk Sahibi Olun</h4>
						<a href="#" class="">Detayları Gör</a>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-6">
					<div class="feature-item">
						<i class="ti-world c4"></i>
						<h4>Daha İyi <br>Bir Gelecek İçin Katkı</h4>
						<a href="#" class="">Detayları Gör</a>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="counter">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6">
					<div class="heading text-center">
						<span class="text-color">Bağış Etkinliklerimiz</span>
						<h2>10,000+ kişiye yardım eli uzattık</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-item mb-5 mb-lg-0">
						<i class="ti-hand-open"></i>
						<div class="counter-stat">
							<span class="count h2">15</span><span>K</span>
						</div>
						<p>Desteklenen Kişi</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-item mb-5 mb-lg-0">
						<i class="ti-gift"></i>
						<div class="counter-stat">
							<span class="count h2">1,200</span><span>+</span>
						</div>
						<p>Toplanan Bağış</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-item mb-5 mb-lg-0">
						<i class="ti-heart"></i>
						<div class="counter-stat">
							<span class="count h2">600</span><span>%</span>
						</div>
						<p>Toplumsal Etki</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="counter-item mb-5 mb-lg-0">
						<i class="ti-flag"></i>
						<div class="counter-stat">
							<span class="count h2">50</span><span>+</span>
						</div>
						<p>Şehirde Faaliyet</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	// LEFT JOIN ile etkinliklere bağış toplamlarını dahil et
	$stmt = $db->query('
	    SELECT e.*, 
       		COALESCE(SUM(d.amount), 0) AS total_amount
		FROM events e
		LEFT JOIN donation d ON e.event_id = d.event_id
		GROUP BY e.event_id
		ORDER BY total_amount DESC
		LIMIT 3;

	');
	$events = $stmt->fetch_all(MYSQLI_ASSOC);
	?>

	<section class="section pricing">
	    <div class="container">
	        <div class="row justify-content-center">
	            <div class="col-lg-6">
	                <div class="heading text-center">
	                    <span class="text-color">Etkinlikler ve Bağışlar</span>
	                    <h2 class="mb-3">Şimdiye kadar yapılan bağışların detayları</h2>
	                </div>
	            </div>
	        </div>
	        <div class="row">
	            <?php foreach ($events as $e): ?>
	                <div class="col-lg-4 col-md-6">
	                    <div class="pricing-item mb-4 mb-lg-0">
	                        <div class="price-header">
	                            <span class="h4"><?= htmlspecialchars($e['event_name']) ?></span>
	                            <img src="uploads/<?= htmlspecialchars($e['image']) ?>" alt="" class="img-fluid w-100" style="height: 150px; object-fit: cover;">
	                            <h4 style="font-size: 40px; color: #172182;"><?= number_format($e['total_amount'], 2) ?> ₺</h4>
	                        </div>
	                        <div class="price-features">
	                            <ul class="list-unstyled">
	                                <li><i class="ti-calendar"></i> Başlangıç: <?= explode(' ', $e['created_time'])[0] ?></li>
	                                <li><i class="ti-calendar"></i> Bitiş: <?= explode(' ', $e['end_time'])[0] ?></li>
	                                <li class="mt-3" style="height: 100px;"> <?= htmlspecialchars(mb_strimwidth($e['description'], 0, 150, '...')) ?></li>
	                            </ul>
	                        </div>
	                        <a href="event.php?id=<?= $e['event_id'] ?>" class="btn btn-main-2">Etkinliğe Git</a>
	                    </div>
	                </div>
	            <?php endforeach; ?>
	        </div>
	    </div>
	</section>

</div>



<?php
include_once('inc-footer.php');
?>