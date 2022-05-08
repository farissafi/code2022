<?php
// connecting in database
$conn = mysqli_connect("localhost", "root", "", "center_db");
if (!$conn) {
  die("No connect" . mysqli_connect_errno());
}

// insert  data with image|file
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $detail = $_POST['detail'];
  if (file_exists($_FILES['image']['tmp_name'])) {
    $old_img_name = $_FILES['image']['name'];
    $expload_name = explode(".", $old_img_name);
    $ext = end($expload_name);
    $imageName = "img" . time() . "." . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/dep/' . $imageName);
    $sql = "insert into department (name,detail,image) values ('$name','$detail','$imageName')";
    include "conn.php";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $msg = '<div class="alert alert-success" role="alert">
                تمت عملية الاضافة بنجاح
              </div>';
    } else {
      $msg = '<div class="alert alert-danger" role="alert">
                لم تتم عملية الاضافة بنجاح
              </div>';
    }

    mysqli_close($conn);
  }
}

// insert data without image|file
if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $detail = $_POST['detail'];
  $sql = "insert into department (name,detail) values ('$name','$detail')";
  include "conn.php";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $msg = '<div class="alert alert-success" role="alert">
      تمت عملية الاضافة بنجاح
    </div>';
  } else {
    $msg = '<div class="alert alert-danger" role="alert">
      لم تتم عملية الاضافة بنجاح
    </div>';
  }

  mysqli_close($conn);
}

// show data using table with while 
include "conn.php";
$sql = "select * from department";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $key = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    echo '
        <tr class="align-middle">
          <th scope="row">' . ++$key . '</th>
          <td>' . $row['name'] . '</td>
          <td><img width="100px" src="../images/dep/' . $row['image'] . '" alt="' . $row['name'] . '"></td>
          <td><a href="depedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
          <td><a href="depdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
        </tr>
        
        ';
  }
} else {
  echo '<tr class="align-middle">
     <td colspan="5" scope="row">لا يوجد بيانات يمكن عرضها...</td>
 </tr>';
}

// show data with foreach
include "conn.php";
$sql = "select * from department";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  foreach ($result as $key => $row) {
    echo '
    <tr class="align-middle">
      <th scope="row">' . ++$key . '</th>
      <td>' . $row['name'] . '</td>
      <td><img width="100px" src="../images/dep/' . $row['image'] . '" alt="' . $row['name'] . '"></td>
      <td><a href="depedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
      <td><a href="depdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
    </tr>
    
    ';
  }
} else {
  echo '<tr class="align-middle">
     <td colspan="5" scope="row">لا يوجد بيانات يمكن عرضها...</td>
 </tr>';
}
//show data from two table
include "conn.php";
	$sql = "select students.id,students.name,students.email,students.age,
	students.address,students.phone,department.id as dId,department.name as dName
	from students join department on students.depnum=department.id ";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		$key = 0;
		while ($row = mysqli_fetch_assoc($result)) {
			echo '
				<tr class="align-middle">
					<th scope="row">' . ++$key . '</th>
					<td>' . $row['name'] . '</td>
					<td>' . $row['email'] . '</td>
					<td>' . $row['age'] . '</td>
					<td>' . $row['address'] . '</td>
					<td>' . $row['phone'] . '</td>
					<td>' . $row['dName'] . '</td>
					<td><a href="studentedit.php?id='.$row['id'].'" class="btn btn-danger">edit</a></td>
					<td><a href="studentdelete.php?id='.$row['id'].'" class="btn btn-danger">delete</a></td>
				</tr>
			';
		}
	} else {
		echo '<tr class="align-middle">
		 <td colspan="7" scope="row">لا يوجد بيانات يمكن عرضها...</td>
	 </tr>';
	}
