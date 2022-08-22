<?php
    session_start();

    $pageTitle='Members';
    if(isset($_SESSION['Username'])){


        
        include 'init.php';

        $do=isset($_GET['do']) ? $_GET['do'] : 'manage';
    
        if ($do == 'manage'){

            $query='';

            if (isset($_GET['page']) && $_GET['page'] == 'pending'){
                $query= 'AND RegStatuse= 0';
            }

            $stmt=$con->prepare("SELECT * FROM users WHERE  GroupID != 1  $query");
            $stmt->execute();
            $rows=$stmt->fetchAll();
            
            ?>

            <h1 class='text-center'>Manage Member</h1>

            <div class="container">
                <div class=" main-table table-responsive table-bordered text-center">
                    <table class="table mb-0">
                    
                        <tr>
                            <td>#ID</td>
                            <td>Usename</td>
                            <td>Email</td>
                            <td>Fullname</td>
                            <td>Refisterd date</td>
                            <td>Control</td>
                        </tr>

                        <?php
                            foreach($rows as $row){
                                echo "<tr>";
                                    echo "<td>" . $row['UserID'] . "</td>";
                                    echo "<td>" . $row['Username'] . "</td>";
                                    echo "<td>" . $row['Email'] . "</td>";
                                    echo "<td>" . $row['FullName'] . "</td>";
                                    echo "<td>" . $row['Date'] . "</td>";
                                    echo "<td>
                                        <a href='members.php?do=edit&userid=" . $row['UserID'] . "' class='btn btn-success'> <i class='fa fa-edit'></i> Edit</a>
                                        <a href='members.php?do=delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'> <i class='fa fa-close'></i> Delete</a>";

                                        if($row['RegStatuse'] == 0){
                                            echo "<a href='members.php?do=activate&userid=" . $row['UserID'] . "' class='btn btn-info' style='margin-left:5px;'> <i class='fa fa-close'></i> Activate</a>";
                                        }

                                    echo    "</td>";
                                    
                                echo"</tr>";
                            }
                        ?>
                        
                    </table>
                </div>
                <a href='members.php?do=add' class="btn btn-primary mt-3"> <i class="fa fa-plus"></i> new member</a>      
            </div>

        <?php } elseif ($do == 'add'){ ?>

            <h1 class='text-center'>Add Member</h1>

                <div class="container">
                    <form class="form-horizontal" action="?do=insert" method="POST">
                    
                        <div class="row form-group">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='username' class='form-control' autocomplete="off" Required='required'>
                            </div>
                            
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="password" name='password'  class='password form-control' autocomplete="new-password" Required='required'>
                                <i class="show-pass fa fa-eye "></i>
                            </div>
                            
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="email" name='email' class='form-control' autocomplete="off" Required='required'>
                            </div>
                            
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Full name</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='full' class='form-control' autocomplete="off" Required='required'>
                            </div>
                            
                        </div>


                        <div class="row form-group">
                            
                            <div class='offset-sm-2 col-sm-10 col-md-4'>
                                
                                <input type="submit" value='Save' class='btn btn-primary btn-lg'>
                            </div>
                            
                        </div>
                    </form>
                </div>
        <?php 
        } elseif ($do == 'insert'){
            echo "<h1 class='text-center'>Add Members</h1>";
            echo "<div class='container'>";

            if($_SERVER['REQUEST_METHOD'] == "POST"){

                $user=$_POST['username'];
                $pass=$_POST['password'];
                $email=$_POST['email'];
                $full=$_POST['full'];
                $hashPass= sha1($_POST['password']);
                 

                //validate the form 
                //if errors exists
                $formErrors= array();

                if(strlen($user) < 4){
                    $formErrors[]= '<div class="alert alert-danger">user name cant be less <strong> than 4</strong> </div>';
                }

                if(strlen($user) > 20){
                    $formErrors[]= ' <div class="alert alert-danger">user name cant be more <strong> than 20</strong></div>';
                }

                if(empty($user)){
                    $formErrors[]= '<div class="alert alert-danger">username cant be <strong>empty</strong></div>' ;
                }

                if(empty($pass)){
                    $formErrors[]= '<div class="alert alert-danger">password cant be <strong>empty</strong></div>' ;
                }

                if(empty($full)){
                    $formErrors[]= '<div class="alert alert-danger">full name cant be <strong>empty</strong></div>' ;
                }

                if(empty($email)){
                    $formErrors[]= '<div class="alert alert-danger">Email cant be <strong>empty</strong></div>' ;
                }

                foreach($formErrors as $error){
                    echo $error  ; 
                }

                //update the database with this info

                //if no errors
                if (empty($formErrors)){

                    $check= checkItem("Username", "users", $user);

                    if ($check == 1){

                        $theMsg= "<div class='alert alert-danger'>sorry this user is exist</div>";
                        redirectHome($theMsg, 'back', 6);
                    } else{

                        $stmt= $con->prepare("INSERT INTO users(Username, Password, Email, FullName,RegStatuse ,Date) VALUES (:zuser, :zpass, :zemail, :zname,1, now())");
                        $stmt->execute(array( 'zuser'=> $user, 'zpass'=> $hashPass, 'zemail'=> $email, 'zname'=> $full));

                        $theMsg= '<div class="alert alert-success">' . $stmt->rowCount() . ' Record inserted </div>';
                        redirectHome($theMsg, null, 5);
                    }
                }
                
            } else{

                $theMsg= "<div class='alert alert-danger'>you can't browse this page directly</div>";
                redirectHome($theMsg, 'back', 6);

            }
            echo "</div>";

        } elseif ($do == 'edit'){ 

            $userid= isset($_GET['userid']) && is_numeric ($_GET['userid'])? intval($_GET['userid']) : 0 ;
            
            $stmt= $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
            $stmt->execute(array($userid));
            $row= $stmt->fetch();
            $count= $stmt->rowCount();

            if($count > 0){?>

                <h1 class='text-center'>Edit Members</h1>

                <div class="container">
                    <form class="form-horizontal" action="?do=update" method="POST">
                    
                        <input type="hidden" name="userid" value="<?php echo $userid ?>">
                        <div class="row form-group">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='username' value='<?php echo $row['Username']?>' class='form-control' autocomplete="off" Required='required'>
                            </div>
                            
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="hidden" name='oldpassword' value='<?php echo $row['Password']?>'>
                                <input type="password" name='newpassword'  class='form-control' autocomplete="new-password">
                            </div>
                            
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="email" name='email' value='<?php echo $row['Email']?>' class='form-control' Required='required'>
                            </div>
                            
                        </div>

                        <div class="row form-group">
                            <label class="col-sm-2 control-label">Full name</label>
                            <div class='col-sm-10 col-md-4'>
                                <input type="text" name='full' value='<?php echo $row['FullName']?>' class='form-control' Required='required'>
                            </div>
                            
                        </div>


                        <div class="row form-group">
                            
                            <div class='offset-sm-2 col-sm-10 col-md-4'>
                                
                                <input type="submit" value='Save' class='btn btn-primary btn-lg'>
                            </div>
                            
                        </div>
                    </form>
                </div>

            <?php    
            } else{
                $errorMsg= "you can't browse this page directly";
                redirectHome($errorMsg, 6);
            }

            

            

        } elseif( $do == 'update'){
            echo "<h1 class='text-center'>update Members</h1>";
            echo "<div class='container'>";
                if($_SERVER['REQUEST_METHOD'] == "POST"){

                    $id=$_POST['userid'];
                    $user=$_POST['username'];
                    $email=$_POST['email'];
                    $full=$_POST['full'];

                    $pass= empty($_POST['newpassword']) ? $_POST['oldpassword']:sha1($_POST['newpassword']);

                    //validate the form 
                    //if errors exists
                    $formErrors= array();

                    if(strlen($user) < 4){
                        $formErrors[]= 'user name cant be less <strong> than 4</strong> ';
                    }

                    if(strlen($user) > 20){
                        $formErrors[]= 'user name cant be more <strong> than 20</strong>';
                    }

                    if(empty($user)){
                        $formErrors[]= 'username cant be <strong>empty</strong>' ;
                    }

                    

                    if(empty($full)){
                        $formErrors[]= 'full name cant be <strong>empty</strong>' ;
                    }

                    if(empty($email)){
                        $formErrors[]= 'Email cant be <strong>empty</strong>' ;
                    }

                    foreach($formErrors as $error){
                        echo '<div class="alert alert-danger">' . $error . '</div>' ; 
                    }
                    //update the database with this info

                    //if no errors
                    if (empty($formErrors)){
                        $stmt= $con->prepare("UPDATE users SET Username= ? , Password=? , Email= ? , FullName= ? WHERE UserID= ? ");
                        $stmt->execute(array($user, $pass, $email, $full, $id));

                        $theMsg= '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated </div>';
                        redirectHome($theMsg, 'back', 6);

                    }

                    
                }else {
                    
                    $errorMsg= "<div class='alert alert-danger'>you can't browse this page directly</div>";
                    redirectHome($errorMsg,null, 6);
                }

            echo "</div>";
        } elseif ($do == 'delete'){

            echo "<h1 class='text-center'>Delete Member</h1>";
            echo "<div class='container'>";

                $userid= isset($_GET['userid']) && is_numeric ($_GET['userid'])? intval($_GET['userid']) : 0 ;

                $check= checkItem('userid', 'users', $userid);
              

                if($check > 0){

                    $stmt= $con->prepare("DELETE FROM users WHERE UserID = ? ");
                    $stmt->execute(array($userid));
                    $theMsg= '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted </div>';
                    redirectHome($theMsg,null,6);

                } else{
                    $theMsg= '<div class="alert alert-danger">this user is not exist</div>';
                    redirectHome($theMsg,null,6);
                }          

            echo '</div>';
        } elseif ($do == 'activate'){

            echo "<h1 class='text-center'>Activate Member</h1>";
            echo "<div class='container'>";

                $userid= isset($_GET['userid']) && is_numeric ($_GET['userid'])? intval($_GET['userid']) : 0 ;

                $check= checkItem('userid', 'users', $userid);
              

                if($check > 0){

                    $stmt= $con->prepare("UPDATE users SET RegStatuse= 1 WHERE UserID = ? ");
                    $stmt->execute(array($userid));

                    $theMsg= '<div class="alert alert-success">' . $stmt->rowCount() . ' user is Activated </div>';
                    redirectHome($theMsg,null,6);

                } else{
                    $theMsg= '<div class="alert alert-danger">this user is not exist</div>';
                    redirectHome($theMsg,null,6);
                }          

            echo '</div>';
        }

        
        include $tpl . 'footer.php';
    } else {

        header('location: index.php');
        exit();
    }