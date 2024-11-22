<?php
   include '../function.php';
   isLogin();
   url('id','trang_chu.php');
	url('application_id','trang_chu.php');
   permissionApplication($_GET['id'], $_GET['application_id']);
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
         <a href="nganh.php?id=<?php echo $_GET['id'] ?>" class="btn btn-primary">Trở lại</a>
		</div>
         <div style="margin: 20px 13%;">
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Tên</label>
               <input class="form-control" readonly type="text" name="fullName" id="" value="<?php getApplication($_GET['application_id'], "full_name") ?>">
            </div>
            <?php 
            	getSubjectsForApplication($_GET['application_id']);
             ?>
            <div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>Ảnh học bạ</label>
              	<img class="form-control" class='img-fluid' src="<?php getApplication($_GET['application_id'], "image") ?>">
            </div>
         </div>
      </form>
	</main>
   <?php include 'footer.php'; ?>
</body>
</html>