<?php
session_start();

if (!isset($_SESSION['company_id'])) {
    header('Location: companyLogin.php');
    exit;
}

require_once 'config.php';

$company_id = $_SESSION['company_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $location = $_POST['location'];
    $salary = $_POST['salary'];
    $description = $_POST['description'];

    if (empty($title) || empty($category_id) || empty($location) || empty($salary) || empty($description)) {
        $error_message = "Semua field harus diisi!";
    } else {
        $stmt = $conn->prepare("INSERT INTO jobs (company_id, category_id, title, description, location, salary) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssd", $company_id, $category_id, $title, $description, $location, $salary);

        if ($stmt->execute()) {
            $success_message = "Pekerjaan berhasil ditambahkan!";
        } else {
            $error_message = "Terjadi kesalahan saat menambahkan pekerjaan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pekerjaan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7fa; padding: 20px;">

    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px;">
        <h2 style="text-align: center; color: #333;">Tambah Pekerjaan</h2>

        <?php if (!empty($error_message)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px;"><?= $error_message ?></div>
        <?php endif; ?>

        <?php if (!empty($success_message)): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;"><?= $success_message ?></div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label for="title" style="font-weight: bold; color: #333;">Title</label>
                <input type="text" name="title" id="title" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="category_id" style="font-weight: bold; color: #333;">Category</label>
                <select name="category_id" id="category_id" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;" required>
                    <?php
                    $category_result = $conn->query("SELECT * FROM job_categories");
                    if ($category_result->num_rows > 0) {
                        while ($row = $category_result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['NAME'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No categories available</option>";
                    }
                    ?>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="location" style="font-weight: bold; color: #333;">Location</label>
                <input type="text" name="location" id="location" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="salary" style="font-weight: bold; color: #333;">Salary</label>
                <input type="number" name="salary" id="salary" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label for="description" style="font-weight: bold; color: #333;">Description</label>
                <textarea name="description" id="description" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px; border-radius: 5px; border: 1px solid #ccc;" required></textarea>
            </div>
            <button type="submit" style="background-color: #007bff; color: #fff; padding: 10px 20px; border-radius: 5px; border: none; width: 100%; font-size: 16px;">Tambah Pekerjaan</button>
        </form>
    </div>

</body>
</html>
