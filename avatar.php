<?php
include ('head.php');
if (isset($_POST['start'])) {
  $file = $_FILES['myFile']['tmp_name'];
  $path = "avatar/" . $_FILES['myFile']['name'];
  if (move_uploaded_file($file, $path)) {
    $file_parts = explode('.', $_FILES['myFile']['name']);
    $file_ext = strtolower(end($file_parts));
    $expensions = array("jpeg", "jpg", "png");
    if (in_array($file_ext, $expensions) === false) {
      echo '
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Đòi Bug à k có cửa nha cu!",
                        type: "warning",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
    } else {
      $update_query = "UPDATE account SET 
 anh_web = '$path'
 WHERE username = '$_tk'";
      mysqli_query($conn, $update_query);
      echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Đổi avatar thành công!",
								type: "success",
					
						  })
						});	
					
						</script>
						';
    }
  } else {
    echo '
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Vui lòng chọn tệp!",
                        type: "warning",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
  }
}
?>
<div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
  <form method="POST" enctype="multipart/form-data">
    <input type="file" name="myFile">
    </br>
    </br>
    <button name="start" type="submit">Đổi avatar</button>
  </form>
</div>