//search from data in database
		include "conn.php";
		if (isset($_POST['submit'])) {
			$name = $_POST['name'];
			$sql = "select students.id,students.name,students.email,students.age,
		students.address,students.phone,department.id as dId,department.name as dName
		from students join department on students.depnum=department.id
		where students.name like '%$name%' ";
		} else {
			$sql = "select students.id,students.name,students.email,students.age,
		students.address,students.phone,department.id as dId,department.name as dName
		from students join department on students.depnum=department.id ";
		}

		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			$key = 0;
			while ($row = mysqli_fetch_assoc($result)) {
				echo '
					<tr class="align-middle">
						<th scope="row">' . ++$key . '</th>
						<td>' . $row['name'] . '</td>
						<td>' . $row['email'] . '</td>
						<td>' . $row['age'] . '</td>
						<td>' . $row['address'] . '</td>
						<td>' . $row['phone'] . '</td>
						<td>' . $row['dName'] . '</td>
						<td><a href="studentedit.php?id=' . $row['id'] . '" class="btn btn-danger">edit</a></td>
						<td><a href="studentdelete.php?id=' . $row['id'] . '" class="btn btn-danger">delete</a></td>
					</tr>
				';
			}
		} else {
			echo '<tr class="align-middle">
			 <td colspan="7" scope="row">لا يوجد بيانات يمكن عرضها...</td>
		 </tr>';
		}
//show data in select 
 <select class="form-select" name="dName" aria-label="Default select example">
	<?php
	include "conn.php";
	$sql = "select id,name from department";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		while ($drow = mysqli_fetch_assoc($result)) {
	?>
			<option 
			<?php if ($drow['id'] == $row['depnum']) { ?> 
				selected="selected" 
				<?php } ?> 
				value='<?php echo $drow['id']; ?>'>
				<?php echo $drow['name'];  ?>
			</option>

	<?php }
	} ?>
</select>
//SLIDER BY FOREACH
<div class="row">
                <?php
                include "admin/conn.php";
                $sql = "select * from news";
                $result = mysqli_query($conn, $sql);

                ?>
                <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $key => $row) {
                        ?>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $key ?>" class="<?php if ($key == 0) echo 'active' ?>" aria-current="true" aria-label="Slide <?php echo ++$key ?>"></button>

                        <?php
                            }
                        }
                        ?>


                    </div>
                    <div class="carousel-inner">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            foreach ($result as $key => $row) {
                        ?>
                                <div class="carousel-item <?php if ($key == 0) echo 'active' ?>">
                                    <img src="images/<?php echo $row['image'] ?>" class="d-block w-100" alt="<?php echo $row['title'] ?>">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5><?php echo $row['title'] ?></h5>
                                        <p><?php echo $row['detail'] ?></p>
                                    </div>
                                </div>

                        <?php
                            }
                        }
                        ?>



                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

//edit data with image|file
if (isset($_GET['id'])) {
  include "conn.php";
  $sqlGetDepData = "select * from department where id=" . $_GET['id'];
  $result = mysqli_query($conn, $sqlGetDepData);
  $row = mysqli_fetch_assoc($result);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    if (file_exists($_FILES['image']['tmp_name'])) {
      $old_img_path = "../images/" . $row['image'];
      unlink($old_img_path);
      $new_img_name = $_FILES['image']['name'];
      $expload_name = explode(".", $new_img_name);
      $ext = end($expload_name);
      $imageName = "img" . time() . "." . $ext;
      move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $imageName);
      $sql = "update department set name='$name',detail='$detail',image='$imageName' where id=" . $_GET['id'];
      $res = mysqli_query($conn, $sql);
      header('location:depshow.php?success=true');
      exit();
    } else {

      $sql = "update department set name='$name',detail='$detail' where id=" . $_GET['id'];
      $res = mysqli_query($conn, $sql);
      header('location:depshow.php?success=true');
      exit();
    }
  }
}

// edit data without image
if (isset($_GET['id'])) {
  include "conn.php";
  $sqlGetDepData = "select * from department where id=" . $_GET['id'];
  $result = mysqli_query($conn, $sqlGetDepData);
  $row = mysqli_fetch_assoc($result);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $detail = $_POST['detail'];
    $sql = "update department set name='$name',detail='$detail',image='$imageName' where id=" . $_GET['id'];
    $res = mysqli_query($conn, $sql);
    header('location:depshow.php?success=true');
    exit();
  }
}

