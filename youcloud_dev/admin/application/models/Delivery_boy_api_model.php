<?php
	class Delivery_boy_api_model extends My_Model{
		
		public function getAnyTableData($table, $conditon = []){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($conditon);

			$query = $this->db->get()->row_array();
			return $query;
		}
		
		public function getAnyTableDataArray($table, $conditon = []){
			$this->db->select('*');
			$this->db->from($table);
			$this->db->where($conditon);

			$query = $this->db->get()->result_array();
			return $query;
		}

		public function updateToken($table, $condition = [], $ref, $id){
			$this->db->where($ref,$id);
			$q = $this->db->update($table, $condition);
			return $q;
		}

		public function login($data){
			$query = $this->getAnyTableData('user', [
				"email" => $data['email'],
				"password" => $data['password'],
				"usertype" => "Delivery man",
				"is_active" => "1"
			]);
			//echo $this->db->last_query();
			//exit();
			$deviceToken = $data['device_token'];
			if (!empty($query)) {
				$id = $query['id'];
				$uplineId = $query['upline_id'];
				$token= $this->getAnyTableData('users_devicetoken', ["userid" => $id,]); 

				if (!$token) {
					$q = $this->db->insert('users_devicetoken', [
						"userid" => $id,
						"devicetoken" => $deviceToken,
					]);
					if ($q) {
						$query['devicetoken'] = $deviceToken;
						// return $query;
					}else {
						return false;
					}
				}
				else {
					$updateToken = $this->updateToken("users_devicetoken", [
						"devicetoken" => $data['device_token'],
					], "userid", $id);
					$query['device_token'] = $deviceToken;
				}
				$info['metadata']['status'] = 1;
				$info['metadata']['authrized_status'] = 1;
				$info['metadata']['popuptext']= "";
				$info['metadata']['sql_error']= null;
				$info['metadata']['is_temp_Login']= 0;
				//$info['metadata'] = $query;
				$info['metadata']['deliveryboy_detail']['deliveryboy_id'] = $query['id'];
				$info['metadata']['deliveryboy_detail']['name'] = $query['name'];
				$info['metadata']['deliveryboy_detail']['email'] = $query['email'];
				$info['metadata']['deliveryboy_detail']['authorized_id'] = 1;
				$info['metadata']['deliveryboy_detail']['mobile'] = $query['contact_number'];
				$info['metadata']['deliveryboy_detail']['is_active'] = $query['is_active'];
				$info['metadata']['deliveryboy_detail']['pid'] = 1;
				$info['metadata']['deliveryboy_detail']['created_date'] = $query['datetime'];
				$info['metadata']['deliveryboy_detail']['device_type'] = '';
				$info['metadata']['deliveryboy_detail']['post_code'] = 414201;
				$info['metadata']['deliveryboy_detail']['address'] = 'Static_address';
				$info['metadata']['deliveryboy_detail']['city'] = 'Static_city';
				$info['metadata']['storeInfo'] = $this->getAnyTableData('user', ["id" => $uplineId,
				]);
				$info['metadata']['storeInfo']['vendor_id'] = $uplineId;
				$info['metadata']['storeInfo']['lat'] = $info['metadata']['storeInfo']['latitude'];
				$info['metadata']['storeInfo']['lng'] = $info['metadata']['storeInfo']['longitude'];
				$info['metadata']['storeInfo']['trading_name'] = $info['metadata']['storeInfo']['business_name'];
				$info['metadata']['storeInfo']['store_image'] = $info['metadata']['storeInfo']['img_url'];
				$info['metadata']['storeInfo']['business_mobile'] = $info['metadata']['storeInfo']['contact_number'];
				return $info;
			}
			else {
				return "user not found";
			}
		}

		public function logOut(){

		}


		public function getAllOrders($id,$status){
			$this->db->select("o.*,a.*");
			$this->db->from("assign_delivery_for_order a");
			$this->db->join("orders o", "o.id = a.order_id","left");
			$this->db->where("a.delieverer_id", $id);
			//$this->db->where("o.status", $status);
			if($status == 'On the way'){
				$this->db->where("(o.status='To be picked up' OR o.status='Assigned To Deliver' OR o.status='Order transit' OR o.status='On the way')", NULL, FALSE);
				//$this->db->where("o.status", $status);
				//$this->db->or_where("o.status", 'To be picked up');
			}else{
				$this->db->where("o.status", $status);
			}
			

			$query = $this->db->get()->result_array();
			
			
			//print_r($query);exit();
			//echo $this->db->last_query();exit();
			$upline_id = $this->getAnyTableData("user", ["id" => $id]);
			$delivery_charges = $this->getAnyTableData("user", ["id" => $upline_id['upline_id']]);
			if (count($query) > 0) {
				$allRes  =[];
				//$res['deliveryboy_info'] = $this->getAnyTableData("user", ["id" => $id]);
				foreach ($query as $res){
					//echo $res['customer_id'];exit();
					$buyer_info = $this->getAnyTableData("customer", ["id" => $res['customer_id']]);
					$buyer_info_details = $this->getAnyTableData("customer_address", ["customer_id" => $res['customer_id']]);
					//echo $this->db->last_query();
					//print_r($buyer_info_details);exit();
					$res['order_status'] = $res['status'];
					$res['buyer_latitude'] = 0;
					$res['buyer_longitude'] = 0;
					$res['delivery_charges'] = $delivery_charges['delivery_fee'];
					$res['challenge25'] = 'false';
					$res['delivery_flag'] = 'false';
					$res['address'] = $buyer_info_details['delivery_area'];
					$res['buyer_name'] = $buyer_info['name'];
					$res['service_fee'] = 0;
					$res['buyer_full_address'] = $buyer_info_details['complete_address'];
					$res['buyer_mobile'] = $buyer_info['contact_no'];
					$res['address_date'] = '2021/10/01';
					$res['total_price'] = $res['net_total'];
					$res['delivery_time'] = $res['created_at'];
					
					$res['deliveryboy_id'] = $id;
					$res['deliveryboy_info'] = $this->getAnyTableData("user", ["id" => $id]);
					//$res['buyer_info'] = $this->getAnyTableData("customer", ["id" => $res['customer_id']]);
					//$res['buyer_info']['details'] = $this->getAnyTableData("customer_address", ["id" => $res['customer_id']]);
					array_push($allRes, $res);
					
				}
				$final_data["status"]= "1";
				$final_data["authrized_status"]= "1";
				$final_data["popuptext"]= "";
				$final_data["sql_error"]= null;
				$final_data["store_image"]= null;
				$final_data["order_list"] = $allRes;
				
				return [
					// "metadata" => $query,
					"metadata"=> $final_data
				];
			}else{
				$final_data["status"]= "1";
				$final_data["authrized_status"]= "1";
				$final_data["popuptext"]= "";
				$final_data["sql_error"]= null;
				$final_data["store_image"]= null;
				$final_data["order_list"] = [];
				return [
					// "metadata" => $query,
					"metadata"=> $final_data
				];
			}
			//return [];
		}

		public function getOrder($user_id, $order_id){
			$this->db->select("*");
			$this->db->from("assign_delivery_for_order a");
			$this->db->join("orders o", "o.id =". $order_id);
			$this->db->where("delieverer_id", $user_id);
			$query = $this->db->get()->row_array();
			
			
			$allRes['order_status'] = $query['status'];
			$allRes['order_no'] = $query['order_no'];
			$allRes['customer_id'] = $query['customer_id'];
			$allRes['table_id'] = $query['table_id'];
			$allRes['rest_id'] = $query['rest_id'];
			$allRes['loyalty_points'] = $query['loyalty_points'];
			$allRes["sub_total"] = $query['sub_total'];
			$allRes["disc_total"] = $query['disc_total'];
			$allRes["net_total"] = $query['net_total'];
			$allRes["suggetion"] = $query['suggetion'];
			$allRes['total_price'] = $query['net_total'];
			$allRes['service_fee'] = 0;
			$allRes['challange25'] = 'false';
			$allRes['assigned_at'] = $query['assigned_at'];
			$allRes['picked_at'] = $query['picked_at'];
			$allRes['completed_at'] = $query['completed_at'];
			if($query['delivery_payment'] != null){
				$allRes['delivery_payment'] = $query['delivery_payment'];
			}else{
				$allRes['delivery_payment'] = 'Paid';
			}
			
			
			$storeId = $query['rest_id'];
			$tableId = $query['invoice_id'];
			$customerId = $query['customer_id'];
			$orderId = $query['order_id'];
			$query['buyer_info'] = $this->getAnyTableData("customer", ["id" =>  $customerId]);
			$buyer_address = $this->getAnyTableData("customer_address", ["customer_id" =>  $query['customer_id']]);
			$query['store_info'] = $this->getAnyTableData("user", ["id" => $storeId]);
			$query['invoice'] = $this->getAnyTableData("invoices",  ["id" => $tableId]);
			$allRes['buyer_name'] = $query['buyer_info']['name'];
			$allRes['buyer_mobile'] = $query['buyer_info']['contact_no'];
			$allRes['buyer_latitude'] = 0;
			$allRes['buyer_longitude'] = 0;
			$allRes['address_date'] = $query['created_at'];
			$allRes['buyer_full_address'] =$buyer_address['complete_address'];
			$allRes['delivery_charges'] =$query['store_info']['delivery_fee'];
			$query["order_info"] = $allRes;
			

			$products1 = $this->getAnyTableDataArray("order_items",  ["order_id" => $order_id]);
			//print_r($query['products1']);exit();
			$query['products']=[];
			//$product=[];
			foreach($products1 as $key=>$value){
				//print_r($value);exit();
				$product=[];
				$recipe_name = $this->getAnyTableData("recipes",  ["id" => $value['recipe_id']]);
				
				$product['product_id']=$value['recipe_id'];
				$product['product_name']=$recipe_name['name'];
				$product['total_quantity']=$value['qty'];
				$product['total_price']=$value['total'];
				$product['challenge25']=false;
				$product['item_accept_status']='1';
				$product['product_status']='';
				array_push($query['products'],$product);
			}
			$query['status'] = 1;
			$query['authrized_status'] = 1;
			$query['popuptext']= "";
			$query['sql_error']= null;
			
			
			return [
					// "metadata" => $query,
					"metadata"=> $query
				];;
		}

		public function completeOrder($orderId){
			$query = $this->update('order', [
				"status" => "Confirmed"
			], "id", $orderId);

			return $query;
		}

		public function updateLocations($id, $longitude, $latitude){
			$query = $this->updateToken('user', [
				"latitude" => $longitude,
				"longitude" => $latitude
			], 'id', $id);
			return $query;
		}

		public function forgotPassword($data){
			$query = $this->getAnyTableData("user", [
				"email" => $data['email']
			]);

			// return $query;
			if ($query) {
				return  $this->updateToken('user', [
					"password" => $data['password']
				], 'email', $data['email']);
				
			}else{
				return false;
			}
		}
	}

?>