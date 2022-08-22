<?php
    session_start();

    if(isset($_SESSION['Username'])){

        $pageTitle='dashboard';
        include 'init.php';
        ?>

        <div class="container home-stats text-center">
            <h1>Dashboard</h1>
            <div class="row">
                
                <div class="col-md-3">
                    <div class="stat st-members">
                        Total members
                        <span><a href="members.php"><?php echo countItems('UserID', 'users'); ?></a></span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-pending">
                        Pending members
                        <span><a href="members.php?do=manage&page=pending"><?php echo checkItem('RegStatuse', 'users', 0) ?></a> </span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-items">
                        Total items
                        <span>1500</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="stat st-comments">
                        Total comments
                        <span>3500</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="container latest">
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <?php $latestUsers= 3; ?>
                        <div class="card-header">
                            <i class="fa fa-users"></i> latset <?php echo $latestUsers; ?> rigisterd users
                        </div>
                        <div class="card-body">
                            <?php
                                $theLatest= getLatest("*", "users", "UserID", $latestUsers);
                                foreach($theLatest as $user){
                                    echo $user["Username"] . "<br>";
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-tag"></i> latset items 
                        </div>
                        <div class="card-body">
                            test
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php
        include $tpl . 'footer.php';
    } else {

        header('location: index.php');
        exit();
    }