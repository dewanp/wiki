<?php if(!empty( $qna)){?>
<?php foreach($qna as $row){ ?>
<div class="searchdtl" >
  <div class="sdleft">
    <div class="thumb" id ="qna-<?php echo $row['post_id'] ?>">
		<span><img src="images/loader.gif" alt= "" ></span>
				<script> showImage('<?php echo $row["post_image"]?>','111','90','qna-<?php echo $row["post_id"]?>');</script></div>
  </div>
  <div class="sdright">
    <h3><?php echo anchor(getPostUrl($row['post_id']), $row['title']); ?></h3>
    <p><?php 
	if(strlen($row['description'])<300){	
		echo $row['description']; 
	}else{
		echo substr($row['description'],0,300)." ....";
	}?></p>
    <div class="post-by-block qna-nav">
      <ul>
        <li><span class="by">By: </span><?php echo anchor($row['user_name'],$row['profile_name'],'class = "bylink"'); ?></li>
        <li> <a href="<?php echo getPostUrl($row['post_id']);?>" class="active">
				<?php echo $row['answer'];?> Answer </a>
		</li>
        <li><?php echo TimeAgo($row['created_date']); ?></li>
      </ul>
    </div>
  </div>
  <span class="or-icons qna"><img src="images/qna.png" alt="" /></span> </div>
<div class="divider" ></div>
<?php } ?>
<?php }else{?>
			<div class="searchdtl">There are no more Posts to show for this. Create another one for this <?php echo anchor('post/add','Create Post','class="btnorange" style="float:none;"')?></div>
<?php } ?>