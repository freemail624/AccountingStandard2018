<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operating_expense extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
                'Account_class_model',
                'Journal_info_model',
                'Journal_account_model',
                'Users_model',
                'Departments_model',
                'Company_model',
                'Book_type_model'
            )
        );
        $this->load->library('excel');
        $this->load->model('Email_settings_model');

    }

    public function index() {
        $this->Users_model->validate();
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
        $data['title'] = 'Income Statement';

        $data['departments']=$this->Departments_model->get_list('is_deleted=FALSE');
        $data['book_types']=$this->Book_type_model->get_list();
        // $data['income_accounts']=$this->Journal_info_model->get_account_balance(4);
        // $data['expense_accounts']=$this->Journal_info_model->get_account_balance(5);
        (in_array('9-27',$this->session->user_rights)? 
        $this->load->view('operating_expense_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    function transaction($txn)
    {
        switch($txn)
        {

            case 'export-excel':
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;

                $type=$this->input->get('type',TRUE);
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $book_type_id=$this->input->get('bookid',TRUE);

                $book = $this->Book_type_model->get_list($book_type_id);
                $book_type = $book[0]->book_type;

                $sDate = date("Y-m-d",strtotime($start));
                $eDate = date("Y-m-d",strtotime($end));
                $operating_expense_id = 6;

                $m_company=$this->Company_model;
                $company=$m_company->get_list();
                $filename="";

                $book_type_name=$book[0]->book_type_name;

                $start=date("m/d/Y",strtotime($start));
                $end=date("m/d/Y",strtotime($end));

                if($type == 1){
                    $items=$this->Journal_info_model->get_operating_expense($book_type,$sDate,$eDate,$operating_expense_id);
                    $filename = "Operating Expense - ".$book_type_name." (".$start."-".$end.").xlsx";
                }else{
                    $items=$this->Journal_info_model->get_operating_summary($sDate,$eDate,$operating_expense_id);
                    $filename = "Operating Expense Summary (".$start."-".$end.").xlsx";
                }

                $excel=$this->excel;
   

                $excel->setActiveSheetIndex(0);

                // $excel->getActiveSheet()->getColumnDimension('A')
                //                         ->setAutoSize(false)
                //                         ->setWidth('50');

                // $excel->getActiveSheet()->getColumnDimension('B')
                //                         ->setAutoSize(false)
                //                         ->setWidth('25');

                $excel->getActiveSheet()->setTitle('OPEX-'.$book_type_name);

                // $excel->getActiveSheet()
                //         ->mergeCells('B9:B9')
                //         ->setCellValue('A9', 'INCOME')
                //         ->getStyle('A9:B9')->applyFromArray(
                //             array(
                //                 'fill' => array(
                //                     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //                     'color' => array('rgb' => '53C1F0')
                //                 )
                //             )
                //         )->getFont()
                //         ->setItalic(TRUE)
                //         ->setBold(TRUE);

                // $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                // $excel->getActiveSheet()->setCellValue('A6','INCOME STATEMENT - '.$department_name)
                //                         ->setCellValue('A7',$start.' to '.$end);

                // $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                // $excel->getActiveSheet()->getStyle('B9:D9')->getFont()->setBold(TRUE);
                // $excel->getActiveSheet()->getStyle('A7')->getFont()->setItalic(TRUE);

                // $i = 5;

                // foreach($items as $item)
                // {
                //     $i++;

                //     $excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_title);

                // }
                $rowCount1 = 1;
                $column1 = 'A';

                foreach($items[0] as $key => $value)
                {
                 //echo $row1['Field']."<br>"; 
                 $excel->getActiveSheet()->setCellValue($column1.$rowCount1, $key); 
                  
                 $column1++;
                }
                
                //end of adding column names 
                //start foreach loop to get data
                 
                $rowCount = 2;

                foreach($items as $key => $values) 
                {
                 //start of printing column names as names of MySQL fields 
                 $column = 'A';

                 foreach($values as $value) 
                 {

                    // $firstEle = $arr[0];
                    // $lastEle = $arr[count($arr) - 1];

                 //echo $value.'<br>';
                 //echo $column.$rowCount.'<br>';
                 
                 $excel->getActiveSheet()->setCellValue($column.$rowCount, $value);

                 $column++; 
                 } 

                 $rowCount++;
                }

                $rowCount2 = $rowCount;
                $column2 = 'A';
                $lastrow = count($items) + 1;

                foreach($items[0] as $key => $value)
                {
                 //echo $row1['Field']."<br>"; 

                if($column2 == "A"){
                    $excel->getActiveSheet()->setCellValue($column2.$rowCount2, 'Total'); 
                }else{
                    $excel->getActiveSheet()->setCellValue($column2.$rowCount2, "=SUM(".$column2."2:".$column2.$lastrow.")"); 
                }
                  
                 $column2++;
                }


                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$filename);
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;

            case 'export-all':
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;

                $company_info=$m_company->get_list();
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                $dep_id=$this->input->get('depid',TRUE);

                $departments = $this->Departments_model->get_list('is_active = TRUE AND is_deleted  = FALSE');

                $income_accounts = $m_journal->get_account_balance_for_summary_income(4,null,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $expense_accounts = $m_journal->get_account_balance_for_summary_income(5,null,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $excel=$this->excel;
   

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('50');

                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('20');

                $excel->getActiveSheet()->setTitle('Income Statement');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()
                        ->setCellValue('A9', 'INCOME')
                        ->getStyle('A9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                

                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A6','INCOME STATEMENT')
                                        ->setCellValue('A7',$start.' to '.$end);

                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B9:D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A7')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()
                        ->setCellValue('B8', 'ALL Departments')
                        ->getStyle('B8')->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('B9', '')
                        ->getStyle('B9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setBold(TRUE);

                $i = 9;
                $income_total=0;
                $total_net = 0;
                foreach($income_accounts as $income_account)
                {
                    $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_title);
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($income_account->account_balance,2))
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $income_total+=$income_account->account_balance;

                }

                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Income:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($income_total,2))
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $i+=2;

                $excel->getActiveSheet()
                        ->mergeCells('A'.$i.':'.'B'.$i)
                        ->setCellValue('A'.$i, 'EXPENSE')
                        ->getStyle('A'.$i.':'.'B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                $expense_total = 0;
                foreach($expense_accounts as $expense_account)
                {
                    $i++;

                    $excel->getActiveSheet()
                            ->setCellValue('A'.$i,$expense_account->account_title);

                    $excel->getActiveSheet()
                            ->setCellValue('B'.$i,number_format($expense_account->account_balance,2))
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $expense_total+=$expense_account->account_balance;
                }

                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Expense:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($expense_total,2))
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $total_net = $income_total - $expense_total;

                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i, 'NET INCOME:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i, number_format($total_net,2))
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);



                $a = 'c';  
                foreach ($departments as $department) {

                    $excel->getActiveSheet()->getColumnDimension($a)
                                        ->setAutoSize(false)
                                        ->setWidth('20');         


                    $income_accounts = $m_journal->get_account_balance_for_summary_income(4,$department->department_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                    $expense_accounts = $m_journal->get_account_balance_for_summary_income(5,$department->department_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));

                    $i = 9;
                    $income_total=0;
                    $total_net = 0;


                    $excel->getActiveSheet()
                            ->setCellValue($a.''.$i, '')
                            ->getStyle($a.''.$i)->applyFromArray(
                                array(
                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array('rgb' => '53C1F0')
                                    )
                                )
                            )->getFont()
                            ->setBold(TRUE);                                                   

                    $excel->getActiveSheet()->setCellValue($a.'8', $department->department_name)->getStyle($a.'8')->getFont()->setBold(TRUE); 

                            foreach($income_accounts as $income_account)
                            {
                                $i++;
                                $excel->getActiveSheet()->setCellValue($a.''.$i,number_format($income_account->account_balance,2))
                                        ->getStyle($a.''.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                                $income_total+=$income_account->account_balance;

                            }

                            $i++;

                            $excel->getActiveSheet()->setCellValue($a.''.$i,number_format($income_total,2))
                                                    ->getStyle($a.''.$i)
                                                    ->getFont()
                                                    ->setBold(TRUE)
                                                    ->getActiveSheet()
                                                    ->getStyle($a.''.$i)
                                                    ->getAlignment()
                                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $i+=2;
                            
                            $excel->getActiveSheet()
                                    ->setCellValue($a.''.$i, '')
                                    ->getStyle($a.''.$i)->applyFromArray(
                                        array(
                                            'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('rgb' => '53C1F0')
                                            )
                                        )
                                    )->getFont()
                                    ->setBold(TRUE);   

                            $expense_total = 0;
                            foreach($expense_accounts as $expense_account)
                            {
                                $i++;

                                $excel->getActiveSheet()
                                        ->setCellValue($a.''.$i,number_format($expense_account->account_balance,2))
                                        ->getStyle($a.''.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                                $expense_total+=$expense_account->account_balance;
                            }

                            $i++;

                            $excel->getActiveSheet()->setCellValue($a.''.$i,number_format($expense_total,2))
                                                    ->getStyle($a.''.$i)
                                                    ->getFont()
                                                    ->setBold(TRUE)
                                                    ->getActiveSheet()
                                                    ->getStyle($a.''.$i)
                                                    ->getAlignment()
                                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $total_net = $income_total - $expense_total;

                            $i++;

                            $excel->getActiveSheet()->setCellValue($a.''.$i, number_format($total_net,2))
                                                    ->getStyle($a.''.$i)
                                                    ->getFont()
                                                    ->setBold(TRUE)
                                                    ->getActiveSheet()
                                                    ->getStyle($a.''.$i)
                                                    ->getAlignment()
                                                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $a++;
                }





                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Income Statement '.date('Y-m-d',strtotime($end)).'.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                break;                

                case 'email-excel':
                $m_journal = $this->Journal_info_model;
                $m_company=$this->Company_model;
                
                $m_email=$this->Email_settings_model;
                $filter_value = 2;
                $email=$m_email->get_list(2);    

                $company_info=$m_company->get_list();
                $start=$this->input->get('start',TRUE);
                $end=$this->input->get('end',TRUE);
                if($dep_id == 1){$dep_id=null;}
                $income_accounts = $m_journal->get_account_balance(4,$dep_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));
                $expense_accounts = $m_journal->get_account_balance(5,$dep_id,date("Y-m-d",strtotime($start)),date("Y-m-d",strtotime($end)));

                $excel=$this->excel;

                ob_start();
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimension('A')
                                        ->setAutoSize(false)
                                        ->setWidth('50');

                $excel->getActiveSheet()->getColumnDimension('B')
                                        ->setAutoSize(false)
                                        ->setWidth('25');

                $excel->getActiveSheet()->setTitle('Income Statement');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->mobile_no);

                $excel->getActiveSheet()
                        ->mergeCells('A9:B9')
                        ->setCellValue('A9', 'INCOME')
                        ->getStyle('A9:B9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                

                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A6','INCOME STATEMENT')
                                        ->setCellValue('A7',$start.' to '.$end);

                $excel->getActiveSheet()->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('B9:D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->getStyle('A7')->getFont()->setItalic(TRUE);

                $i = 9;
                $income_total=0;
                $total_net = 0;
                foreach($income_accounts as $income_account)
                {
                    $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_title);
                    $excel->getActiveSheet()->setCellValue('B'.$i,number_format($income_account->account_balance,2))
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $income_total+=$income_account->account_balance;

                }

                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Income:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($income_total,2))
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $i+=2;

                $excel->getActiveSheet()
                        ->mergeCells('A'.$i.':'.'B'.$i)
                        ->setCellValue('A'.$i, 'EXPENSE')
                        ->getStyle('A'.$i.':'.'B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '53C1F0')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                $expense_total = 0;
                foreach($expense_accounts as $expense_account)
                {
                    $i++;

                    $excel->getActiveSheet()
                            ->setCellValue('A'.$i,$expense_account->account_title);

                    $excel->getActiveSheet()
                            ->setCellValue('B'.$i,number_format($expense_account->account_balance,2))
                            ->getStyle('B'.$i)
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $expense_total+=$expense_account->account_balance;
                }

                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Total Expense:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i,number_format($expense_total,2))
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $total_net = $income_total - $expense_total;

                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i, 'NET INCOME:')
                                        ->getStyle('A'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('A'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->setCellValue('B'.$i, number_format($total_net,2))
                                        ->getStyle('B'.$i)
                                        ->getFont()
                                        ->setBold(TRUE)
                                        ->getActiveSheet()
                                        ->getStyle('B'.$i)
                                        ->getAlignment()
                                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Income Statement '.date('Y-m-d',strtotime($end)).'.xlsx"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
                $objWriter->save('php://output');
                $data = ob_get_clean();

                          $file_name='Income Statement '.date('Y-m-d h:i:A', now());
                            $excelFilePath = $file_name.".xlsx"; //generate filename base on id
                            //download it.
                            // Set SMTP Configuration
                            $emailConfig = array(
                                'protocol' => 'smtp', 
                                'smtp_host' => 'ssl://smtp.googlemail.com', 
                                'smtp_port' => 465, 
                                'smtp_user' => $email[0]->email_address, 
                                'smtp_pass' => $email[0]->password, 
                                'mailtype' => 'html', 
                                'charset' => 'iso-8859-1'
                            );

                            // Set your email information
                            
                            $from = array(
                                'email' => $email[0]->email_address,
                                'name' => $email[0]->name_from
                            );

                            $to = array($email[0]->email_to);
                            $subject = 'Income Statement';
                          //  $message = 'Type your gmail message here';
                            $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());

                            // Load CodeIgniter Email library
                            $this->load->library('email', $emailConfig);
                            // Sometimes you have to set the new line character for better result
                            $this->email->set_newline("\r\n");
                            // Set email preferences
                            $this->email->from($from['email'], $from['name']);
                            $this->email->to($to);
                            $this->email->subject($subject);
                            $this->email->message($message);
                            $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                            $this->email->set_mailtype("html");
                            // Ready to send email and check whether the email was successfully sent
                            if (!$this->email->send()) {
                                // Raise error message
                            $response['title']='Try Again!';
                            $response['stat']='error';
                            $response['msg']='Please check the Email Address of your Supplier or your Internet Connection.';

                            echo json_encode($response);
                            } else {
                                // Show success notification or other things here
                            $response['title']='Success!';
                            $response['stat']='success';
                            $response['msg']='Email Sent successfully.';

                            echo json_encode($response);
                            }
                break;
        }
    }
}
