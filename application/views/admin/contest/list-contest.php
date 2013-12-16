<!--Wrapper Start-->
<div id="wrapper">
    <div class="breadcrumb"></div>
    <div class="container">
    	<div class="maintitle">
            <h1>Contest List</h1>
		</div>
        
        <div class="search">
            <div class="field">
                <form action="<?php echo site_url('home/showcontestlisting');?>" name="serach_subscribe_user_by_name" method="get">
                    <label for="search" class="infield">Search within your contest list</label>
                    <input name="search" type="text" id="search" class="inputmain" value="<?php echo $this->input->get('search','Search within your contest list')?>" />
                    <input type="submit" class="icon" value="" style="border:none;">
                </form>
            </div>
            <div style="float:right;" class="btnbox">
				<a class="btnorange" href="home/displayaddcontest" ><span class="add-icon"></span>Create new contest</a>
                
           </div>
        </div>
        
        <div class="grid grid5">
        	
            <div class="clear"></div>
        <?php  if(!empty($contest_list)){?>
			<table border="0" cellpadding="0" cellspacing="0" class="tblgrid">
                <tr>
                    <th>Title</th>                    
                    <th>Runs from</th>
                    <th>Runs to</th>
                    <th class="textcenter">Prize (in $)</th>
                    <th class="textcenter">Status</th>                    
                    <th class="textcenter">Action</th>
                </tr>
                <?php $i=0; foreach($contest_list as $row) {
						if( $i%2==0)
						{ $class_alt = "class = 'alt' ";	}
						else
						{ $class_alt = "";	}
							 ?>
                <tr <?php echo $class_alt ;?>>
	                <td>
						<?php $title = (strlen($row['title'])<50)?$row['title']:substr($row['title'],0,50)."...." ;?>
						<?php echo anchor('home/contestview/'.$row['contest_id'],$title); ?>
                    </td>                    
                    <td><?php echo int_to_date($row['runs_from']); ?></td>
                    <td><?php echo int_to_date($row['runs_to']); ?></td>
                    <td class="textcenter"><?php echo $row['prize']; ?></td>
                    <td class="textcenter">
							<?php
								if($row['status'] == 1 && $row['is_deleted'] == 0 ){
									echo "Contest Running";
								}elseif($row['status'] == 0 && $row['is_deleted'] == 0){
									echo "Contest Close"; 
								}elseif($row['status'] == 0 || $row['status'] == 1  && $row['is_deleted'] == 1){
									echo "Contest Deleted";
								}
							?>
                    </td>
                    <td><div class="makepostdd">
                            <div class="mpddinner">
                                <div class="mptop"></div>
                                <div class="mpmid">
                                    <ul>
                                        <li><a href="home/contestview/<?php echo $row['contest_id']?>" >View</a></li>
                                        <li><a href="home/contestedit/<?php echo $row['contest_id']?>" >Edit</a></li>
                                        
										<?php if($row['status'] == 1 && $row['is_deleted'] == 0 ){?>
                                        	
                                            <li><a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Close Contest</a>
                                			<div class="adl"><a class="btnorange" onClick="contestClose('<?php echo $row['contest_id']?>', '0','Close');">Yes</a></div>
                                            </li>
                                            <li><a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Delete</a>
                                			<div class="adl"><a class="btnorange" onClick="contestDelete('<?php echo $row['contest_id']?>');">Yes</a></div></li>
                                        
										<?php } elseif($row['status'] == 0 && $row['is_deleted'] == 0){?>
                                        	
                                            <li><a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Open Contest</a>
                                				<div class="adl"><a class="btnorange" onClick="contestClose('<?php echo $row['contest_id']?>', '1','Open');">Yes</a></div>
                                            </li>
                                            
                                            <li><a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Delete</a>
                                			<div class="adl"><a class="btnorange" onClick="contestDelete('<?php echo $row['contest_id']?>');">Yes</a></div></li>
                                            
                                         <?php } elseif($row['status'] == 0 || $row['status'] == 1  && $row['is_deleted'] == 1){?>   
                                          	
                                             <li><a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Restore</a>
                                			 <div class="adl"><a class="btnorange" onClick="contestRestore('<?php echo $row['contest_id']?>');">Yes</a></div></li>
                                             <li><a class="del-cont" href="javascript:void(0);" onclick="prepareConfirmPopup(this,'Are you sure?')">Delete Permanently</a>
                                			 <div class="adl"><a class="btnorange" onClick="deletePermanent('<?php echo $row['contest_id']?>');">Yes</a></div></li>
                                            
                                         <?php }?>  
                                    </ul>
                                </div>
                                <div class="mpbot"></div>
                            </div>
                            <a href="javascript:void(0);" class="arrowpost"></a></div>
                    </td>
                </tr>
                <?php $i++; }?>
            </table>
			<?php }else{ ?>
				<div class="noresult">This section have no results</div>
			<?php }?>
        </div>
		
        <!-- Pagination Region : Start -->
        <div class="pagination-region">
            <div class="rleft"><span class="left"></span></div>
            <div class="paginationdiv">
                <div class="pagination"> <?php echo $this->pagination->create_links(); ?> </div>
            </div>
        </div>
        <!-- Pagination Region : End --> 
    </div>
    <div class="clear"></div>
</div>
<!--Wrapper End-->