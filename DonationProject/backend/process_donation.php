<?php

include_once("dbconnection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Parametreleri al
    $donor_name = $_POST['donor_name'];
    $donor_email = $_POST['donor_email'];
    $donation_amount = $_POST['donation_amount'];
    $donor_note = $_POST['donor_note'];
    $event_id = $_POST['event_id']; // Eğer event_id POST ile geliyor




    // Bağışçıyı kontrol et (e-posta ile)
    $stmt = $db->prepare('SELECT donor_id FROM donor WHERE email = ?');
    $stmt->bind_param('s', $donor_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Eğer bağışçı varsa, donor_id'yi al
    if ($result->num_rows > 0) 
    {
        $row = $result->fetch_assoc();
        $donor_id = $row['donor_id'];
    } else {
        // Eğer bağışçı yoksa, yeni bir kullanıcı oluştur
        $stmt = $db->prepare('INSERT INTO donor (first_name, email) VALUES (?, ?)');
        $stmt->bind_param('ss', $donor_name, $donor_email);
        $stmt->execute();
        $donor_id = $stmt->insert_id; // Yeni oluşturulan donor_id
    }

    $sql = "INSERT INTO donor_event (donor_id, event_id) VALUES ('$donor_id', '$event_id')";

    $result = $db->query($sql);


    // Bağış işlemini ekle
    $stmt = $db->prepare('INSERT INTO donation (donor_id, event_id, amount, note, donation_date) VALUES (?, ?, ?, ?, NOW())');
    $stmt->bind_param('iiis', $donor_id, $event_id, $donation_amount, $donor_note);
    $stmt->execute();

    // Başarıyla eklenip eklenmediğini kontrol et
    if ($stmt->affected_rows > 0) {
        header("Location: ../donor_profile.php?id=" . $donor_id);
    } else {
        header("Location: ../index.php");
    }
}
?>
