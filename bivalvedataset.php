<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./assets/img/icon_webchanon.png" rel="icon">

    <link href="./assets/img/icon_webchanon.png" rel="apple-touch-icon">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center pt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header ">
                        <h2 class="card-title text-center p-3">Register for get Data </h2>
                    </div>
                    <div class="card-body mt-5">
                        <form action="send_data.php" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="university" class="form-label">University</label>
                                <input type="text" name="university" class="form-control" required>
                            </div>

                            <button type="submit" style="font-size:1.5rem" class="btn btn-success w-100 mt-5">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>