// delete data with image|file
if (isset($_GET['id'])) {
  include 'conn.php';
  $querySelect = 'select * from department where id=' . $_GET['id'];
  $ResultSelectStmt = mysqli_query($conn, $querySelect);
  $fetchRecords = mysqli_fetch_assoc($ResultSelectStmt);
  $createDeletePath  = '../images/' . $fetchRecords['image'];
  if (unlink($createDeletePath)) {
    $sql = "delete from department where id=" . $_GET["id"];
    $rsDelete = mysqli_query($conn, $sql);
    if ($rsDelete) {
      header('location:depshow.php?success=true');
      exit();
    }
  }
}
// delete data without image|file
if (isset($_GET['id'])) {
  include 'conn.php';
  $sql = "delete from department where id=" . $_GET["id"];
  $rsDelete = mysqli_query($conn, $sql);
  if ($rsDelete) {
    header('location:depshow.php?success=true');
    exit();
  }
}
// logout code
session_start();
if (isset($_SESSION['id'])) {
  session_destroy();
  header('location:login.php');
}

// login code 
$msg = "";
if (isset($_POST['submit'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = $_POST['password'];
  if (empty($username)) {
    $msg = "<div class='alert alert-danger' role='alert'>
      الرجاء ادخال اسم المستخدم
     </div>";
  } elseif (empty($_POST['password'])) {
    $msg = "<div class='alert alert-danger' role='alert'>
    الرجاء ادخال كلمة المرور
   </div>";
  } else {
    include "conn.php";
    $sql = "select * from users where username='$username' and password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
      $msg = "<div class='alert alert-danger' role='alert'>
        خطأ في اسم المستخدم و كلمة المرور
       </div>";
    } else {
      $user = mysqli_fetch_assoc($result);
      $_SESSION['id'] = $user['id'];
      header('Location:home.php');
    }
  }
}

// check user is login!
//put this code in all page 
session_start(); 
if (!isset($_SESSION['id'])) {

  header('Location:login.php');
}

//show data from select 

 <select name="book_categories " id="inputCategory" class="form-select">
	<?php
	include "config.php";
	$sql = "select * from category";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
	  foreach ($result as $key => $row) {
		echo '
		<option value="'.$row['id'].'">'.$row['title'].'</option>
		
		';
	  }
	} 
	
	?>

   
  </select>

// show data with id
  <?php
  if (isset($_GET['id'])) {
      include "admin/config.php";
      $deptDelet = "SELECT * FROM food_menu where id =" . $_GET['id'];
      $res  = mysqli_query($conn, $deptDelet);
      $row = mysqli_fetch_assoc($res);
  }
  ?>
// radio insert
  <div class="mb-3">
      <label for="">الجنس:</label>
      <div class="form-check">
          <input class="form-check-input" type="radio" value="1" name="gender" id="gender1">
          <label class="form-check-label" for="gender">
              ذكر
          </label>
      </div>
      <div class="form-check">
          <input class="form-check-input" type="radio" value="0" name="gender" id="gender2">
          <label class="form-check-label" for="gender">
              انثى
          </label>
      </div>
  </div>
<!-- checkbox  -->
  <div class="row mb-3">
    <div class="col-sm-10 offset-sm-2">
        <input class="form-check-input" name="isAdmin" value="1" type="checkbox" id="gridCheck1">
        ادمن؟
    </div>
  </div>

  // radio edit

  <!-- radio  -->
                      <div class="mb-3">
                           <label for="">الجنس</label>
                           <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="gender" id="gender1" <?php echo $row['gender'] == 1 ? "checked" : "" ?>>
                                <label class="form-check-label" for="gender">
                                     ذكر
                                </label>
                           </div>
                           <div class="form-check">
                                <input class="form-check-input" type="radio" value="0" name="gender" id="gender2" <?php echo $row['gender'] == 0 ? "checked" : "" ?>>
                                <label class="form-check-label" for="gender">
                                     انثى
                                </label>
                           </div>
                      <!-- checkbox -->
                          <div class="row mb-3">
                              <div class="col-sm-10 offset-sm-2">
                                  <input class="form-check-input" name="isAdmin" value="1" type="checkbox" id="gridCheck1" 
                                  <?php echo $row['isAdmin'] == 1 ? "checked" : "" ?> >
                                  ادمن؟
                              </div>
                          </div>



