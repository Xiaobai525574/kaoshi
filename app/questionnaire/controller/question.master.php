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
        $action = $this->ev->url(3);
        if (!method_exists($this, $action))
            $action = "index";
        $this->$action();
        exit;
    }

    /**
     * 将课程的问题评论导出为excel表格
     */
    public function toexclel()
    {
        //课程题目
        $cstitle = '';

        $csid = $this->ev->get('csid');
        $mysqli = mysqli_connect(DH, DU, DP, DB);
        $sql = 'SELECT
                    q.questionnaireid,
                    u.username,
                    cs.cstitle,
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
        require_once dirname(__FILE__) . '/../../../lib/PHPExcel.php';
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
        $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

//合并单元格
        $objPHPExcel->getActiveSheet()->mergeCells('A1:G1');

// set table header content
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '反馈汇总  时间:' . date('Y-m-d H:i:s'))
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
            $objPHPExcel->getActiveSheet(0)->setCellValue('B' . ($key + 3), $val['cstitle']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('C' . ($key + 3), $val['qthoughts']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('D' . ($key + 3), $val['qadvice']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('E' . ($key + 3), $val['qexpect']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('F' . ($key + 3), $val['qother']);
            $objPHPExcel->getActiveSheet(0)->setCellValue('G' . ($key + 3), $val['qreason']);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($key + 3) . ':G' . ($key + 3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A' . ($key + 3) . ':G' . ($key + 3))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getRowDimension($key + 3)->setRowHeight(16);
            if (!$cstitle) {
                $cstitle = $val['cstitle'];
            }
        }

// Rename sheet
        $objPHPExcel->getActiveSheet()->setTitle($cstitle . '课程');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
        ob_end_clean();//清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $cstitle . '课程反馈(' . date('Ymd-His') . ').xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

    }

}


?>
