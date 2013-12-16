<div id="wrapper">
  <div class="left-content-main"><?php echo $sidebar;?>  </div>
  <div class="rightmain">
    <div class="breadcrumb"> <span class="arrowleft"></span>    
      <ul>
        <li><?php echo anchor('user/feeds','Home'); ?></li>
        <li><a href="javascript:void(0);" class="active">Search</a></li>
      </ul>
    </div>
    <div class="rightinner">
            <div class="searchboxmain">
				<div class="search-mini">
					<form  method="post" onSubmit="loadMoreSearch(this);return false;">
                	<div class="field">
                        <label for="txtF5" class="infield">Search</label>
                        <input name="keyword" type="text" class="inputmain" id="txtF5" value="<?php echo $this->input->post('keyword','')?>" />
                        <input type="submit" class="btnorange" value="Search"/>
                        <a href="javascript:void(0);" class="txtadvance" id="txtad">Advance Search</a> 
					</div>
					</form>
                </div>
                <div class="advancesearch" style="display:none;">
					<form  method="post" onSubmit="loadMoreSearch(this);return false;">
					<table class="tbladvance" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>Search</td>
                            <td><div class="field">
                                    <input type="text" name="keyword" class="inputmain inputmain-cal" value="<?php echo $this->input->post('keyword','')?>"/>
                                    <a href="javascript:void(0);" class="sicon"></a> </div></td>
                            <td>By</td>
                            <td><div class="field">
                                    <label for="txtF7" class="infield">username</label>
                                    <input type="text" id="txtF7" class="inputmain" value="" name="user_name" />
                                </div></td>
                        </tr>
                        <tr>
                            <td>From</td>
                            <td><div class="field">
                                    <input type="text" class="inputmain inputmain-cal" name="from_date" id="from_date" readonly/>
                                    <a href="javascript:void(0);" class="cal-icon"></a> </div></td>
                            <td>To</td>
                            <td><div class="field">
                                    <input type="text" class="inputmain inputmain-cal" name="to_date" id="to_date" readonly/>
                                    <a href="javascript:void(0);" class="cal-icon"></a> </div></td>
                        </tr>
                        <tr>
                            <td colspan="4"><span class="field">
                                <input type="submit" class="btnorange" value="Search" />
								<input type="hidden" class="btnorange" name="searchtype" value="advance" />
                                </span>
								<a href="javascript:void(0);" class="txtnmsearch" id="txtnm">Normal Search</a>
							</td>
                        </tr>
                    </table>
					</form>
                </div>
                
            </div>
           
			<div id="show-post"></div>
				<div class="txtshow showmore" id="show-post-more">
                    <a href="javascript:void(0);" class="txtgrey" onclick="loadMoreSearch('more');"><span class="txtload">Show more</span>
                    <img src="images/loader.gif" alt="" id="show-post-loading" style="display:none;"/></a>
				</div>
                <script>loadMoreSearch();</script>
			
		
</div>
  </div>
  <div class="clear"></div>
</div>

<script>
$(function(){ 
			$("#to_date").datepicker({ dateFormat: 'M dd, yy' });
			$("#from_date").datepicker({ dateFormat: 'M dd, yy' });
		});
</script>