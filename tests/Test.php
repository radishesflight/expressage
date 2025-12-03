<?php
require_once __DIR__ . '/../vendor/autoload.php';

$expressInfo = [
    'sender_name' => '张三',
    'sender_phone' => '13800000000',
    'sender_address' => '四川省成都市高新区xx路xx号',
    'receiver_name' => '李四',
    'receiver_phone' => '13900000000',
    'receiver_address' => '北京市朝阳区xx街xx号',
    'tracking_no' => '1234567890123',
    'courier' => '顺丰速运'
];

try {
    // 创建 PDF 对象
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // 设置文档信息
    $pdf->SetCreator('MyApp');
    $pdf->SetAuthor('MyApp');
    $pdf->SetTitle('快递面单');

    // 设置页边距
    $pdf->SetMargins(10, 10, 10);
    $pdf->SetAutoPageBreak(TRUE, 10);

    // 添加一页
    $pdf->AddPage();

    // 使用 courier（不需要额外字体文件）
    $pdf->SetFont('courier', '', 12);

    // 寄件人信息（左侧）
    $pdf->SetXY(10, 20);
    $pdf->MultiCell(90, 50, "Sender: {$expressInfo['sender_name']}\n\nPhone: {$expressInfo['sender_phone']}\n\nAddress: {$expressInfo['sender_address']}", 1, 'L', 0, 0);

    // 收件人信息（右侧）
    $pdf->SetXY(105, 20);
    $pdf->MultiCell(90, 50, "Receiver: {$expressInfo['receiver_name']}\n\nPhone: {$expressInfo['receiver_phone']}\n\nAddress: {$expressInfo['receiver_address']}", 1, 'L', 0, 1);

    // 快递公司
    $pdf->SetXY(10, 75);
    $pdf->SetFont('courier', 'B', 14);
    $pdf->Cell(0, 10, "Courier: {$expressInfo['courier']}", 0, 1);

    // 快递单号
    $pdf->SetXY(10, 90);
    $pdf->SetFont('courier', 'B', 12);
    $pdf->Cell(0, 10, "Tracking No: {$expressInfo['tracking_no']}", 0, 1);

    // 条形码
    $pdf->SetXY(10, 110);
    $pdf->write1DBarcode($expressInfo['tracking_no'], 'C128', '', '', '', 18, 0.4, [], 'N');

    // 输出 PDF 到本地文件
    $outputPath = __DIR__ . '/../output/express.pdf';

    // 如果输出目录不存在，创建它
    $outputDir = dirname($outputPath);
    if (!is_dir($outputDir)) {
        mkdir($outputDir, 0755, true);
    }

    // 保存到本地
    $pdf->Output($outputPath, 'F');
    echo "PDF 已成功保存到：" . $outputPath;

} catch (Exception $e) {
    echo "PDF Error: " . $e->getMessage();
}