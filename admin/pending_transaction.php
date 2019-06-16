<?php
require_once 'inc/header.php';
require_once 'inc/sideber.php';
?>
    <!-- Right side Threme color setting -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          Transation
        </h1>
        <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Transaction Request</a></li>
            <li class="active"> Pendng</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-xs-12">
            <!-- /.box -->
            <div class="box">
                <div class="box-header">
                    <?php
                        if(isset($_GET['delId'])){
                            $del_id=$_GET['delId'];
                            $query="DELETE  FROM tbl_transaction_admin WHERE id='$del_id'";
                            $result=database::connect()->query($query);

                        }
                        ?>
                    <h2 class="box-title">Total Transaction Request</h2>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <?php
                        if(isset($_GET['confirm_id'])){
                            $confirm_id=$_GET['confirm_id'];
                            $successResult=$transaction->updateUserBalance($confirm_id);
                            if ($successResult){
                                echo $successResult;
                            }
                        }

                        $query="SELECT * FROM tbl_transaction_admin WHERE confirm='0' ORDER BY id DESC ";
                        $result=database::connect()->query($query);
                    ?>
                    <table id="example1" class="table  text-center table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Amount</th>
                            <th>User Id</th>
                            <th>Withdraw Date</th>
                            <th>Transaction Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if($result->num_rows>0) {
                            $i=1;
                            foreach ($result as $value){
                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $value['amount']; ?></td>
                                    <td><?php echo $value['user_id']; ?></td>
                                    <td><?php echo date('d M Y,h:i:s',strtotime($value['tran_date'])); ?></td>
                                    <td>
                                        <?php
                                        if($value['confirm']==0){
                                            echo "Pending";
                                        }else{
                                            echo "Success";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                       <a class="btn btn-success" onclick="return confirm('Are you sure to confirm this request?')" href="?confirm_id=<?php echo $value['id']; ?>"><i class="glyphicon glyphicon-ok"></i></a>
                                       <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this request?')" href="?delId=<?php echo $value['id']; ?>"><i class="glyphicon glyphicon-remove"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->



<?php
require_once 'inc/footer.php';
?>