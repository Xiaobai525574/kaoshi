<?php if(!$this->tpl_var['userhash']){ ?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<?php } ?>
<div class="container-fluid" id="datacontent">
	<div class="row-fluid">
		<div class="main box itembox">
			<ul class="breadcrumb">
				<li>
					<span class="icon-home"></span> <a href="index.php?course">课程</a>
				</li>
				<li>
					<a href="index.php?course-app-index-lists">开通课程</a>
				</li>
				<li class="active">
					<?php echo $this->tpl_var['course']['cstitle']; ?>
				</li>
			</ul>
		</div>
		<div class="main box itembox">
			<h4 class="title">开通课程</h4>
			<div class="col-xs-1"></div>
			<div class="col-xs-3" style="padding-top:30px;">
				<div class="thumbnail"><img alt="300x200" src="<?php if($this->tpl_var['course']['csthumb']){ ?><?php echo $this->tpl_var['course']['csthumb']; ?><?php } else { ?>app/exam/styles/image/paper.png<?php } ?>" /></div>
			</div>
			<div class="col-xs-1"></div>
			<div class="col-xs-7">
				<div class="caption">
					<h4 class="title"><?php echo $this->tpl_var['course']['cstitle']; ?></h4>
					<p>&nbsp;</p>
					<p>您现有积分：<?php echo $this->tpl_var['_user']['usercoin']; ?> （<a href="index.php?user-center-payfor">支付宝充值</a> / <a href="#myModal" role="button" data-toggle="modal">代金券充值</a>）</p>
					<?php if($this->tpl_var['isopen']){ ?><p>到期时间：<?php echo date('Y-m-d',$this->tpl_var['isopen']['ocendtime']); ?></p><?php } ?>
				</div>
				<?php if(!$this->tpl_var['isopen']){ ?>
				<form action="index.php?course-app-course-opencourse" method="post">
					<?php if(!$this->tpl_var['course']['csdemo']){ ?>
						<?php if($this->tpl_var['price']){ ?>
						<p>
							<select name="opentype" class="form-control" style="width:180px;">
								<?php $pid = 0;
 foreach($this->tpl_var['price'] as $key => $p){ 
 $pid++; ?>
								<option value="<?php echo $key; ?>"><?php echo $p['price']; ?>积分兑换<?php echo $p['time']; ?>天</option>
								<?php } ?>
							</select>
						</p>
						<p>&nbsp;</p>
						<p>
							<input value="<?php echo $this->tpl_var['course']['csid']; ?>" name="csid" type="hidden"/>
							<input value="1" name="opencs" type="hidden"/>
							<input class="btn btn-primary" value="开通" type="submit"/>
						</p>
						<?php } else { ?>
						<p>&nbsp;</p>
						<p>
							<input class="btn" value="请管理员先在后台设置价格" type="button"/>
						</p>
						<?php } ?>
					<?php } else { ?>
					<p>&nbsp;</p>
					<p>
						<input value="<?php echo $this->tpl_var['course']['csid']; ?>" name="csid" type="hidden"/>
						<input value="1" name="opencs" type="hidden"/>
						<input class="btn btn-primary" value="开通" type="submit"/>
					</p>
					<?php } ?>
				</form>
				<?php } else { ?>
				<p>&nbsp;</p>
				<p>
					<a class="btn btn-primary" href="index.php?course-app-course&csid=<?php echo $this->tpl_var['course']['csid']; ?>">开始学习</a>
				</p>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<form aria-hidden="true" id="myModal" method="post" class="modal fade" role="dialog" aria-labelledby="#myModalLabel" action="index.php?exam-app-basics-coupon">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" class="close" type="button" data-dismiss="modal">×</button>
				<h4 class="modal-title" id="myModalLabel">代金券充值</h4>
			</div>
			<div class="modal-body" id="modal-body">
				<div class="control-group">
					<label class="control-label" for="content">代金券号码：</label>
			  		<div class="controls">
			  			<input type="text" class="form-control" name="couponsn" style="width:80%" value="" needle="needle" msg="请输入16位代金券号码"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				 <input name="coupon" type="hidden" value="1">
				 <button class="btn btn-primary" type="submit">充值</button>
			</div>
		</div>
	</div>
</form>
<?php $this->_compileInclude('footer'); ?>
</body>
</html>