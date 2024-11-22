<?php
   include '../function.php';
   isLogin();
   permissionAdmin();
   url('id','trang_chu.php');
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tuyển sinh</title>
	<!-- Begin bootstrap cdn -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="	sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- End bootstrap cdn -->

</head>
<body>
    <?php include 'navbar.php';?>
	<main style="min-height: 100vh; max-width: 100%;">
		<div id="action" style="margin: 20px 0 0 13%;">
			<p class="h3" style="text-transform: capitalize;">Ngành <?php nameMajor($_GET['id']) ?></p>
         <a href="giao_vien.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary">Trở lại</a>
		</div>
		<form method="POST">
         <div style="margin: 20px 13%;">
            <?php 
            	showTeachers($_GET['id']);
             ?>

            <?php 
            	if (isset($_POST['btn'])) {
                  if ($_POST['gv'] == "") {
                     echo "Vui lòng chọn giáo viên<br>";
                  }else{
                  	if (addTeacherForMajor($_GET['id'], $_POST['gv'])) {
                  		header("location: giao_vien.php?id=".$_GET['id']);
                  	}else{
                  		echo "<div class='alert alert-warning text-center' role='alert'>Thêm giáo viên thất bại</div>";
                  	}
                  }
            	}
             ?>

            <div style="margin: 20px 0 0 0;" class="d-grid">
               <input class="btn btn-primary btn-block" name="btn" type="submit" value="Thêm">
            </div>
         </div>
      </form>
	</main>
   <?php include 'footer.php'; ?>
</body>
</html>