<!--footer: Start-->
<div id="footer-wrapper">
    <div class="copyright-section">
        <div class="footer-copyright-main">
            <div class="copyright-left">Copyright &copy;Wiki <?php echo date("Y");?>. All Rights Reserved</div>
            <div class="copyright-right">Powered by- <a href="http://www.vinfotech.com" target="_blank">Vinfotech</a></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<!--footer: End-->

<!--popup confirmation-->
<div class="popup confirm" id="confirm" style="display:none; left:38%; width:385px;"> <a href="javascript:void(0);" class="close" onclick="closePopDiv('confirm');" style="margin-top:-3px;"></a>
    <div class="popupinner" style="width:380px;">
        <div class="note" style="width:380px;">
            <h5 id="confirm-user-message">Are you sure to delete this row?</h5>
        </div>
        <div class="btnbox"> 
			<div id="confirm-yes-button"><a href="javascript:void(0);" class="btnorange">Yes</a></div>
			<a href="javascript:void(0);" class="cancel" onclick="closePopDiv('confirm');">No</a> 
		</div>
    </div>
</div>
<!--popup confirmation-->
</body>
</html>