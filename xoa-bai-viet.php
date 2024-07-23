<?php
include'head.php';
if(isset($_POST['id_post'])){
$id_bai = $_POST['id_post'];
 $sql = "SELECT * FROM posts WHERE id ='$id_bai'";
                            $result = mysqli_query($conn, $sql);
                            if($row = mysqli_fetch_assoc($result)){
                            if($row['username'] == $_name){
                            $update_query = "DELETE FROM posts WHERE id = $id_bai";
mysqli_query($conn, $update_query);
$update_query1 = "DELETE FROM binh_luan WHERE id_post = $id_bai";
mysqli_query($conn, $update_query1);
                            echo '
						<script type="text/javascript">
						
						$(document).ready(function(){
						
						  swal({
								title: "Thành công",
								text: "Xoá thành công bài viết!!",
								type: "success",
								confirmButtonText: "OK",
						  })
						});
						
						</script>
						';
                            }else{
                            echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "Bạn không phải chủ bài đăng có id = '.$id_bai.'",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
                            }
                            }else{
                                            echo'
<script type="text/javascript">
                
                $(document).ready(function(){
                
                  swal({
                        title: "Thất bại",
                        text: "không tìm thấy bài viết có id = '.$id_bai.'",
                        type: "error",
                        confirmButtonText: "OK",
                  })
                });
                
                </script>';
                            }
}
?>
<div class="p-1 mt-1 alert alert-danger" style="border-radius: 7px; box-shadow: 0px 0px 5px black;">
<h1>HƯỚNG DẪN XOÁ BÀI VIẾT</h1>
<img height="400" src="image/huongdan.png" style="vertical-align: middle;"> 
</br>
ví dụ: như hình trên id là 23 thì ae nhập 23 vào ô ở dưới để xoá</br>
 lưu ý : bạn phải là chủ bài đăng

<form class="text-center col-lg-5 col-md-10" style="margin: auto;"
                      method="post">
                    <h1 class="h3 mb-3 font-weight-normal">xoá bài</h1>
                    <input style="height: 50px; border-radius: 15px; font-weight: bold;" name="id_post" required="" autofocus=""
                           type="text" class="form-control mt-1" placeholder="id bài viết">
                    <span style="color: red; font-size: 12px; font-weight: bold;">
                                            </span>
                                        <button class="btn btn-lg btn-dark btn-block" style="border-radius: 10px;width: 100%; height: 50px;"
                                type="submit" name="submit">Xác Nhận</button>
                    </div>
                </form>