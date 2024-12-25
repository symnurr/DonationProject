<?php

include_once("backend/dbconnection.php");

// ID Kontrolü
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Geçersiz ID.");
}

$id = intval($_GET['id']);

// Kayıt Silme
$query = "DELETE FROM recipient WHERE recipient_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Başarıyla silindiyse yönlendir
    header("Location: account.html");
    exit;
} else {
    // Hata varsa hata mesajı göster
    die("Kayıt silinirken bir hata oluştu.");
}
?>
