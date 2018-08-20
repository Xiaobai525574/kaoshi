<?php
/**
 * Created by PhpStorm.
 * User: baiencai
 * Date: 2018/8/20
 * Time: 16:05
 */

class action extends app
{
    public function display()
    {
        $this->questionnaire = $this->G->make('questionnaire', 'questionnaire');

        $action = $this->ev->url(3);
        if (!method_exists($this, $action))
            $action = "index";
        $this->$action();
        exit;
    }

    /**
     * 某门课程的评论列表
     */
    public function index()
    {
        $csId = $this->ev->get('csid');

        $questions = $this->questionnaire->getQuestionListByCsId($csId);
        $this->tpl->assign('questions', $questions);
        $this->tpl->display('index');
    }

    /**
     * 将课程的问题评论导出为excel表格
     */
    public function toexclel()
    {
        $csid = $this->ev->get('csid');
        $mysqli = mysqli_connect('127.0.0.1', 'root', 'root', 'phpems');
        $sql = 'SELECT
                    q.questionnaireid,
                    u.username,
                    c.coursetitle,
                    q.qthoughts,
                    q.qadvice,
                    q.qexpect,
                    q.qother,
                    q.qreason
                FROM
                    x2_questionnaire AS q
                LEFT JOIN x2_user AS u ON q.userid = u.userid
                LEFT JOIN x2_course AS c ON c.courseid = q.courseid
                LEFT JOIN x2_coursesubject AS cs ON cs.csid = c.coursecsid
                WHERE
                    cs.csid =' . $csid;
        $result = mysqli_query($mysqli, $sql);

        //创建一个excel对象
        require_once '/lib/PHPExcel.php';
        $objPHPExcel = new PHPExcel();

// Set properties
        $objPHPExcel->getProperties()->setCreator("trans-cosmos")
            ->setLastModifiedBy("trans-cosmos")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Phpems result file");

//set width
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(36);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);

//设置行高度
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);

        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);

//set font size bold
        $objPHPExcel->getActiveSheet()->getDefaultStyle()->getFont()->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

//设置水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//合并单元格
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');

// set table header content
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '评论汇总  时间:' . date('Y-m-d H:i:s'))
            ->setCellValue('A2', '用户')
            ->setCellValue('B2', '课程')
            ->setCellValue('C2', '课程感想')
            ->setCellValue('D2', '问题建议')
            ->setCellValue('E2', '期望内容')
            ->setCellValue('F2', '其他')
            ->setCellValue('G2', '未出席原因');

// Miscellaneous glyphs, UTF-8

        foreach ($result as $key => $val) {
            $objPHPExcel->getActiveSheet(0)->setCellValue('A' . ($key + 3), $val['username']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($key + 3), $val['coursetitle']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($key + 3), $val['qthoughts']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($key + 3), $val['qadvice']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($key + 3), $val['qexpect']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($key + 3), $val['qother']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($key + 3), $val['qreason']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($key + 3) . ':G' . ($key + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($key + 3) . ':G' . ($key + 3))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getRowDimension($key + 3)->setRowHeight(16);
        }

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle('phpems');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="phpems(' . date('Ymd-His') . ').xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

}


?>
