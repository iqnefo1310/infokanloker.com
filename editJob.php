<?php
session_start();

if (!isset($_SESSION['company_id'])) {
    header('Location: commpanyLogin.php');
    exit;
}

require_once 'config.php';

$company_id = $_SESSION['company_id'];

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];

    // Ambil data pekerjaan yang ingin diedit
    $query = "SELECT * FROM jobs WHERE id = ? AND company_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $job_id, $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        header('Location: commpanyDash.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $category_id = $_POST['category_id'];
        $location = $_POST['location'];
        $salary = $_POST['salary'];
        $description = $_POST['description'];

        if (empty($title) || empty($category_id) || empty($location) || empty($salary) || empty($description)) {
            $error_message = "Semua field harus diisi!";
        } else {
            $stmt = $conn->prepare("UPDATE jobs SET title = ?, category_id = ?, location = ?, salary = ?, description = ? WHERE id = ? AND company_id = ?");
            $stmt->bind_param("siissii", $title, $category_id, $location, $salary, $description, $job_id, $company_id);

            if ($stmt->execute()) {
                $success_message = "Pekerjaan berhasil diperbarui!";
            } else {
                $error_message = "Terjadi kesalahan saat memperbarui pekerjaan.";
            }
        }
    }
} else {
    header('Location: commpanyDash.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pekerjaan</title>
    <link rel="stylesheet" href="css/comdash.css">
</head>
<body>
    <div class="container">
        <h2>Edit Pekerjaan</h2>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $job['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <?php
                    $category_result = $conn->query("SELECT * FROM job_categories");
                    while ($row = $category_result->fetch_assoc()) {
                        echo "<option value='" . $row['id'] . "' " . ($job['category_id'] == $row['id'] ? 'selected' : '') . ">" . $row['NAME'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="<?php echo $job['location']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="number" name="salary" id="salary" class="form-control" value="<?php echo $job['salary']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required><?php echo $job['description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Pekerjaan</button>
        </form>
    </div>
</body>
</html>
