<div class="container-fluid box" style="background-color:#337AB7;margin-bottom:0px;" id="footer">
	<div class="row-fluid">
		<div class="main itembox">
			<div class="col-xs-12">
				<ul class="list-unstyled">
					<li class="text-center"><a href="">transcosmos知识教育管理平台 著作权登记号：2013 SR 113189</a></li>
					<li class="text-center"><a href="">Copyright © transcosmos.net  <?php echo date('Y',TIME); ?></a></li>
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
            if (browserHeight > bodyHeight) {
                $('#footer').addClass('footer-bottom');
                console.log('add');
            } else {
                $('#footer').removeClass('footer-bottom');
                console.log('remove');
            }
        }

        footerEdit();
        $(window).resize(footerEdit);
    });
</script>
