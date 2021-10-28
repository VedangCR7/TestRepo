<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Calculate_incentive_report extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('waiting_manager_model');
	}
	
	public function index() {	
		$data['restaurantsidebarshow'] =$this->get_menu_of_restaurant();	
		$this->load->view('employee_incentive_report',$data);
	}
	
	public function calculate_report(){
		$final_data = [];
		if($_POST['usertype'] == 'Restaurant manager'){
			$sql = "SELECT u.name,u.id
			from user as u
			WHERE u.usertype ='".$_POST['usertype']."' AND u.is_active=1 AND u.upline_id=".$_SESSION['user_id'];
			$data = $this->waiting_manager_model->query($sql);
			
			foreach($data as $key=>$value){
				$incentives = $this->waiting_manager_model->select_where('incentive_master',['menu_id!='=>0]);
				$cal_incentive = 0;
				foreach($incentives as $key1=>$value1){
					$sql1 = "SELECT oi.* from order_items as oi LEFT JOIN orders as o on o.id=oi.order_id LEFT JOIN user as u on u.id=o.order_by
					WHERE recipe_id=".$value1['menu_id']." AND usertype='Restaurant manager' AND o.order_by=".$value['id'];
					
					$get_all_orders = $this->waiting_manager_model->query($sql1);
					
					if(count($get_all_orders)>0){
						/*echo $value1['incentives_price'];
						echo "<br>";
						echo $get_all_orders[0]['qty'];
						echo "<br>";*/
						foreach($get_all_orders as $key=>$value2){
							$cal_incentive=$cal_incentive+($value1['incentives_price']*$value2['qty']);
						}
					}
				}
				
				array_push($final_data,['name'=>$value['name'],'incentive'=>$cal_incentive]);
			}
		}

		else{
			$sql = "SELECT u.name,u.id
			from user as u
			WHERE u.usertype ='".$_POST['usertype']."' AND u.is_active=1 AND u.upline_id=".$_SESSION['user_id'];
			$data = $this->waiting_manager_model->query($sql);
			$final_data=[];
			if(!empty($data)){
				$sql1 = "SELECT IFNULL(SUM(net_total),0) AS net_total FROM orders WHERE status ='Completed' AND rest_id=".$_SESSION['user_id'];
				$get_total_sale = $this->Waiting_manager_model->query($sql1);
				
				$get_incentive_percentage = $this->Waiting_manager_model->select_where('incentive_master',['category_name'=>$_POST['usertype']]);

				//print_r($get_incentive_percentage);

				$get_incentive_amount = ($get_total_sale[0]['net_total']*$get_incentive_percentage[0]['incentives_price'])/100;
				$cal_incentive=$get_incentive_amount/count($data);
				foreach($data as $key=>$value2){
					array_push($final_data,['name'=>$value2['name'],'incentive'=>$cal_incentive]);
				}
			}
		}
		
		$this->json_output($final_data);
		
	}


}
?>