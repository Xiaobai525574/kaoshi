<div class="container-fluid box" style="background-color:#337AB7;margin-bottom:0px;" id="footer">
	<div class="row-fluid">
		<div class="main itembox">
			<div class="col-xs-12">
				<ul class="list-unstyled">
					<li class="text-center"><a href="">安检云在线模拟考试系统 </a></li>
					<li class="text-center"><a href=""></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<script language="JavaScript">
    $(document).ready(function () {
        function footerEdit() {
            var browserHeight = window.innerHeight;
            var bodyHeight = document.body.offsetHeight;
            if ($('#footer').hasClass('footer-bottom') && browserHeight <= bodyHeight + $('#footer').outerHeight(true)) {
                $('#footer').removeClass('footer-bottom');
            } else if (browserHeight > bodyHeight) {
                $('#footer').addClass('footer-bottom');
            }
        }

        footerEdit();
        $(window).resize(footerEdit);
    });
</script>
