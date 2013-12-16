<?php //echo "<pre>"; print_r($items); echo "</pre>";?>
<div class="view-mode">
<div class="view-modein">
    <?php if(!empty($items->Item)){?>
    	<?php if(is_array($items->Item)){?>
			<?php foreach($items->Item as $key => $amazonItem){?>
                <?php if($result_type=='keyword' && $key==$numberOfSearchResult){ break; }?>
                <div class="vrows">
                    <div class="vleft">
                        <div class="thumb"><?php if(property_exists($amazonItem,'SmallImage')){?><img src="<?php echo $amazonItem->SmallImage->URL; ?>" alt="" /><?php }?></div>
                    </div>
                    <div class="vright"> <span class="txtgrey" style="width:100%;"><?php echo anchor($amazonItem->DetailPageURL,$amazonItem->ItemAttributes->Title,'target="_blank"');?></span> 
                       			
						<div class="post-by-block post-by-block-amazon">
                        <ul>       
							<?php if(property_exists($amazonItem,'OfferSummary') && property_exists($amazonItem->OfferSummary,'LowestNewPrice')){?>
                                <li>Amazon Price <span class="txtorange"><?php echo $amazonItem->OfferSummary->LowestNewPrice->FormattedPrice?></span></li>                            
                            <?php }?>
                            <?php if(property_exists($amazonItem->ItemAttributes,'ListPrice')){?>
                                <li>List Price <span class="txtorange"><?php echo $amazonItem->ItemAttributes->ListPrice->FormattedPrice?></span></li>                            
                            <?php }?>
                        </ul>						
                    </div></div>
                </div>
            <?php }?> 
         <?php }else{?>
         	<div class="vrows">
                    <div class="vleft">
                        <div class="thumb"><?php if(property_exists($items->Item,'SmallImage')){?><img src="<?php echo $items->Item->SmallImage->URL; ?>" alt="" /><?php }?></div>
                    </div>
                    <div class="vright"> <span class="txtgrey" style="width:100%;"><?php echo anchor($items->Item->DetailPageURL,$items->Item->ItemAttributes->Title,'target="_blank"');?></span> 
                        <div class="post-by-block post-by-block-amazon">
                        <ul>       
							<?php if(property_exists($items->Item,'OfferSummary') && property_exists($items->Item->OfferSummary,'LowestNewPrice')){?>
                                <li>Amazon Price <span class="txtorange"><?php echo $items->Item->OfferSummary->LowestNewPrice->FormattedPrice?></span></li>                            
                            <?php }?>
                            <?php if(property_exists($items->Item->ItemAttributes,'ListPrice')){?>
                                <li>List Price <span class="txtorange"><?php echo $items->Item->ItemAttributes->ListPrice->FormattedPrice?></span></li>                            
                            <?php }?>
                        </ul>
                      </div>
                    </div>
                </div>         	
		 <?php }?>  
    <?php }?> 
</div>
</div>