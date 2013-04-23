<?php
session_start();
include "../global.php";
/** PHPExcel */
require_once './phpexcel/Classes/PHPExcel.php';
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
$unex=explode('|',$_SESSION['uname']);
$from  = $_GET['from'];
$to    = $_GET['to'];
$state = !empty($_GET['state'])?$_GET['state']:6;
$shopid= !empty($_GET['shopid'])?$_GET['shopid']:0;
//当前报表属于哪家商铺
$shopname = $shopid?'-'.iconv('gb2312','utf-8',get_shopname($db,$shopid)):"";
$p = array('rqs'=>$from,'rqe'=>$to,'state'=>$state,'shopid'=>$shopid);
$orders_info=get_orders_info($db,$unex[0],$p);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '开始日期')
            ->setCellValue('B1', $from)
            ->setCellValue('C1', '结束日期')
			->setCellValue('D1', $to)
			->setCellValue('E1', '订单总数')
			->setCellValue('F1', $orders_info[2])
			->setCellValue('G1', '订单总额')
			->setCellValue('H1', $orders_info[3])
			->setCellValue('I1', '餐品总份')
			->setCellValue('J1', $orders_info[4]);
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A3', '订单号')
            ->setCellValue('B3', '状态')
            ->setCellValue('C3', '配送地址')
			->setCellValue('D3', '联系电话')
			->setCellValue('E3', '送餐时间')
			->setCellValue('F3', '嘱咐')
			->setCellValue('G3', '订单总价')
			->setCellValue('H3', '下单时间')
			->setCellValue('I3', '餐店名称')
			->setCellValue('J3', '餐品名称')
			->setCellValue('K3', '餐品数量')
            ->setCellValue('L3', '餐品总价');

        $objActSheet = $objPHPExcel->getActiveSheet();
		$objActSheet->getColumnDimension('A')->setWidth(10);   
		$objActSheet->getColumnDimension('B')->setWidth(10);
		$objActSheet->getColumnDimension('C')->setWidth(20);
		$objActSheet->getColumnDimension('D')->setWidth(15);
		$objActSheet->getColumnDimension('E')->setWidth(12); 
		$objActSheet->getColumnDimension('F')->setWidth(20); 
		$objActSheet->getColumnDimension('G')->setWidth(10); 
		$objActSheet->getColumnDimension('H')->setWidth(30); 
		$objActSheet->getColumnDimension('I')->setWidth(20); 
		$objActSheet->getColumnDimension('J')->setWidth(20);
		$objActSheet->getColumnDimension('H')->setWidth(10); 
		$objActSheet->getColumnDimension('K')->setWidth(10); 

// Miscellaneous glyphs, UTF-8
foreach ($orders_info['1'] as $i=>$row) 
{
	$i+=$i+4;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $row['orderid']);
	if($row['orderid']!=$mark){
		switch($row['state'])
		{
			case 0:$statev="未打印";break;
			case 1:$statev="已打印";break;
			case 2:$statev="TEL";break;
			case 3:$statev="成交";break;
			case 4:$statev="未成交";break;
			case 5:$statev="打印未成交";break;
		}
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $row['orderid'])
		            ->setCellValue('B'.$i, $statev)
		            ->setCellValue('C'.$i, iconv('gb2312','utf-8',$row['address']))
		            ->setCellValue('D'.$i, "'".$row['telphone'])
		            ->setCellValue('E'.$i, iconv('gb2312','utf-8',$row['sctime']))
		            ->setCellValue('F'.$i, iconv('gb2312','utf-8',$row['beizhu']))
		            ->setCellValue('G'.$i, $row['total_price'])
		            ->setCellValue('H'.$i, $row['orderdate'])
		            ->setCellValue('I'.$i, iconv('gb2312','utf-8',get_shopname($db,$row['shopid'])));
	}else{
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, '')
		                                    ->setCellValue('B'.$i, '')
											->setCellValue('C'.$i, '')
											->setCellValue('D'.$i, '')
											->setCellValue('E'.$i, '')
											->setCellValue('F'.$i, '')
											->setCellValue('G'.$i, '')
											->setCellValue('H'.$i, '')
											->setCellValue('I'.$i, '');
	}
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$i, iconv('gb2312','utf-8',$row['dinname']))
	                                    ->setCellValue('K'.$i, iconv('gb2312','utf-8',$row['dinnum']))
	                                    ->setCellValue('L'.$i, iconv('gb2312','utf-8',$row['dinprice']));
	$mark=$row['orderid'];
}
	
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=我饿啦外卖报表".$shopname.".xls");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
