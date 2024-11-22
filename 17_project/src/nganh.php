<?php
    include '../function.php';
    isLogin();
    url('id','trang_chu.php');
    permissionMajor($_GET['id']);
    checkAplication($_GET['id']);
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
    <style>
        img{
            max-width: 400px;
        }
        a{
            text-decoration: none;
            color: white;
        }

    </style>
</head>
<body>
    <?php include 'navbar.php';?>
	<main style="min-height: 100vh; max-width: 100%;">
      <div id="action" style="margin: 20px 0 0 13%;">
         <p class="h3" style="text-transform: capitalize;">Ngành <?php nameMajor($_GET['id']) ?></p>
         <a href="trang_chu.php" class="btn btn-primary">Trở lại</a>
      </div>
      <div class="d-flex flex-wrap flex-column align-items-center" style="padding: 1%;margin: 5% 0 0 0; ">
         <p class="h3">Hồ sơ</p>
         <table  class="table table-striped">
            <tr>
               <th>STT</th>
               <th>Tài khoản</th>
               <th>Họ tên</th>
               <th>Tên ngành</th>
               <th>Khối xét tuyển</th>
               <th>Trạng thái</th>
               <th>Người duyệt</th>
               <th>Thao tác</th> 
            </tr>
            <?php 
                getAllAplicationsWithMajor($_GET['id']);
            ?>
         </table>     
      </div>
	</main>
    <?php include 'footer.php'; ?>
</body>

	
</html>