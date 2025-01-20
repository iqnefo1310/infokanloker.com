<?php
session_start();
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Fetch all job listings
$query = $conn->prepare("
    SELECT jobs.id, jobs.title, companies.company_name, jobs.location, jobs.salary, jobs.description
    FROM jobs
    JOIN companies ON jobs.company_id = companies.id
");
$query->execute();
$result = $query->get_result();
$query->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Job Listings</h2>
        <div class="row">
            <?php while ($job = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($job['title']); ?></h5>
                            <p class="card-text"><strong>Company:</strong> <?php echo htmlspecialchars($job['company_name']); ?></p>
                            <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                            <p class="card-text"><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobModal<?php echo $job['id']; ?>">Details</button>
                        </div>
                    </div>
                </div>

                <!-- Modal for Details -->
                <div class="modal fade" id="jobModal<?php echo $job['id']; ?>" tabindex="-1" aria-labelledby="jobModalLabel<?php echo $job['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="jobModalLabel<?php echo $job['id']; ?>"><?php echo htmlspecialchars($job['title']); ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6><strong>Company:</strong> <?php echo htmlspecialchars($job['company_name']); ?></h6>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                                <p><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?></p>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <a href="apply.php?job_id=<?php echo $job['id']; ?>" class="btn btn-success">Apply</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
