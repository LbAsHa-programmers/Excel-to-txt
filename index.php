<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How to Import Excel Data into database in PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container">
 <div class="row">
 <div class="col-md-12 mt-4">

<div class="card mt-5">
<div class="card-header">
    <h4>Export Data to txt</h4>
</div>
<div class="card-body">

    <form action="code.php" method="POST">

        <button type="submit" name="export_excel_btn" class="btn btn-primary mt-3">Export</button>

    </form>

</div>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>