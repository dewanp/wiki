<!--Wrapper Start-->

<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
        <div class="maintitle">
            <h1>Dashboard</h1>
        </div>
        <div class="grid">
            <h3>Registration Summary</h3>
            <div class="clear"></div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Period</th>
                    <th>Number of Users</th>
                </tr>
				<tr class="alt">
					<td >Today </td>
					<td><?php echo $summary['today'] ; ?> </td>
				</tr>
                <tr>
                    <td >Yesterday</td>
                    <td ><?php echo $summary['yesterday'] ; ?></td>
                </tr>
                <tr class="alt">
                    <td>Last 7 days</td>
                    <td><?php echo $summary['week']; ?></td>
                </tr>
                <tr>
                    <td >Last 3 Months</td>
                    <td ><?php echo $summary['month'] ; ?></td>
                </tr>
                <tr class="alt">
                    <td>All till today</td>
                    <td><?php echo $summary['all'] ; ?></td>
                </tr>
            </table>
        </div>
        <div class="grid grid2">
            <h3>Highest till time</h3>
            <div class="clear"></div>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Username</th>
                    <th>Number of Posts</th>
                </tr>
                <?php  foreach($result as $key=> $row){ 
						if($key%2==0) 
							 $class ="class='alt'"; 
						 else
							 $class = ""; ?>
						<tr <?php echo $class; ?>>
							 <td>
								<?php echo anchor('admin/manageuserviewdetails/'.$row['user_id'], $row['user_name'])?> 
							</td>
							 <td>
								<?php echo anchor('admin/manageuserscontenthistory/'.$row['user_id'], $row['Number']); ?>
							</td>
						</tr>
					<?php  }?>
            </table>
        </div>
    </div>
</div>
<!--Wrapper End--> 