<html>
<head>
<title>Simple CSV to PDF Datasheet generator</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
      <h5 class="my-0 mr-md-auto font-weight-normal">Generate PDF Technical Datasheet using CSV</h5>
</div>

<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
          <h1 class="jumbotron-heading">Upload CSV</h1>
          <p class="lead text-muted">Upload CSV to start generate PDF. <br>
            To make CSV please use this template. Donwload <a href="Example.csv"> here.</a>
        </p>
          <p>
          <form action="generate-pdf.php" method="post" enctype="multipart/form-data">
            <div>
                <input class="form-control form-control-lg" name="csv_file" type="file" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary my-2">Upload and generate</button>
            </form>
        </p>
        <img src="Example-1.jpg" class="img-fluid border border-dark" width="500px" alt="Example-1">
        <img src="Example-2.jpg" class="img-fluid border border-dark" width="500px" alt="Example-2">
        <br><br>
    </div>
</section>
</main>


</body>
</html>