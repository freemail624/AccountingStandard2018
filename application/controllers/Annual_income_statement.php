<?php
	defined('BASEPATH') OR exit('No direct script access allowed.');

	class Annual_income_statement extends CORE_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->validate_session();
			$this->load->library('excel');
			$this->load->model(
				array(
	                'Account_class_model',
	                'Journal_info_model',
	                'Journal_account_model',
	                'Departments_model',
	                'Users_model',
	                'Company_model',
                    'Email_settings_model'

            	)
			);
		}

		public function index()
		{	$this->Users_model->validate();
			$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Annual Income Statement';

	        $data['income_accounts']=$this->Journal_info_model->get_annual_income_statement(4);
	        $data['expense_accounts']=$this->Journal_info_model->get_annual_income_statement(5);
        (in_array('9-9',$this->session->user_rights)? 
        $this->load->view('annual_income_statement_view',$data)
        :redirect(base_url('dashboard')));
	        
		}

		function Report() 
		{
			$m_company_info = $this->Company_model;
			$company_info=$m_company_info->get_list();

			$data['company_info']=$company_info[0];
			$data['income_accounts']=$this->Journal_info_model->get_annual_income_statement(4);
	        $data['expense_accounts']=$this->Journal_info_model->get_annual_income_statement(5);

	        $this->load->view('template/annual_income_statement_report',$data);
		}

		function Export()
		{
			$m_company_info = $this->Company_model;
			$company_info=$m_company_info->get_list();
			$income_accounts=$this->Journal_info_model->get_annual_income_statement(4);
	        $expense_accounts=$this->Journal_info_model->get_annual_income_statement(5);

	        $excel=$this->excel;

	        $excel->setActiveSheetIndex(0);
            ob_start();
	        $excel->getActiveSheet()->getColumnDimension('A')
                                    ->setAutoSize(false)
                                    ->setWidth('10');

            $excel->getActiveSheet()->getColumnDimension('B')
                                    ->setAutoSize(false)
                                    ->setWidth('40');

            $excel->getActiveSheet()->getColumnDimension('C') //January
                                    ->setAutoSize(false)
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('D') //February
                                    ->setAutoSize(false)
                                    ->setWidth('30');    

			$excel->getActiveSheet()->getColumnDimension('E') //March
                                    ->setAutoSize(false)
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('F') //April
                                    ->setAutoSize(false)
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('G') //May
                                    ->setAutoSize(false)
                                    ->setWidth('30');
			
			$excel->getActiveSheet()->getColumnDimension('H') //June
                                    ->setAutoSize(false)
                                    ->setWidth('30');

			$excel->getActiveSheet()->getColumnDimension('I') //July
                                    ->setAutoSize(false) 
                                    ->setWidth('30');   

            $excel->getActiveSheet()->getColumnDimension('J') //August
                                    ->setAutoSize(false) 
                                    ->setWidth('30');           

            $excel->getActiveSheet()->getColumnDimension('K') //September
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('L') //October
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

           	$excel->getActiveSheet()->getColumnDimension('M') //November
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('N') //December
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

            $excel->getActiveSheet()->setTitle('Annual Income Statement');

            $excel->getActiveSheet()
            	  ->mergeCells('A1:N1')
            	  ->getStyle('A1')
	                ->getAlignment()
	                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	              ->getActiveSheet()
            	  ->getStyle('A1')
            	  	->getFont()
            	  	->setSize(18)
	              ->getActiveSheet()
            	  ->mergeCells('A2:N2')
            	  ->getStyle('A2')
	                ->getAlignment()
	                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	              ->getActiveSheet()
            	  ->mergeCells('A3:N3')
            	  ->getStyle('A3')
	                ->getAlignment()
	                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	              ->getActiveSheet()
            	  ->mergeCells('A4:N4')
            	  ->getStyle('A4')
	                ->getAlignment()
	                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	              ->getActiveSheet()
            	  ->mergeCells('A5:N5')
            	  ->getStyle('A5')
	                ->getAlignment()
	                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	              ->getActiveSheet()
            	  ->mergeCells('A6:N6')
            	  ->getStyle('A6')
	                ->getAlignment()
	                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
	              ->getActiveSheet()
            	  ->getStyle('A1')
            	  	->getFont()
            	  	->setSize(18)
	              ->getActiveSheet()
            	  ->mergeCells('A7:N7')
            	  ->getStyle('A7')
	                ->getAlignment()
	                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                    ->setCellValue('A2',$company_info[0]->company_address)
                                    ->setCellValue('A3',$company_info[0]->email_address)
                                    ->setCellValue('A4',$company_info[0]->mobile_no)
                                    ->setCellValue('A6','ANNUAL INCOME STATEMENT')
                                    ->setCellValue('A7',date('Y'));

            $excel->getActiveSheet()->setCellValue('A8','Account #')
            						->getStyle('A8')
            						->getFont()
                                    ->setBold(TRUE)
					  ->getActiveSheet()->setCellValue('B8','Account Description')
					  ->getStyle('B8')
						->getFont()
	                    ->setBold(TRUE)
				      ->getActiveSheet()->setCellValue('C8','JANUARY')
				      ->getStyle('C8')
						->getFont()
                        ->setBold(TRUE)
	        		  ->getActiveSheet()->setCellValue('D8','FEBRUARY')
	        		  ->getStyle('D8')
						->getFont()
                        ->setBold(TRUE)
	            	  ->getActiveSheet()->setCellValue('E8','MARCH')
	            	  ->getStyle('E8')
						->getFont()
                        ->setBold(TRUE)
	            	  ->getActiveSheet()->setCellValue('F8','APRIL')
	            	  ->getStyle('F8')
						->getFont()
                        ->setBold(TRUE)
	            	  ->getActiveSheet()->setCellValue('G8','MAY')
	            	  ->getStyle('G8')
						->getFont()
                        ->setBold(TRUE)
					  ->getActiveSheet()->setCellValue('H8','JUNE')
					  ->getStyle('H8')
						->getFont()
                        ->setBold(TRUE)
					->getActiveSheet()->setCellValue('I8','JULY')
					->getStyle('I8')
						->getFont()
                        ->setBold(TRUE)
					->getActiveSheet()->setCellValue('J8','AUGUST')
					->getStyle('J8')
						->getFont()
                        ->setBold(TRUE)
					->getActiveSheet()->setCellValue('K8','SEPTEMBER')
					->getStyle('K8')
						->getFont()
                        ->setBold(TRUE)
					->getActiveSheet()->setCellValue('L8','OCTOBER')
					->getStyle('L8')
						->getFont()
                        ->setBold(TRUE)
					->getActiveSheet()->setCellValue('M8','NOVEMBER')
					->getStyle('M8')
						->getFont()
                        ->setBold(TRUE)
					->getActiveSheet()->setCellValue('N8','DECEMBER')
					->getStyle('N8')
						->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A9','INCOME')->mergeCells('A9:N9')
            	 	  ->getStyle('A9')
	                  ->getAlignment()
	                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()
                        ->getStyle('A9:B9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '0c7cd6')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                $i = 9;
                $jan_inc_bal=0; 
                $feb_inc_bal=0;
                $mar_inc_bal=0;
                $apr_inc_bal=0;
                $may_inc_bal=0;
                $jun_inc_bal=0;
                $jul_inc_bal=0;
                $aug_inc_bal=0;
                $sep_inc_bal=0;
                $oct_inc_bal=0;
                $nov_inc_bal=0;
                $dec_inc_bal=0;
                foreach($income_accounts as $income_account)
                {
                	$i++;

                	$excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_no)
                							->setCellValue('B'.$i,$income_account->account_title)
                							->setCellValue('C'.$i,$income_account->core_jan_balance)
                							->getStyle('C'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('D'.$i,$income_account->core_feb_balance)
                							->getStyle('D'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('E'.$i,$income_account->core_mar_balance)
                							->getStyle('E'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('F'.$i,$income_account->core_apr_balance)
                							->getStyle('F'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('G'.$i,$income_account->core_may_balance)
                							->getStyle('G'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('H'.$i,$income_account->core_jun_balance)
                							->getStyle('H'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('I'.$i,$income_account->core_jul_balance)
                							->getStyle('I'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('J'.$i,$income_account->core_aug_balance)
                							->getStyle('J'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('K'.$i,$income_account->core_sep_balance)
                							->getStyle('K'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('L'.$i,$income_account->core_oct_balance)
                							->getStyle('L'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('M'.$i,$income_account->core_nov_balance)
                							->getStyle('M'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('N'.$i,$income_account->core_dec_balance)
                							->getStyle('N'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');

						    $jan_inc_bal+=$income_account->core_jan_balance; 
                            $feb_inc_bal+=$income_account->core_feb_balance;
                            $mar_inc_bal+=$income_account->core_mar_balance;
                            $apr_inc_bal+=$income_account->core_apr_balance; 
                            $may_inc_bal+=$income_account->core_may_balance;
                            $jun_inc_bal+=$income_account->core_jun_balance;
                            $jul_inc_bal+=$income_account->core_jul_balance; 
                            $aug_inc_bal+=$income_account->core_aug_balance;
                            $sep_inc_bal+=$income_account->core_sep_balance;
                            $oct_inc_bal+=$income_account->core_oct_balance; 
                            $nov_inc_bal+=$income_account->core_nov_balance;
                            $dec_inc_bal+=$income_account->core_dec_balance;           
                }

          	$i++;

            $total_income_row = $i;
            $lastrow_income = count($income_accounts) + 9;

          	$excel->getActiveSheet()->setCellValue('A'.$i,'')
                							->setCellValue('B'.$i,'Total Income:')
                							->setCellValue('C'.$i, "=SUM(C10:C".$lastrow_income.")")
                							->getStyle('C'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('D'.$i,"=SUM(D10:D".$lastrow_income.")")
                							->getStyle('D'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('E'.$i,"=SUM(E10:E".$lastrow_income.")")
                							->getStyle('E'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('F'.$i,"=SUM(F10:F".$lastrow_income.")")
                							->getStyle('F'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('G'.$i,"=SUM(G10:G".$lastrow_income.")")
                							->getStyle('G'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('H'.$i,"=SUM(H10:H".$lastrow_income.")")
                							->getStyle('H'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('I'.$i,"=SUM(I10:I".$lastrow_income.")")
                							->getStyle('I'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('J'.$i,"=SUM(J10:J".$lastrow_income.")")
                							->getStyle('J'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('K'.$i,"=SUM(K10:K".$lastrow_income.")")
                							->getStyle('K'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('L'.$i,"=SUM(L10:L".$lastrow_income.")")
                							->getStyle('L'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('M'.$i,"=SUM(M10:M".$lastrow_income.")")
                							->getStyle('M'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('N'.$i,"=SUM(N10:N".$lastrow_income.")")
                							->getStyle('N'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');
	        $i++;

            $first_row_expense = $i+1;

            $excel->getActiveSheet()->setCellValue('A'.$i,'EXPENSE')->mergeCells('A'.$i.':'.'N'.$i)
            	 	  ->getStyle('A'.$i)
	                  ->getAlignment()
	                  ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()
                        ->getStyle('A'.$i.':'.'B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '0c7cd6')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

            // $i++;

                $jan_exp_bal=0; 
	            $feb_exp_bal=0;
	            $mar_exp_bal=0;
	            $apr_exp_bal=0;
	            $may_exp_bal=0;
	            $jun_exp_bal=0;
	            $jul_exp_bal=0;
	            $aug_exp_bal=0;
	            $sep_exp_bal=0;
	            $oct_exp_bal=0;
	            $nov_exp_bal=0;
	            $dec_exp_bal=0;
                foreach($expense_accounts as $expense_account)
                {
                	$i++;

                	$excel->getActiveSheet()->setCellValue('A'.$i,$expense_account->account_no)
                							->setCellValue('B'.$i,$expense_account->account_title)
                							->setCellValue('C'.$i,$expense_account->core_jan_balance)
                							->getStyle('C'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('D'.$i,$expense_account->core_feb_balance)
                							->getStyle('D'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('E'.$i,$expense_account->core_mar_balance)
                							->getStyle('E'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('F'.$i,$expense_account->core_apr_balance)
                							->getStyle('F'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('G'.$i,$expense_account->core_may_balance)
                							->getStyle('G'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('H'.$i,$expense_account->core_jun_balance)
                							->getStyle('H'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('I'.$i,$expense_account->core_jul_balance)
                							->getStyle('I'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('J'.$i,$expense_account->core_aug_balance)
                							->getStyle('J'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('K'.$i,$expense_account->core_sep_balance)
                							->getStyle('K'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('L'.$i,$expense_account->core_oct_balance)
                							->getStyle('L'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('M'.$i,$expense_account->core_nov_balance)
                							->getStyle('M'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
						                    ->getActiveSheet()
                							->setCellValue('N'.$i,$expense_account->core_dec_balance)
                							->getStyle('N'.$i)
						                    ->getAlignment()
						                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');

						    $jan_exp_bal+=$expense_account->core_jan_balance; 
                            $feb_exp_bal+=$expense_account->core_feb_balance;
                            $mar_exp_bal+=$expense_account->core_mar_balance;
                            $apr_exp_bal+=$expense_account->core_apr_balance; 
                            $may_exp_bal+=$expense_account->core_may_balance;
                            $jun_exp_bal+=$expense_account->core_jun_balance;
                            $jul_exp_bal+=$expense_account->core_jul_balance; 
                            $aug_exp_bal+=$expense_account->core_aug_balance;
                            $sep_exp_bal+=$expense_account->core_sep_balance;
                            $oct_exp_bal+=$expense_account->core_oct_balance; 
                            $nov_exp_bal+=$expense_account->core_nov_balance;
                            $dec_exp_bal+=$expense_account->core_dec_balance;        
                }

            $i++;

            $total_expense_row = $i;
            $lastrow_expense = (count($expense_accounts) + $first_row_expense) - 1;

          	$excel->getActiveSheet()->setCellValue('A'.$i,'')
				->setCellValue('B'.$i,'Total Expense:')
				->setCellValue('C'.$i,"=SUM(C".$first_row_expense.":C".$lastrow_expense.")")
				->getStyle('C'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('D'.$i,"=SUM(D".$first_row_expense.":D".$lastrow_expense.")")
				->getStyle('D'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('E'.$i,"=SUM(E".$first_row_expense.":E".$lastrow_expense.")")
				->getStyle('E'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('F'.$i,"=SUM(F".$first_row_expense.":F".$lastrow_expense.")")
				->getStyle('F'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('G'.$i,"=SUM(G".$first_row_expense.":G".$lastrow_expense.")")
				->getStyle('G'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('H'.$i,"=SUM(H".$first_row_expense.":H".$lastrow_expense.")")
				->getStyle('H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('I'.$i,"=SUM(I".$first_row_expense.":I".$lastrow_expense.")")
				->getStyle('I'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('J'.$i,"=SUM(J".$first_row_expense.":J".$lastrow_expense.")")
				->getStyle('J'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('K'.$i,"=SUM(K".$first_row_expense.":K".$lastrow_expense.")")
				->getStyle('K'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('L'.$i,"=SUM(L".$first_row_expense.":L".$lastrow_expense.")")
				->getStyle('L'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('M'.$i,"=SUM(M".$first_row_expense.":M".$lastrow_expense.")")
				->getStyle('M'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('N'.$i,"=SUM(N".$first_row_expense.":N".$lastrow_expense.")")
				->getStyle('N'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                    ->setFormatCode('###,##0.00;(###,##0.00)');
            $i++;

            $jan_ni_bal=$jan_inc_bal - $jan_exp_bal;
            $feb_ni_bal=$feb_inc_bal - $feb_exp_bal;
            $mar_ni_bal=$mar_inc_bal - $mar_exp_bal;
            $apr_ni_bal=$apr_inc_bal - $apr_exp_bal;
            $may_ni_bal=$may_inc_bal - $may_exp_bal;
            $jun_ni_bal=$jun_inc_bal - $jun_exp_bal;
            $jul_ni_bal=$jul_inc_bal - $jul_exp_bal;
            $aug_ni_bal=$aug_inc_bal - $aug_exp_bal;
            $sep_ni_bal=$sep_inc_bal - $sep_exp_bal;
            $oct_ni_bal=$oct_inc_bal - $oct_exp_bal;
            $nov_ni_bal=$nov_inc_bal - $nov_exp_bal;
            $dec_ni_bal=$dec_inc_bal - $dec_exp_bal;

            $excel->getActiveSheet()->setCellValue('A'.$i,'')
				->setCellValue('B'.$i,'Net Income:')
				->setCellValue('C'.$i,"=SUM(C".$total_income_row."-C".$total_expense_row.")")
				->getStyle('C'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('D'.$i,"=SUM(D".$total_income_row."-D".$total_expense_row.")")
				->getStyle('D'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('E'.$i,"=SUM(E".$total_income_row."-E".$total_expense_row.")")
				->getStyle('E'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('F'.$i,"=SUM(F".$total_income_row."-F".$total_expense_row.")")
				->getStyle('F'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('G'.$i,"=SUM(G".$total_income_row."-G".$total_expense_row.")")
				->getStyle('G'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('H'.$i,"=SUM(H".$total_income_row."-H".$total_expense_row.")")
				->getStyle('H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('I'.$i,"=SUM(I".$total_income_row."-I".$total_expense_row.")")
				->getStyle('I'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('J'.$i,"=SUM(J".$total_income_row."-J".$total_expense_row.")")
				->getStyle('J'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('K'.$i,"=SUM(K".$total_income_row."-K".$total_expense_row.")")
				->getStyle('K'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('L'.$i,"=SUM(L".$total_income_row."-L".$total_expense_row.")")
				->getStyle('L'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('M'.$i,"=SUM(M".$total_income_row."-M".$total_expense_row.")")
				->getStyle('M'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
				->setCellValue('N'.$i,"=SUM(N".$total_income_row."-N".$total_expense_row.")")
				->getStyle('N'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)');

            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Annual Income Statement '.date('Y').'.xlsx"');
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


            //     $send = $this->input->get('send');
            //         if($send == "true")    

            //     {
            //     $data = ob_get_contents();
            //     ob_end_clean();
            //         $m_email=$this->Email_settings_model;
            //                     $email=$m_email->get_list(2);
            //                     $file_name='Annual Income Statement '.date('Y-m-d h:i:A', now());
            //                     $excelFilePath = $file_name.".xlsx"; 
            //                     $emailConfig = array(
            //                         'protocol' => 'smtp', 
            //                         'smtp_host' => 'ssl://smtp.googlemail.com', 
            //                         'smtp_port' => 465, 
            //                         'smtp_user' => $email[0]->email_address, 
            //                         'smtp_pass' => $email[0]->password, 
            //                         'mailtype' => 'html', 
            //                         'charset' => 'iso-8859-1'
            //                     );
            //                     $from = array(
            //                         'email' => $email[0]->email_address,
            //                         'name' => $email[0]->name_from
            //                     );
            //                     $to = array($email[0]->email_to);
            //                     $subject = 'Annual Income Statement';
            //                     $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>' .date('Y-m-d h:i:A', now());
            //                     $this->load->library('email', $emailConfig);
            //                     $this->email->set_newline("\r\n");
            //                     $this->email->from($from['email'], $from['name']);
            //                     $this->email->to($to);
            //                     $this->email->subject($subject);
            //                     $this->email->message($message);
            //                     $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
            //                     $this->email->set_mailtype("html");
            //                     if (!$this->email->send()) {
            //                     $response['title']='Try Again!';
            //                     $response['stat']='error';
            //                     $response['msg']='Please check the Email Address or your Internet Connection.';
            //                     } else {
            //                     $response['title']='Success!';
            //                     $response['stat']='success';
            //                     $response['msg']='Email Sent successfully.';
            //                     }
            //                     echo json_encode($response);};

            // echo json_encode($send);
		}


        function Email()
        {
            $m_company_info = $this->Company_model;
            $company_info=$m_company_info->get_list();
            $income_accounts=$this->Journal_info_model->get_annual_income_statement(4);
            $expense_accounts=$this->Journal_info_model->get_annual_income_statement(5);

            $excel=$this->excel;

            $excel->setActiveSheetIndex(0);
            ob_start();
            $excel->getActiveSheet()->getColumnDimension('A')
                                    ->setAutoSize(false)
                                    ->setWidth('10');

            $excel->getActiveSheet()->getColumnDimension('B')
                                    ->setAutoSize(false)
                                    ->setWidth('40');

            $excel->getActiveSheet()->getColumnDimension('C') //January
                                    ->setAutoSize(false)
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('D') //February
                                    ->setAutoSize(false)
                                    ->setWidth('30');    

            $excel->getActiveSheet()->getColumnDimension('E') //March
                                    ->setAutoSize(false)
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('F') //April
                                    ->setAutoSize(false)
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('G') //May
                                    ->setAutoSize(false)
                                    ->setWidth('30');
            
            $excel->getActiveSheet()->getColumnDimension('H') //June
                                    ->setAutoSize(false)
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('I') //July
                                    ->setAutoSize(false) 
                                    ->setWidth('30');   

            $excel->getActiveSheet()->getColumnDimension('J') //August
                                    ->setAutoSize(false) 
                                    ->setWidth('30');           

            $excel->getActiveSheet()->getColumnDimension('K') //September
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('L') //October
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('M') //November
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

            $excel->getActiveSheet()->getColumnDimension('N') //December
                                    ->setAutoSize(false) 
                                    ->setWidth('30');

            $excel->getActiveSheet()->setTitle('Annual Income Statement');

            $excel->getActiveSheet()
                  ->mergeCells('A1:N1')
                  ->getStyle('A1')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                  ->getActiveSheet()
                  ->getStyle('A1')
                    ->getFont()
                    ->setSize(18)
                  ->getActiveSheet()
                  ->mergeCells('A2:N2')
                  ->getStyle('A2')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                  ->getActiveSheet()
                  ->mergeCells('A3:N3')
                  ->getStyle('A3')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                  ->getActiveSheet()
                  ->mergeCells('A4:N4')
                  ->getStyle('A4')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                  ->getActiveSheet()
                  ->mergeCells('A5:N5')
                  ->getStyle('A5')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                  ->getActiveSheet()
                  ->mergeCells('A6:N6')
                  ->getStyle('A6')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                  ->getActiveSheet()
                  ->getStyle('A1')
                    ->getFont()
                    ->setSize(18)
                  ->getActiveSheet()
                  ->mergeCells('A7:N7')
                  ->getStyle('A7')
                    ->getAlignment()
                    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


            $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                    ->setCellValue('A2',$company_info[0]->company_address)
                                    ->setCellValue('A3',$company_info[0]->email_address)
                                    ->setCellValue('A4',$company_info[0]->mobile_no)
                                    ->setCellValue('A6','ANNUAL INCOME STATEMENT')
                                    ->setCellValue('A7',date('Y'));

            $excel->getActiveSheet()->setCellValue('A8','Account #')
                                    ->getStyle('A8')
                                    ->getFont()
                                    ->setBold(TRUE)
                      ->getActiveSheet()->setCellValue('B8','Account Description')
                      ->getStyle('B8')
                        ->getFont()
                        ->setBold(TRUE)
                      ->getActiveSheet()->setCellValue('C8','JANUARY')
                      ->getStyle('C8')
                        ->getFont()
                        ->setBold(TRUE)
                      ->getActiveSheet()->setCellValue('D8','FEBRUARY')
                      ->getStyle('D8')
                        ->getFont()
                        ->setBold(TRUE)
                      ->getActiveSheet()->setCellValue('E8','MARCH')
                      ->getStyle('E8')
                        ->getFont()
                        ->setBold(TRUE)
                      ->getActiveSheet()->setCellValue('F8','APRIL')
                      ->getStyle('F8')
                        ->getFont()
                        ->setBold(TRUE)
                      ->getActiveSheet()->setCellValue('G8','MAY')
                      ->getStyle('G8')
                        ->getFont()
                        ->setBold(TRUE)
                      ->getActiveSheet()->setCellValue('H8','JUNE')
                      ->getStyle('H8')
                        ->getFont()
                        ->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('I8','JULY')
                    ->getStyle('I8')
                        ->getFont()
                        ->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('J8','AUGUST')
                    ->getStyle('J8')
                        ->getFont()
                        ->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('K8','SEPTEMBER')
                    ->getStyle('K8')
                        ->getFont()
                        ->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('L8','OCTOBER')
                    ->getStyle('L8')
                        ->getFont()
                        ->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('M8','NOVEMBER')
                    ->getStyle('M8')
                        ->getFont()
                        ->setBold(TRUE)
                    ->getActiveSheet()->setCellValue('N8','DECEMBER')
                    ->getStyle('N8')
                        ->getFont()
                        ->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A9','INCOME')->mergeCells('A9:N9')
                      ->getStyle('A9')
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                $excel->getActiveSheet()
                        ->getStyle('A9:B9')->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '0c7cd6')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

                $i = 9;
                $jan_inc_bal=0; 
                $feb_inc_bal=0;
                $mar_inc_bal=0;
                $apr_inc_bal=0;
                $may_inc_bal=0;
                $jun_inc_bal=0;
                $jul_inc_bal=0;
                $aug_inc_bal=0;
                $sep_inc_bal=0;
                $oct_inc_bal=0;
                $nov_inc_bal=0;
                $dec_inc_bal=0;
                foreach($income_accounts as $income_account)
                {
                    $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,$income_account->account_no)
                                            ->setCellValue('B'.$i,$income_account->account_title)
                                            ->setCellValue('C'.$i,$income_account->core_jan_balance)
                                            ->getStyle('C'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('D'.$i,$income_account->core_feb_balance)
                                            ->getStyle('D'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('E'.$i,$income_account->core_mar_balance)
                                            ->getStyle('E'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('F'.$i,$income_account->core_apr_balance)
                                            ->getStyle('F'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('G'.$i,$income_account->core_may_balance)
                                            ->getStyle('G'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('H'.$i,$income_account->core_jun_balance)
                                            ->getStyle('H'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('I'.$i,$income_account->core_jul_balance)
                                            ->getStyle('I'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('J'.$i,$income_account->core_aug_balance)
                                            ->getStyle('J'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('K'.$i,$income_account->core_sep_balance)
                                            ->getStyle('K'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('L'.$i,$income_account->core_oct_balance)
                                            ->getStyle('L'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('M'.$i,$income_account->core_nov_balance)
                                            ->getStyle('M'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('N'.$i,$income_account->core_dec_balance)
                                            ->getStyle('N'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');

                            $jan_inc_bal+=$income_account->core_jan_balance; 
                            $feb_inc_bal+=$income_account->core_feb_balance;
                            $mar_inc_bal+=$income_account->core_mar_balance;
                            $apr_inc_bal+=$income_account->core_apr_balance; 
                            $may_inc_bal+=$income_account->core_may_balance;
                            $jun_inc_bal+=$income_account->core_jun_balance;
                            $jul_inc_bal+=$income_account->core_jul_balance; 
                            $aug_inc_bal+=$income_account->core_aug_balance;
                            $sep_inc_bal+=$income_account->core_sep_balance;
                            $oct_inc_bal+=$income_account->core_oct_balance; 
                            $nov_inc_bal+=$income_account->core_nov_balance;
                            $dec_inc_bal+=$income_account->core_dec_balance;           
                }

            $i++;

            $total_income_row = $i;
            $lastrow_income = count($income_accounts) + 9;

            $excel->getActiveSheet()->setCellValue('A'.$i,'')
                                            ->setCellValue('B'.$i,'Total Income:')
                                            ->setCellValue('C'.$i, "=SUM(C10:C".$lastrow_income.")")
                                            ->getStyle('C'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('D'.$i,"=SUM(D10:D".$lastrow_income.")")
                                            ->getStyle('D'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('E'.$i,"=SUM(E10:E".$lastrow_income.")")
                                            ->getStyle('E'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('F'.$i,"=SUM(F10:F".$lastrow_income.")")
                                            ->getStyle('F'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('G'.$i,"=SUM(G10:G".$lastrow_income.")")
                                            ->getStyle('G'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('H'.$i,"=SUM(H10:H".$lastrow_income.")")
                                            ->getStyle('H'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('I'.$i,"=SUM(I10:I".$lastrow_income.")")
                                            ->getStyle('I'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('J'.$i,"=SUM(J10:J".$lastrow_income.")")
                                            ->getStyle('J'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('K'.$i,"=SUM(K10:K".$lastrow_income.")")
                                            ->getStyle('K'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('L'.$i,"=SUM(L10:L".$lastrow_income.")")
                                            ->getStyle('L'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('M'.$i,"=SUM(M10:M".$lastrow_income.")")
                                            ->getStyle('M'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('N'.$i,"=SUM(N10:N".$lastrow_income.")")
                                            ->getStyle('N'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');
            $i++;

            $first_row_expense = $i+1;

            $excel->getActiveSheet()->setCellValue('A'.$i,'EXPENSE')->mergeCells('A'.$i.':'.'N'.$i)
                      ->getStyle('A'.$i)
                      ->getAlignment()
                      ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            $excel->getActiveSheet()
                        ->getStyle('A'.$i.':'.'B'.$i)->applyFromArray(
                            array(
                                'fill' => array(
                                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                    'color' => array('rgb' => '0c7cd6')
                                )
                            )
                        )->getFont()
                        ->setItalic(TRUE)
                        ->setBold(TRUE);

            // $i++;

                $jan_exp_bal=0; 
                $feb_exp_bal=0;
                $mar_exp_bal=0;
                $apr_exp_bal=0;
                $may_exp_bal=0;
                $jun_exp_bal=0;
                $jul_exp_bal=0;
                $aug_exp_bal=0;
                $sep_exp_bal=0;
                $oct_exp_bal=0;
                $nov_exp_bal=0;
                $dec_exp_bal=0;
                foreach($expense_accounts as $expense_account)
                {
                    $i++;

                    $excel->getActiveSheet()->setCellValue('A'.$i,$expense_account->account_no)
                                            ->setCellValue('B'.$i,$expense_account->account_title)
                                            ->setCellValue('C'.$i,$expense_account->core_jan_balance)
                                            ->getStyle('C'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('D'.$i,$expense_account->core_feb_balance)
                                            ->getStyle('D'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('E'.$i,$expense_account->core_mar_balance)
                                            ->getStyle('E'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('F'.$i,$expense_account->core_apr_balance)
                                            ->getStyle('F'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('G'.$i,$expense_account->core_may_balance)
                                            ->getStyle('G'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('H'.$i,$expense_account->core_jun_balance)
                                            ->getStyle('H'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('I'.$i,$expense_account->core_jul_balance)
                                            ->getStyle('I'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('J'.$i,$expense_account->core_aug_balance)
                                            ->getStyle('J'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('K'.$i,$expense_account->core_sep_balance)
                                            ->getStyle('K'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('L'.$i,$expense_account->core_oct_balance)
                                            ->getStyle('L'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('M'.$i,$expense_account->core_nov_balance)
                                            ->getStyle('M'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                                            ->getActiveSheet()
                                            ->setCellValue('N'.$i,$expense_account->core_dec_balance)
                                            ->getStyle('N'.$i)
                                            ->getAlignment()
                                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                                    ->setFormatCode('###,##0.00;(###,##0.00)');

                            $jan_exp_bal+=$expense_account->core_jan_balance; 
                            $feb_exp_bal+=$expense_account->core_feb_balance;
                            $mar_exp_bal+=$expense_account->core_mar_balance;
                            $apr_exp_bal+=$expense_account->core_apr_balance; 
                            $may_exp_bal+=$expense_account->core_may_balance;
                            $jun_exp_bal+=$expense_account->core_jun_balance;
                            $jul_exp_bal+=$expense_account->core_jul_balance; 
                            $aug_exp_bal+=$expense_account->core_aug_balance;
                            $sep_exp_bal+=$expense_account->core_sep_balance;
                            $oct_exp_bal+=$expense_account->core_oct_balance; 
                            $nov_exp_bal+=$expense_account->core_nov_balance;
                            $dec_exp_bal+=$expense_account->core_dec_balance;        
                }

            $i++;

            $total_expense_row = $i;
            $lastrow_expense = (count($expense_accounts) + $first_row_expense) - 1;

            $excel->getActiveSheet()->setCellValue('A'.$i,'')
                ->setCellValue('B'.$i,'Total Expense:')
                ->setCellValue('C'.$i,"=SUM(C".$first_row_expense.":C".$lastrow_expense.")")
                ->getStyle('C'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('D'.$i,"=SUM(D".$first_row_expense.":D".$lastrow_expense.")")
                ->getStyle('D'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('E'.$i,"=SUM(E".$first_row_expense.":E".$lastrow_expense.")")
                ->getStyle('E'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('F'.$i,"=SUM(F".$first_row_expense.":F".$lastrow_expense.")")
                ->getStyle('F'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('G'.$i,"=SUM(G".$first_row_expense.":G".$lastrow_expense.")")
                ->getStyle('G'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('H'.$i,"=SUM(H".$first_row_expense.":H".$lastrow_expense.")")
                ->getStyle('H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('I'.$i,"=SUM(I".$first_row_expense.":I".$lastrow_expense.")")
                ->getStyle('I'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('J'.$i,"=SUM(J".$first_row_expense.":J".$lastrow_expense.")")
                ->getStyle('J'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('K'.$i,"=SUM(K".$first_row_expense.":K".$lastrow_expense.")")
                ->getStyle('K'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('L'.$i,"=SUM(L".$first_row_expense.":L".$lastrow_expense.")")
                ->getStyle('L'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('M'.$i,"=SUM(M".$first_row_expense.":M".$lastrow_expense.")")
                ->getStyle('M'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('N'.$i,"=SUM(N".$first_row_expense.":N".$lastrow_expense.")")
                ->getStyle('N'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                    ->setFormatCode('###,##0.00;(###,##0.00)');
            $i++;

            $jan_ni_bal=$jan_inc_bal - $jan_exp_bal;
            $feb_ni_bal=$feb_inc_bal - $feb_exp_bal;
            $mar_ni_bal=$mar_inc_bal - $mar_exp_bal;
            $apr_ni_bal=$apr_inc_bal - $apr_exp_bal;
            $may_ni_bal=$may_inc_bal - $may_exp_bal;
            $jun_ni_bal=$jun_inc_bal - $jun_exp_bal;
            $jul_ni_bal=$jul_inc_bal - $jul_exp_bal;
            $aug_ni_bal=$aug_inc_bal - $aug_exp_bal;
            $sep_ni_bal=$sep_inc_bal - $sep_exp_bal;
            $oct_ni_bal=$oct_inc_bal - $oct_exp_bal;
            $nov_ni_bal=$nov_inc_bal - $nov_exp_bal;
            $dec_ni_bal=$dec_inc_bal - $dec_exp_bal;

            $excel->getActiveSheet()->setCellValue('A'.$i,'')
                ->setCellValue('B'.$i,'Net Income:')
                ->setCellValue('C'.$i,"=SUM(C".$total_income_row."-C".$total_expense_row.")")
                ->getStyle('C'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('D'.$i,"=SUM(D".$total_income_row."-D".$total_expense_row.")")
                ->getStyle('D'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('E'.$i,"=SUM(E".$total_income_row."-E".$total_expense_row.")")
                ->getStyle('E'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('F'.$i,"=SUM(F".$total_income_row."-F".$total_expense_row.")")
                ->getStyle('F'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('G'.$i,"=SUM(G".$total_income_row."-G".$total_expense_row.")")
                ->getStyle('G'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('H'.$i,"=SUM(H".$total_income_row."-H".$total_expense_row.")")
                ->getStyle('H'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('I'.$i,"=SUM(I".$total_income_row."-I".$total_expense_row.")")
                ->getStyle('I'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('J'.$i,"=SUM(J".$total_income_row."-J".$total_expense_row.")")
                ->getStyle('J'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('K'.$i,"=SUM(K".$total_income_row."-K".$total_expense_row.")")
                ->getStyle('K'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('L'.$i,"=SUM(L".$total_income_row."-L".$total_expense_row.")")
                ->getStyle('L'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('M'.$i,"=SUM(M".$total_income_row."-M".$total_expense_row.")")
                ->getStyle('M'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT)
                ->getActiveSheet()
                ->setCellValue('N'.$i,"=SUM(N".$total_income_row."-N".$total_expense_row.")")
                ->getStyle('N'.$i)
                ->getAlignment()
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('C'.$i.':N'.$i)->getNumberFormat()
                                        ->setFormatCode('###,##0.00;(###,##0.00)');
                                        
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Annual Income Statement '.date('Y').'.xlsx"');
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

                $data = ob_get_contents();
                ob_end_clean();
                    $m_email=$this->Email_settings_model;
                                $email=$m_email->get_list(2);
                                $file_name='Annual Income Statement '.date('Y');
                                $excelFilePath = $file_name.".xlsx"; 
                                $emailConfig = array(
                                    'protocol' => 'smtp', 
                                    'smtp_host' => 'ssl://smtp.googlemail.com', 
                                    'smtp_port' => 465, 
                                    'smtp_user' => $email[0]->email_address, 
                                    'smtp_pass' => $email[0]->password, 
                                    'mailtype' => 'html', 
                                    'charset' => 'iso-8859-1'
                                );
                                $from = array(
                                    'email' => $email[0]->email_address,
                                    'name' => $email[0]->name_from
                                );
                                $to = array($email[0]->email_to);
                                $subject = 'Annual Income Statement '.date('Y');
                                $message = '<p>To: ' .$email[0]->email_to. '</p></ br>' .$email[0]->default_message.'</ br><p>Sent By: '. '<b>'.$this->session->user_fullname.'</b>'. '</p></ br>';
                                $this->load->library('email', $emailConfig);
                                $this->email->set_newline("\r\n");
                                $this->email->from($from['email'], $from['name']);
                                $this->email->to($to);
                                $this->email->subject($subject);
                                $this->email->message($message);
                                $this->email->attach($data, 'attachment', $excelFilePath , 'application/ms-excel');
                                $this->email->set_mailtype("html");
                                if (!$this->email->send()) {
                                $response['title']='Try Again!';
                                $response['stat']='error';
                                $response['msg']='Please check the Email Address or your Internet Connection.';
                                } else {
                                $response['title']='Success!';
                                $response['stat']='success';
                                $response['msg']='Email Sent successfully.';
                                }
                                echo json_encode($response);}
	}
?>