<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Age Calculator</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS for responsive design -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card mt-5 shadow">
                    <div class="card-header bg-primary text-white">
                        <h1 class="text-center">Age Calculator</h1>
                    </div>
                    <div class="card-body">
                        <?php
                        // Initialize variables
                        $day = $month = $year = "";
                        $age_years = $age_months = $age_days = "";
                        $error = "";
                        $success = false;

                        // Process form submission
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Get input values
                            $day = isset($_POST['day']) ? trim($_POST['day']) : '';
                            $month = isset($_POST['month']) ? trim($_POST['month']) : '';
                            $year = isset($_POST['year']) ? trim($_POST['year']) : '';
                            
                            // Validate input
                            if (empty($day) || empty($month) || empty($year)) {
                                $error = "Please fill in all date fields.";
                            } elseif (!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) {
                                $error = "Please enter numeric values for date fields.";
                            } elseif (!checkdate($month, $day, $year)) {
                                $error = "Please enter a valid date.";
                            } else {
                                // Create date objects
                                $birthDate = new DateTime("$year-$month-$day");
                                $currentDate = new DateTime('now');
                                
                                // Check if birth date is in the future
                                if ($birthDate > $currentDate) {
                                    $error = "Birth date cannot be in the future.";
                                } else {
                                    // Calculate age
                                    $interval = $currentDate->diff($birthDate);
                                    $age_years = $interval->y;
                                    $age_months = $interval->m;
                                    $age_days = $interval->d;
                                    $success = true;
                                }
                            }
                        }
                        ?>

                        <!-- Age Calculator Form -->
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-4">
                                <label class="form-label">Enter Your Date of Birth:</label>
                                <div class="row g-3">
                                    <div class="col">
                                        <label for="day" class="form-label">Day</label>
                                        <input type="number" class="form-control" id="day" name="day" min="1" max="31" value="<?php echo $day; ?>" placeholder="DD" required>
                                    </div>
                                    <div class="col">
                                        <label for="month" class="form-label">Month</label>
                                        <input type="number" class="form-control" id="month" name="month" min="1" max="12" value="<?php echo $month; ?>" placeholder="MM" required>
                                    </div>
                                    <div class="col">
                                        <label for="year" class="form-label">Year</label>
                                        <input type="number" class="form-control" id="year" name="year" min="1900" max="<?php echo date('Y'); ?>" value="<?php echo $year; ?>" placeholder="YYYY" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Calculate Age</button>
                            </div>
                        </form>

                        <!-- Display Results -->
                        <?php if ($error): ?>
                            <div class="alert alert-danger mt-4">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($success): ?>
                            <div class="result-container mt-4">
                                <h2 class="text-center mb-4">Your Age is</h2>
                                <div class="row text-center">
                                    <div class="col">
                                        <div class="age-box">
                                            <span class="age-number"><?php echo $age_years; ?></span>
                                            <span class="age-label">Years</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="age-box">
                                            <span class="age-number"><?php echo $age_months; ?></span>
                                            <span class="age-label">Months</span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="age-box">
                                            <span class="age-number"><?php echo $age_days; ?></span>
                                            <span class="age-label">Days</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <p class="birth-date-info">
                                        You were born on <strong><?php echo date("F j, Y", strtotime("$year-$month-$day")); ?></strong>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>