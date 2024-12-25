<?php

include_once('inc-header.php');
include_once('inc-navbar.php');
include_once('assets/erolib/main.html');


// $id Değerini Kontrol Et
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Geçersiz ID.");
}

$id = intval($_GET['id']);

// Veriyi Çek
$query = "SELECT * FROM recipient WHERE recipient_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$recipient = $result->fetch_assoc();

if (!$recipient) {
    die("Kayıt bulunamadı.");
}

// POST İşlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $institution_name = $_POST['institution_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $address = $_POST['address'] ?? '';
    $activity = $_POST['activity'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $founding_date = $_POST['founding_date'] ?? '';

    // Güncelleme Sorgusu
    $updateQuery = "UPDATE recipient SET institution_name = ?, email = ?, phone = ?, password = ?, address = ?, activity = ?, purpose = ?, founding_date = ? WHERE recipient_id = ?";
    $updateStmt = $db->prepare($updateQuery);
    $updateStmt->bind_param("ssssssssi", $institution_name, $email, $phone, $password, $address, $activity, $purpose, $founding_date, $id);
    $updateStmt->execute();

    // Güncellenmiş veriyi yeniden çek
    $stmt->execute();
    $result = $stmt->get_result();
    $recipient = $result->fetch_assoc();
}
?>


<div class="container border p-4 mb-5" style="margin-top: 150px">
    <h2 class="mb-4">Kurum Profilinizi Düzenleyin.</h2>
    <form method="post">
        <div class="row">
            <div class="mb-3 col-6">
                <label for="institution_name" class="form-label">Kurum Adı</label>
                <input type="text" class="form-control" id="institution_name" name="institution_name" value="<?= htmlspecialchars($recipient['institution_name']) ?>" required>
            </div>
            <div class="mb-3 col-6">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($recipient['email']) ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col-6">
                <label for="phone" class="form-label">Telefon</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($recipient['phone']) ?>" required>
            </div>
            <div class="mb-3 col-6">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" class="form-control" id="password" name="password" value="<?= htmlspecialchars($recipient['password']) ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Adres</label>
            <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($recipient['address']) ?></textarea>
        </div>
        <div class="row">
            <div class="mb-3 col-6">
                <label for="activity" class="form-label">Faaliyet</label>
                <input type="text" class="form-control" id="activity" name="activity" value="<?= htmlspecialchars($recipient['activity']) ?>">
            </div>
            <div class="mb-3 col-6">
                <label for="purpose" class="form-label">Amaç</label>
                <input type="text" class="form-control" id="purpose" name="purpose" value="<?= htmlspecialchars($recipient['purpose']) ?>">
            </div>
        </div>
        <div class="mb-3">
            <label for="founding_date" class="form-label">Kuruluş Tarihi</label>
            <input type="date" class="form-control" id="founding_date" name="founding_date" value="<?= htmlspecialchars($recipient['founding_date']) ?>">
        </div>
        <button type="submit" class="btn btn-primary text-right">Güncelle</button>
    </form>
</div>







<?php
include_once('inc-footer.php');
?>