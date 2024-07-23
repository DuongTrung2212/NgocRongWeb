<?php      
  $post_id = $_GET['id'];                                         $sql = "SELECT * FROM binh_luan WHERE id_post ='$post_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()){
  $name_tk = $row['name'];
  $sql4 = "SELECT * FROM player WHERE name = '$name_tk'";
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            $id_tk = $row4['account_id'];
                              $sql5 = "SELECT * FROM account WHERE id = '$id_tk'";
                            $result5 = mysqli_query($conn, $sql5);
                            $row5 = mysqli_fetch_assoc($result5);
                            $avatar_post = $row5['gender'];
       if($avatar_post == 0){$avatar_1="avatar/andanh.png";}else{$avatar_1 = $avatar_post;}         echo'       <div class="alert alert-danger" style="border-radius: 7px;">                             

                                                    <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px;">
                                <tbody>
                                    <tr>
                                        <td width="60px;" style="vertical-align: top">
                                            <div class="text-center" style="margin-left: -10px;">
                                                <img class="avatar" src="./assets/images/avatar/29.png"
                                                     style="width: 30px; "><br>
                                                <div style="font-size: 9px; padding-top: 5px">
                                                    <b>xfnnxbm</b>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="bg bg-white" style="border-radius: 7px;">
                                            <div class="row"
                                                 style="font-size: 9px; padding: 5px 7px;">
                                                <div class="col">
                                                    <span>19 giây trước</span>
                                                </div>
                                                <div class="col text-right">
                                                    <span>Điểm: 0</span>
                                                </div>
                                            </div>
                                            <div class="row" style="padding: 0 7px 15px 7px">
                                                <div class="col">
                                                    <span>Jfjcnfb</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                                                </div>';    
                   }         
                        }
                        ?>