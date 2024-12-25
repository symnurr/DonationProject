<?php
include_once("dbconnection.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Alınan verileri temizle
    $event_name = htmlspecialchars($_POST['event_name']);
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $end_time = $_POST['end_time'];
    $recipient_id = $_SESSION["user_id"]; // Örnek olarak, recipient_id'yi 1 alıyoruz. Dinamik hale getirebilirsiniz.
    
    // Resmi yükle
    $image_name = rand(100000000, 999999999)  . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_path = "../uploads/" . basename($image_name);

    
    // Resim dosyasını yükle
    if (move_uploaded_file($image_tmp_name, $image_path)) {
        
        // Veritabanına etkinlik ekle
        $stmt = $db->prepare("INSERT INTO events (recipient_id, event_name, image, location, description, end_time) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('isssss', $recipient_id, $event_name, $image_name, $location, $description, $end_time);
        
        if ($stmt->execute()) {
            header("Location: ../recipient.php?status=success");
            exit();
        } else {
            echo "Etkinlik oluşturulurken bir hata oluştu.";
        }
    } else {
        echo "Resim yüklenirken bir hata oluştu.";
    }
}
?>
