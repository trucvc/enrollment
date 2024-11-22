<?php 
	session_start();
	include 'connectdb.php';
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	function isLoginIndex(){
		if (isset($_SESSION['username'])) {
			header("location:src/trang_chu.php");
		}else{
			header("location:src/dang_nhap.php");
		}
	}

	function isLogin(){
		checkEndDateAllMajor();
		if (!isset($_SESSION['username'])) {
			header("location:dang_nhap.php");
		}
	}

	function permissionAdmin(){
		if ($_SESSION['role'] != "admin") {
			header("location:trang_chu.php");
			exit();
		}
	}

	function permissionStudent(){
		if ($_SESSION['role'] != "student") {
			header("location:trang_chu.php");
			exit();
		}
	}

	function permission(){
		if ($_SESSION['role'] == "student") {
			header("location:trang_chu.php");
			exit();
		}
	}

	function url($name, $link){
		if (!isset($_GET["$name"]) || trim($_GET["$name"]) == "") {
			header("location:$link");
		}
	}

	function val($submit, $value)
	{
		if (isset($_POST["$submit"]) && trim($_POST["$value"]) != "") {
			echo $_POST["$value"];
		}
	}

	function selectedVal($name, $value){
		if (isset($_POST["$name"]) && $_POST["$name"] == "$value") {
			echo "selected";
		}
	}

	function selectedValMajor($v, $value){
		if ($v == $value) {
			echo "selected";
		}
	}

	function login($username, $password){
		global $conn;
		$query = "SELECT * FROM `users`";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					if ($row['username'] == $username && $row['password'] == md5($password)) {
						$_SESSION['id'] = $row['user_id'];
						$_SESSION['username'] = $username;
						$_SESSION['role'] = $row['role'];
						return true;
					}
				}
				return false;
			}
		}
	}

	function logout(){
		if (isset($_SESSION['id'])) {
			unset($_SESSION['id']);
		}
		if (isset($_SESSION['username'])) {
			unset($_SESSION['username']);
		}
		if (isset($_SESSION['role'])) {
			unset($_SESSION['role']);
		}
		header("location:dang_nhap.php");
	}

	function register($username, $password){
		global $conn;
		$query = "SELECT * FROM `users` WHERE `username` = '$username'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				echo "<div class='alert alert-danger text-center' role='alert'>Đã tồi tại tài khoản này!</div>";
			}else{
				$role = "student";
				$query = "INSERT INTO `users` (`username`, `password`, `role`) VALUES ('$username', '$password', '$role')";
				if (mysqli_query($conn, $query)) {
					header("location: dang_nhap.php");
				}else{
					echo "<div class='alert alert-danger text-center' role='alert'>Đăng kí thất bại!</div>";
				}
			}
		}
	}

	function changePassword($old, $new){
		global $conn;
		$id = $_SESSION['id'];
		$query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				if ($row['password'] == md5($old)) {
					if ($old == $new) {
						echo "<div class='alert alert-danger text-center' role='alert'>Mật khẩu cũ và mật khẩu mới phải khác nhau!</div>";
					}else{
						$new = md5($new);
						$query = "UPDATE `users` SET `password`='$new' WHERE `user_id`='$id'";
						if (mysqli_query($conn, $query)) {
							header("location: trang_chu.php");
						}else{
							echo "<div class='alert alert-danger text-center' role='alert'>Đổi mật khẩu thất bại!</div>";
						}
					}
				}else{
					echo "<div class='alert alert-danger text-center' role='alert'>Mật khẩu cũ không chính xác!</div>";
				}
			}
		}
	}

	function checkEndDateAllMajor(){
		global $conn;
		$query = "SELECT * FROM `majors`";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					if ($row['is_active']) {
						$current_date = date("Y-m-d");
						if ($current_date >= $row['end_date']) {
							deactivateMajor($row['major_id']);
						}
					}
				}
			}
		}
	}

	function permissionMajor($major_id){
		global $conn;
		if ($_SESSION['role'] != "admin") {
			$query = "SELECT * FROM `majors` WHERE `major_id`='$major_id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$row = mysqli_fetch_array($do);
					if ($row['is_active']) {

					}else{
						header("location:trang_chu.php");
					}
				}
			}
			if ($_SESSION['role'] == "teacher") {
				$id = $_SESSION['id'];
				$query = "SELECT * FROM `teacher_major` WHERE `teacher_id` = '$id' AND `major_id`='$major_id'";
				if ($do = mysqli_query($conn, $query)) {
					if (mysqli_num_rows($do) > 0) {

					}else{
						header("location:trang_chu.php");
					}
				}
			}
		}
	}

	function permissionSendApplication($major_id){
		global $conn;
		$query = "SELECT * FROM `majors` WHERE `major_id`='$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				if ($row['is_active']) {

				}else{
					header("location:trang_chu.php");
				}
			}
		}
	}

	function permissionApplication($major_id, $application_id){
		global $conn;
		if ($_SESSION['role'] != "admin") {
			$query = "SELECT * FROM `majors` WHERE `major_id`='$major_id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$row = mysqli_fetch_array($do);
					if ($row['is_active']) {

					}else{
						header("location:trang_chu.php");
					}
				}
			}
			$id = $_SESSION['id'];
			if ($_SESSION['role'] == "teacher") {
				$query = "SELECT * FROM `teacher_major` WHERE `teacher_id` = '$id' AND `major_id`='$major_id'";
				if ($do = mysqli_query($conn, $query)) {
					if (mysqli_num_rows($do) > 0) {

					}else{
						header("location:trang_chu.php");
					}
				}
			}else{
				$query = "SELECT * FROM `applications` WHERE `user_id` = '$id' AND `application_id`='$application_id'";
				if ($do = mysqli_query($conn, $query)) {
					if (mysqli_num_rows($do) > 0) {

					}else{
						header("location:trang_chu.php");
					}
				}
			}
		}
	}

	function deactivateMajor($major_id){
		global $conn;
		$query = "UPDATE `majors` SET `is_active`='0' WHERE `major_id`='$major_id'";
		mysqli_query($conn, $query);
	}

	function getAllMajor(){
		global $conn;
		if ($_SESSION['role'] == "teacher") {
			$id = $_SESSION['id'];
			$query = "SELECT * 
			FROM 
				teacher_major 
			JOIN 
				majors ON majors.major_id = teacher_major.major_id 
			JOIN 
				subject_groups ON majors.group_id = subject_groups.group_id
			WHERE `teacher_id` = '$id'
			ORDER BY `end_date` DESC";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$count = 1;
					echo 
					"<tr>
	               <th>STT</th>
	               <th>Tên ngành</th>
	               <th>Khối xét tuyển</th>
	               <th>Thời gian bắt đầu</th>
	               <th>Thời gian kết thúc</th>
	               <th>Thao tác</th> 
               </tr>";
					while ($row = mysqli_fetch_array($do)) {
						if ($row['is_active']) {
							echo "<tr>";
							echo "<td>".$count."</td>";
							echo "<td style='text-transform: capitalize;'>".$row['major_name']."</td>";
							echo "<td>".$row['group_name']."</td>";
							echo "<td>".$row['start_date']."</td>";
							echo "<td>".$row['end_date']."</td>";
							echo '<td><a href="nganh.php?id='.$row['major_id'].'" class="btn btn-primary">Nộp hồ sơ</a></td>';
							$count++;
							echo "</tr>";
						}
					}
				}else{
					echo 'Không có ngành nào!';
				}
			}
		}else{
			$query = "SELECT majors.*, subject_groups.* FROM majors JOIN subject_groups ON majors.group_id = subject_groups.group_id
			ORDER BY `end_date` DESC";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$count = 1;
					echo 
					"<tr>
	               <th>STT</th>
	               <th>Tên ngành</th>
	               <th>Khối xét tuyển</th>
	               <th>Thời gian bắt đầu</th>
	               <th>Thời gian kết thúc</th>";
	            if ($_SESSION['role'] == "admin") {
	            	echo "<th>Trạng thái</th>";
	            }
	            echo" 
	               <th>Thao tác</th> 
               </tr>";
					while ($row = mysqli_fetch_array($do)) {
						if ($_SESSION['role'] == "admin") {
                		echo "<tr>";
							echo "<td>".$count."</td>";
							echo "<td style='text-transform: capitalize;'>".$row['major_name']."</td>";
							echo "<td>".$row['group_name']."</td>";
							echo "<td>".$row['start_date']."</td>";
							echo "<td>".$row['end_date']."</td>";
							if ($row['is_active']) {
								echo '<td>Hiện</td>';
							}else{
								echo '<td>Ẩn</td>';
							}
							echo '<td>';
							if ($row['is_active']) {
								echo '<a href="an_nganh.php?id='.$row['major_id'].'" class="btn btn-warning">Ẩn ngành</a>';
							}else{
								echo '<a href="hien_nganh.php?id='.$row['major_id'].'" class="btn btn-success">Hiện ngành</a>';
							}
							echo'
							<a href="nganh.php?id='.$row['major_id'].'" class="btn btn-primary">Nộp hồ sơ</a>
							<a href="giao_vien.php?id='.$row['major_id'].'" class="btn btn-info">Giáo viên</a>
							<a href="sua_nganh.php?id='.$row['major_id'].'" class="btn btn-success">Sửa</a>
							<a href="xoa_nganh.php?id='.$row['major_id'].'" class="btn btn-danger">Xóa</a>
							</td>';
							echo "</tr>";
							$count++;
						}else{
                		if ($row['is_active']) {
                			echo "<tr>";
								echo "<td>".$count."</td>";
								echo "<td style='text-transform: capitalize;'>".$row['major_name']."</td>";
								echo "<td>".$row['group_name']."</td>";
								echo "<td>".$row['start_date']."</td>";
								echo "<td>".$row['end_date']."</td>";
								echo '<td><a href="nganh.php?id='.$row['major_id'].'" class="btn btn-primary">Nộp hồ sơ</a></td>';
								echo "</tr>";
								$count++;
							}
						}
					}
				}else{
					echo 'Không có ngành nào!';
				}
			}
		}
	}

	function nameMajor($id){
		global $conn;
		$query = "SELECT * FROM `majors` WHERE `major_id` = '$id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				echo $row['major_name'];
			}
		}
	}

	function updateActiveMajor(){
		$query = "";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					
				}
			}else{
				echo 'Không có ngành này!';
			}
		}
	}

	function hiddenMajor($id){
		global $conn;
		$query = "UPDATE `majors` SET `is_active`='0' WHERE `major_id` = '$id'";
		mysqli_query($conn, $query);
	}

	function showMajor($id){
		global $conn;
		$query = "UPDATE `majors` SET `is_active`='1' WHERE `major_id` = '$id'";
		mysqli_query($conn, $query);
	}

	function checkAplication($major_id){
		global $conn;
		if ($_SESSION['role'] == "student") {
			$user_id = $_SESSION['id'];
			$query = "SELECT * FROM `applications` WHERE `major_id` = '$major_id' AND `user_id` = '$user_id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {

				}else{
					header("location: nop_don.php?id=".$major_id);
				}
			}
		}
	}

	function checkSendAplication($major_id){
		global $conn;
		if ($_SESSION['role'] == "student") {
			$user_id = $_SESSION['id'];
			$query = "SELECT * FROM `applications` WHERE `major_id` = '$major_id' AND `user_id` = '$user_id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					header("location: nganh.php?id=".$major_id);
				}
			}
		}
	}

	function showSubjects($major_id){
		global $conn;
		$query = "SELECT majors.*, subject_groups.* FROM majors JOIN subject_groups ON majors.group_id = subject_groups.group_id WHERE `major_id` = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				echo 
				'<div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>'.$row['subject_1'].'</label>
               <input class="form-control" type="number" step="0.1" min="0" max="10" name="subject_1" id="" value="'; 
            val('btn','subject_1');
            echo '">
            </div>';
            echo 
				'<div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>'.$row['subject_2'].'</label>
               <input class="form-control" type="number" step="0.1" min="0" max="10" name="subject_2" id="" value="'; 
            val('btn','subject_2');
            echo '">
            </div>';
            echo 
				'<div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>'.$row['subject_3'].'</label>
               <input class="form-control" type="number" step="0.1" min="0" max="10" name="subject_3" id="" value="';
            val('btn','subject_3');
            echo '">
            </div>';
			}
		}
	}

	function addAplication($major_id, $full_name, $subject_1_score, $subject_2_score, $subject_3_score, $image){
		global $conn;
		$user_id = $_SESSION['id'];
		$query = "INSERT INTO `applications`(`user_id`, `major_id`, `full_name`, `subject_1_score`, `subject_2_score`, `subject_3_score`, `image`) VALUES ('$user_id','$major_id','$full_name','$subject_1_score','$subject_2_score','$subject_3_score','$image')";
		if(mysqli_query($conn, $query)){
			return true;
		}else{
			return false;
		}
	}

	function getAllAplicationsWithMajor($major_id){
		global $conn;
		$query = "SELECT u1.username AS applicant_username, u2.username AS approved_by_username, m.*, sg.*, a.* 
		FROM 
		   applications a
		JOIN 
		   users u1 ON a.user_id = u1.user_id 
		LEFT JOIN 
			users u2 ON a.approved_by = u2.user_id
		JOIN 
		   majors m ON a.major_id = m.major_id
		JOIN 
		   subject_groups sg ON m.group_id = sg.group_id
    	WHERE m.major_id = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$count = 1;
				while ($row = mysqli_fetch_array($do)) {
					if ($_SESSION['role'] == "admin") {
						echo "<tr>";
						echo "<td>".$count."</td>";
						echo "<td>".$row['applicant_username']."</td>";
						echo "<td>".$row['full_name']."</td>";
						echo "<td style='text-transform: capitalize;'>".$row['major_name']."</td>";
						echo "<td>".$row['group_name']."</td>";
						echo "<td>".$row['status']."</td>";
						echo "<td>".$row['approved_by_username']."</td>";
						echo 
						'<td>
						<a href="ho_so.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-primary">Chi tiết</a>';
						if ($row['status'] == "chưa duyệt") {
							echo '
							<a href="duyet.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-success">Duyệt</a>
							<a href="tu_choi.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-warning">Từ chối</a>';
						}
						echo'
						<a href="xoa.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-danger">Xóa</a>
						</td>';
						echo "</tr>";
					}else if ($_SESSION['role'] == "teacher") {
						echo "<tr>";
						echo "<td>".$count."</td>";
						echo "<td>".$row['applicant_username']."</td>";
						echo "<td>".$row['full_name']."</td>";
						echo "<td style='text-transform: capitalize;'>".$row['major_name']."</td>";
						echo "<td>".$row['group_name']."</td>";
						echo "<td>".$row['status']."</td>";
						echo "<td>".$row['approved_by_username']."</td>";
						echo 
						'<td>
						<a href="ho_so.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-primary">Chi tiết</a>';
						if ($row['status'] == "chưa duyệt") {
							echo '
							<a href="duyet.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-success">Duyệt</a>
							<a href="tu_choi.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-warning">Từ chối</a>';
						}
						echo'</td>';
						echo "</tr>";
					}else{
						if ($row['user_id'] == $_SESSION['id']) {
							echo "<tr>";
							echo "<td>".$count."</td>";
							echo "<td>".$row['applicant_username']."</td>";
							echo "<td>".$row['full_name']."</td>";
							echo "<td style='text-transform: capitalize;'>".$row['major_name']."</td>";
							echo "<td>".$row['group_name']."</td>";
							echo "<td>".$row['status']."</td>";
							echo "<td>".$row['approved_by_username']."</td>";
							echo 
							'<td>
							<a href="ho_so.php?id='.$row['major_id'].'&application_id='.$row['application_id'].'" class="btn btn-primary">Chi tiết</a>';
							echo'</td>';
							echo "</tr>";
						}
					}
					$count++;
				}
			}else{
				echo 'Không có đơn ứng tuyển nào!';
			}
		}
	}

	function getAllTeachersForMajor($major_id){
		global $conn;
		$query = "SELECT * 
			FROM 
				teacher_major
			JOIN 
				users ON users.user_id = teacher_major.teacher_id 
			WHERE `major_id` = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$count = 1;
				while ($row = mysqli_fetch_array($do)) {
					echo "<tr>";
					echo "<td>".$count."</td>";
					echo "<td>".$row['username']."</td>";
					echo '<td><a href="xoa_giao_vien.php?major_id='.$row['major_id'].'&teacher_id='.$row['teacher_id'].'" class="btn btn-danger">Xóa</a></td>';
					echo "</tr>";
				}
			}else{
				echo "<tr><td>Không có giáo viên nào!</td><tr>";
			}
		}
	}

	function showTeachers($major_id){
		global $conn;
		$query = "SELECT *
		FROM 
			users u
		LEFT JOIN 
			teacher_major tm ON u.user_id = tm.teacher_id AND tm.major_id = '$major_id'
		WHERE u.role = 'teacher' AND tm.teacher_id IS NULL";
		if ($do = mysqli_query($conn, $query)) {
			echo '<select class="form-select" name="gv">';
			echo '<option value="">Chọn giáo viên</option>';
			while ($row = mysqli_fetch_array($do)) {
				echo '<option value="'.$row['user_id'].'" ';
				selectedVal("gv", $row['user_id']);
				echo '>'.$row['username'].'</option>';
			}
			echo '</select>';
		}
	}

	function addTeacherForMajor($major_id, $teacher_id){
		global $conn;
		$query = "INSERT INTO `teacher_major`(`teacher_id`, `major_id`) VALUES ('$teacher_id','$major_id')";
		if (mysqli_query($conn, $query)) {
			return true;
		}else{
			return false;
		}
	}

	function deleteTeacherForMajor($major_id, $teacher_id){
		global $conn;
		$query = "DELETE FROM `teacher_major` WHERE `major_id` = '$major_id' AND `teacher_id` = '$teacher_id'";
		mysqli_query($conn, $query);
	}

	function showSubjectGroup(){
		global $conn;
		$query = "SELECT * FROM `subject_groups` ORDER BY `group_name`";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				echo '<select class="form-select" name="sub">';
				echo '<option value="">Chọn khối</option>';
				while ($row = mysqli_fetch_array($do)) {
					echo '<option value="'.$row['group_id'].'" ';
					selectedVal("sub", $row['group_id']);
					echo '>';
					echo $row['group_name'];
					echo '</option>';
				}
				echo '</select>';
			}
		}
	}

	function existsMajorName($name,$id){
		global $conn;
		if ($id == 0) {
			$query = "SELECT * FROM `majors` WHERE `major_name` = '$name'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					return true;
				}else{
					return false;
				}
			}
		}else{
			$query = "SELECT * FROM `majors` WHERE `major_id` = '$id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$row = mysqli_fetch_array($do);
					if ($name == $row['major_name']) {
						return false;
					}else{
						return existsMajorName($name, 0);
					}
				}
			}
		}
	}

	function getMajor($major_id, $name){
		global $conn;
		$query = "SELECT * FROM `majors` WHERE `major_id` = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					echo $row["$name"];
				}
			}
		}
	}

	function getActiveForMajor($major_id){
		global $conn;
		$query = "SELECT * FROM `majors` WHERE `major_id` = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					return $row['is_active'];
				}
			}
		}
	}

	function getSubjectGroupForMajor($major_id){
		global $conn;
		$query = "SELECT * FROM `majors` WHERE `major_id` = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					return $row['group_id'];
				}
			}
		}
	}

	function getMajorWithSubjectGroup($major_id){
		global $conn;
		$query = "SELECT * FROM `subject_groups` ORDER BY `group_name`";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				echo '<select class="form-select" name="sub">';
				echo '<option value="">Chọn khối</option>';
				while ($row = mysqli_fetch_array($do)) {
					echo '<option value="'.$row['group_id'].'" ';
					selectedValMajor(getSubjectGroupForMajor($major_id), $row['group_id']);
					echo '>';
					echo $row['group_name'];
					echo '</option>';
				}
				echo '</select>';
			}
		}
	}

	function addMajor($name, $start, $end, $sub, $active){
		global $conn;
		$query = "INSERT INTO `majors`(`major_name`, `start_date`, `end_date`, `group_id`, `is_active`) VALUES ('$name','$start','$end','$sub', $active)";
		if (mysqli_query($conn, $query)) {
			return true;
		}else{
			return false;
		}
	}

	function updateMajor($id, $name, $start, $end, $sub, $active){
		global $conn;
		$query = "UPDATE `majors` SET `major_name`='$name',`start_date`='$start',`end_date`='$end',`group_id`='$sub',`is_active`='$active' WHERE `major_id`='$id'";
		if (mysqli_query($conn, $query)) {
			return true;
		}else{
			return false;
		}
	}

	function deleteMajor($major_id){
		global $conn;
		$query = "SELECT * FROM `applications` WHERE `major_id` = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					unlink($row['image']);
				}
			}
		}
		$query = "DELETE FROM `applications` WHERE `major_id` = '$major_id'";
		mysqli_query($conn, $query);
		$query = "DELETE FROM `teacher_major` WHERE `major_id` = '$major_id'";
		mysqli_query($conn, $query);
		$query = "DELETE FROM `majors` WHERE `major_id` = '$major_id'";
		mysqli_query($conn, $query);
	}

	function getApplication($application_id, $name){
		global $conn;
		$query = "SELECT * FROM `applications` WHERE `application_id` = '$application_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					echo $row["$name"];
				}
			}
		}
	}

	function getSubjectsForApplication($application_id){
		global $conn;
		$query = "SELECT * 
		FROM 
			majors 
		JOIN 
			subject_groups ON majors.group_id = subject_groups.group_id 
		JOIN
			applications ON majors.major_id = applications.major_id
		WHERE `application_id` = '$application_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				echo 
				'<div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>'.$row['subject_1'].'</label>
               <input class="form-control" readonly type="number" name="subject_1" id="" value="'; 
            getApplication($application_id, "subject_1_score");
            echo '">
            </div>';
            echo 
				'<div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>'.$row['subject_2'].'</label>
               <input class="form-control" readonly type="number" name="subject_2" id="" value="'; 
            getApplication($application_id, "subject_2_score");
            echo '">
            </div>';
            echo 
				'<div class="form-group">
               <label for="name_quiz"><span style="color: red;">*</span>'.$row['subject_3'].'</label>
               <input class="form-control" readonly type="number" name="subject_3" id="" value="';
            getApplication($application_id, "subject_3_score");
            echo '">
            </div>';
			}
		}

	}

	function approveApplication($major_id, $application_id, $approved_by){
		global $conn;
		if ($_SESSION['role'] == "teacher") {
			$query = "SELECT * FROM `teacher_major` WHERE `teacher_id` = '$approved_by' AND `major_id`='$major_id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$query = "UPDATE `applications` SET `status`='đã duyệt',`approved_by`='$approved_by' WHERE `application_id`='$application_id'";
					mysqli_query($conn, $query);
				}else{
					header("location:trang_chu.php");
				}
			}
		}else{
			$query = "UPDATE `applications` SET `status`='đã duyệt',`approved_by`='$approved_by' WHERE `application_id`='$application_id'";
			mysqli_query($conn, $query);
		}
	}

	function rejectApplication($major_id, $application_id, $approved_by){
		global $conn;
		if ($_SESSION['role'] == "teacher") {
			$query = "SELECT * FROM `teacher_major` WHERE `teacher_id` = '$approved_by' AND `major_id`='$major_id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$query = "UPDATE `applications` SET `status`='từ chối',`approved_by`='$approved_by' WHERE `application_id`='$application_id'";
					mysqli_query($conn, $query);
				}else{
					header("location:trang_chu.php");
				}
			}
		}else{
			$query = "UPDATE `applications` SET `status`='từ chối',`approved_by`='$approved_by' WHERE `application_id`='$application_id'";
			mysqli_query($conn, $query);
		}
	}

	function deleteApplication($application_id){
		global $conn;
		$query = "SELECT * FROM `applications` WHERE `application_id`='$application_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					unlink($row['image']);
				}
			}
		}
		$query = "DELETE FROM `applications` WHERE `application_id`='$application_id'";
		mysqli_query($conn, $query);
	}	

	function statistical(){
		global $conn;
		$query = "SELECT majors.*, subject_groups.* FROM majors JOIN subject_groups ON majors.group_id = subject_groups.group_id
			ORDER BY `end_date` DESC";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$count = 1;
				echo 
				"<tr>
				    <th>STT</th>
				    <th>Tên ngành</th>
				    <th>Khối xét tuyển</th>
				    <th>Thời gian bắt đầu</th>
				    <th>Thời gian kết thúc</th>
				    <th>Chưa duyệt</th>
				    <th>Đã duyệt</th>
				    <th>Từ chối</th>
				    <th>Tổng</th>
				    <th>Thao tác</th>
		        </tr>";
				while ($row = mysqli_fetch_array($do)) {
					echo "<tr>";
						echo "<td>".$count."</td>";
						echo "<td style='text-transform: capitalize;'>".$row['major_name']."</td>";
						echo "<td>".$row['group_name']."</td>";
						echo "<td>".$row['start_date']."</td>";
						echo "<td>".$row['end_date']."</td>";
						echo '<td>'.countPendingApplications($row['major_id']).'</td>';
						echo '<td>'.countApprovedApplications($row['major_id']).'</td>';
						echo '<td>'.countRejectApplication($row['major_id']).'</td>';
						echo '<td>'.countApplications($row['major_id']).'</td>';
						echo '<td><a href="nganh.php?id='.$row['major_id'].'" class="btn btn-primary">Chi tiết</a></td>';
						$count++;
					echo "</tr>";
				}
			}
		}
		
	}

	function countApprovedApplications($major_id){
		global $conn;
		$query = "SELECT COUNT(*) AS `count` FROM `applications` WHERE `major_id` = '$major_id' AND `status` = 'đã duyệt'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				return $row['count'];
			}else{
				return 0;
			}
		}
	}

	function countRejectApplication($major_id){
		global $conn;
		$query = "SELECT COUNT(*) AS `count` FROM `applications` WHERE `major_id` = '$major_id' AND `status` = 'từ chối'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				return $row['count'];
			}else{
				return 0;
			}
		}
	}

	function countPendingApplications($major_id){
		global $conn;
		$query = "SELECT COUNT(*) AS `count` FROM `applications` WHERE `major_id` = '$major_id' AND `status` = 'chưa duyệt'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				return $row['count'];
			}else{
				return 0;
			}
		}
	}

	function countApplications($major_id){
		global $conn;
		$query = "SELECT COUNT(*) AS `count` FROM `applications` WHERE `major_id` = '$major_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				return $row['count'];
			}else{
				return 0;
			}
		}
	}	

	function getAllSubjectGroups(){
		global $conn;
		$query = "SELECT * FROM `subject_groups` ORDER BY `group_name`";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$count = 1;
				echo 
				"<tr>
	            <th>STT</th>
	            <th>Tên khối</th>
	            <th>Môn 1</th>
	            <th>Môn 2</th>
	            <th>Môn 3</th>
	            <th>Thao tác</th> 
            </tr>";
				while ($row = mysqli_fetch_array($do)) {
					echo "<tr>";
					echo '<td>'.$count.'</td>';
					echo '<td>'.$row['group_name'].'</td>';
					echo '<td>'.$row['subject_1'].'</td>';
					echo '<td>'.$row['subject_2'].'</td>';
					echo '<td>'.$row['subject_3'].'</td>';
					echo'<td>
						<a href="sua_khoi.php?id='.$row['group_id'].'" class="btn btn-success">Sửa</a>
					</td>';
					$count++;
					echo "</tr>";
				}
			}else{
				echo "<tr><td>Không có khối nào!</td><tr>";
			}
		}
	}

	function existsGroupName($name,$id){
		global $conn;
		if ($id == 0) {
			$query = "SELECT * FROM `subject_groups` WHERE `group_name` = '$name'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					return true;
				}else{
					return false;
				}
			}
		}else{
			$query = "SELECT * FROM `subject_groups` WHERE `group_id` = '$id'";
			if ($do = mysqli_query($conn, $query)) {
				if (mysqli_num_rows($do) > 0) {
					$row = mysqli_fetch_array($do);
					if ($name == $row['group_name']) {
						return false;
					}else{
						return existsGroupName($name, 0);
					}
				}
			}
		}
	}

	function addSubjectGroup($group_name, $subject_1, $subject_2, $subject_3){
		global $conn;
		$query = "INSERT INTO `subject_groups`(`group_name`, `subject_1`, `subject_2`, `subject_3`) VALUES ('$group_name','$subject_1','$subject_2','$subject_3')";
		if (mysqli_query($conn, $query)) {
			return true;
		}else{
			return false;
		}
	}

	function getSubjectGroup($group_id, $name){
		global $conn;
		$query = "SELECT * FROM `subject_groups` WHERE `group_id` = '$group_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					echo $row["$name"];
				}
			}
		}
	}

	function updateSubjectGroup($id, $group_name, $subject_1, $subject_2, $subject_3){
		global $conn;
		$query = "UPDATE `subject_groups` SET `group_name`='$group_name',`subject_1`='$subject_1',`subject_2`='$subject_2',`subject_3`='$subject_3' WHERE `group_id`='$id'";
		if (mysqli_query($conn, $query)) {
			return true;
		}else{
			return false;
		}
	}

	function getAllAccount(){
		global $conn;
		$query = "SELECT * FROM `users`";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$count = 1;
				echo 
				"<tr>
	            <th>STT</th>
	            <th>Tên tài khoản</th>
	            <th>Quyền</th>
	            <th>Ngày tạo</th>
	            <th>Thao tác</th> 
            	</tr>";
				while ($row = mysqli_fetch_array($do)) {
					echo "<tr>";
					echo '<td>'.$count.'</td>';
					echo '<td>'.$row['username'].'</td>';
					echo '<td>'.$row['role'].'</td>';
					echo '<td>'.$row['created_at'].'</td>';
					echo'<td>
						<a href="sua_tai_khoan.php?id='.$row['user_id'].'" class="btn btn-success">Sửa</a>
						<a href="xoa_tai_khoan.php?id='.$row['user_id'].'" class="btn btn-danger">Xóa</a>
					</td>';
					$count++;
					echo "</tr>";
				}
			}else{
				echo "<tr><td>Không có khối nào!</td><tr>";
			}
		}
	}

	function nameAccount($id){
		global $conn;
		$query = "SELECT * FROM `users` WHERE `user_id` = '$id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				echo $row['username'];
			}
		}
	}

	function getAccount($user_id, $name){
		global $conn;
		$query = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					echo $row["$name"];
				}
			}
		}
	}

	function getRoleAccount($user_id, $name){
		global $conn;
		$query = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					return $row["$name"];
				}
			}
		}
	}

	function existsUserName($name){
		global $conn;
		$query = "SELECT * FROM `users` WHERE `username` = '$name'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				return true;
			}else{
				return false;
			}
		}
	}

	function addAccount($name, $password, $role){
		global $conn;
		$query = "INSERT INTO `users`(`username`, `password`, `role`) VALUES ('$name','$password','$role')";
		if(mysqli_query($conn, $query)){
			return true;
		}else{
			return false;
		}
	}

	function updateAccount($user_id, $password, $role){
		global $conn;
		$preRole = "none";
		$query = "SELECT * FROM `users` WHERE `user_id` = '$user_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				$row = mysqli_fetch_array($do);
				$preRole = $row['role'];
			}
		}
		if ($preRole == "teacher" && $role != "teacher") {
			$sql = "DELETE FROM `teacher_major` WHERE `teacher_id` = '$user_id'";
			mysqli_query($conn, $sql);
		}
		if ($password == null || $password == "") {
			$query = "UPDATE `users` SET `role`='$role' WHERE `user_id`='$user_id'";
		}else{
			$password = md5($password);
			$query = "UPDATE `users` SET `password`='$password',`role`='$role' WHERE `user_id`='$user_id'";
		}
		if (mysqli_query($conn, $query)) {
			return true;
		}else{
			return false;
		}
	}

	function deleteAccount($user_id){
		global $conn;
		$query = "SELECT * FROM `applications` WHERE `user_id` = '$user_id' OR `approved_by` = '$user_id'";
		if ($do = mysqli_query($conn, $query)) {
			if (mysqli_num_rows($do) > 0) {
				while ($row = mysqli_fetch_array($do)) {
					unlink($row['image']);
				}
			}
		}
		$query = "DELETE FROM `applications` WHERE `user_id` = '$user_id' OR `approved_by` = '$user_id'";
		mysqli_query($conn, $query);
		$query = "DELETE FROM `teacher_major` WHERE `teacher_id` = '$user_id'";
		mysqli_query($conn, $query);
		$query = "DELETE FROM `users` WHERE `user_id` = '$user_id'";
		mysqli_query($conn, $query);
	}
 ?>