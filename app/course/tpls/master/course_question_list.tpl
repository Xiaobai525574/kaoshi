{x2;if:!$userhash}
{x2;include:header}
<body>
{x2;include:nav}
<div class="container-fluid">
    <div class="row-fluid">
        <div class="main">
            <div class="col-xs-2" style="padding-top:10px;margin-bottom:0px;">
                {x2;include:menu}
            </div>
            <div class="col-xs-10" id="datacontent">
                {x2;endif}
                <div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
                    <div class="col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="index.php?{x2;$_app}-master">{x2;$apps[$_app]['appname']}</a></li>
                            <li class="active">课程反馈</li>
                        </ol>
                    </div>
                </div>
                <div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
                    <h4 class="title" style="padding:10px;">
                        课程反馈
                    </h4>
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr class="info">
                            <th>用户</th>
                            <th>课程</th>
                            <th>章节</th>
                            <th>课程感想</th>
                            <th>问题建议</th>
                            <th>期望内容</th>
                            <th>其他</th>
                            <th>未出席原因</th>
                        </tr>
                        </thead>
                        <tbody>
                        {x2;if:sizeof($questions['data'])>0}

                        {x2;tree:$questions['data'],question,cid}
                        <tr>
                            <td>{x2;v:question['username']}</td>
                            <td>{x2;v:question['cstitle']}</td>
                            <td>{x2;v:question['coursetitle']}</td>
                            <td>{x2;v:question['qthoughts']}</td>
                            <td>{x2;v:question['qadvice']}</td>
                            <td>{x2;v:question['qexpect']}</td>
                            <td>{x2;v:question['qother']}</td>
                            <td>{x2;v:question['qreason']}</td>

                        </tr>
                        {x2;endtree}

                        {x2;else}
                        <td style="border-color: #fff; padding-top: 20px" >该课程暂时无反馈！</td>
                        {x2;endif}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {x2;if:!$userhash}
    </div>
</div>
</div>
{x2;include:footer}
</body>
</html>
{x2;endif}



