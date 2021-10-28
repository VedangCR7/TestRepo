<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model {
	public function __construct(){
		$this->load->database();
		
	}

	public function select_sidebar_menu($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }
	
	public function get_values(){
		$formatted_fields = array();
		foreach ($this->fields as $field) {
			if(isset($this->$field)){
				$formatted_fields[$field] = $this->$field;
			}
		}
		return $formatted_fields;
	}
	
	public function add()
	{
		$fields = $this->get_values();
		$result=$this->db->insert($this->tablename,$fields);
		$id = $this->db->insert_id();	
		$this->id = $id;
		/* echo $this->db->last_query(); */
		return $id;  
	}
	
	public function delete(){
		$this->db->where('id',$this->id);
		$result=$this->db->delete($this->tablename);
		return $result;  
	}//delete

	public function update(){
		$fields = $this->get_values();
		$this->db->where('id', $this->id);
		$result=$this->db->update($this->tablename,$fields);
		return $result;  
	}//update

	public function is_loggedin($status=null){
        if(!$this->session->userdata('logged_in')){
            redirect(base_url().'web/login');
         }
	}

	public function get(){
		$this->db->select('*');
		$this->db->from($this->tablename);
		$this->db->where('id',$this->id);
		$query=$this->db->get();

		$result=$query->row_array();
		
		if($result)
		{
		foreach ($result as $key => $value) {
			if(property_exists($this, $key)){
				$this->$key = $value;
			}
		}
		}
		return $result;  
	}

	public function get_session_value($key){
		if(isset($_SESSION['user_id'])){
			return  $_SESSION[$key];
		}
		else{
			return  false;
		}
	}
	public function isexist($param,$not_in=array()){
		$this->db->select('*');
		$this->db->from($this->tablename);
		foreach ($param as $key => $value) {
			$this->db->where($key,$value);
		}
		foreach ($not_in as $key => $value) {
			$this->db->where($key."!=$value");
		}
		$query=$this->db->get();
		if($query->num_rows()==0)
			return "not";
		else
			return "exist";
	}


	public function isexist_row($param,$not_in=array()){
		$this->db->select('*');
		$this->db->from($this->tablename);
		foreach ($param as $key => $value) {
			$this->db->where($key,$value);
		}
		foreach ($not_in as $key => $value) {
			$this->db->where($key."!=$value");
		}
		$query=$this->db->get();
		if($query->num_rows()==0)
			return "not";
		else{
			$result=$query->row_array();
			return $result['id']; 
		}
	}


	public function list_all(){
    	$this->db->select('*');
		$this->db->from($this->tablename);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;  
    }

    public function max_id(){
    	$this->db->select('MAX(id) as id');
		$this->db->from($this->tablename);
		$query=$this->db->get();
		$result=$query->row_array();
		return $result['id'];  
    }

    public function list_publish(){
    	$this->db->select('*');
		$this->db->where('status="Publish"');
		$this->db->from($this->tablename);
		$query=$this->db->get();
		$result=$query->result_array();
		return $result;  
    }


    public function generateDatatables( $totalData1,$index_coloun = "", $show_btn = array( ),$show_check=false, $srno = '' )
    {
    	 $data       = array( );
    	 $i=0;
        foreach ( $totalData1 as $key => $value ) {
        	
            $outputData = array( );
            if ( $srno == 'show' ) {
                $sno++;
                $outputData[ ] = $sno;
            } //$srno == 'show'
            if($show_check==true){
            	 $outputData[ ] = "<input type='checkbox' class='input-check-single' name='check_".$i."' value='".$value['id']."'>";
            }
            foreach ( $value as $key1 => $value1 ) {
            	if($key1!="payment_amount" && $key1!="is_active")
            		{
		                if ( $value1 != $value[ $index_coloun ] ) {
		                    $outputData[ ] = $value1;
		                } //$value1 != $value[ $index_coloun ]
		                else {
		                    $outputData[ ] = $value1;
		                }
            		}
            } //$value as $key1 => $value1
            $str     = '';
           
            if ( !empty( $show_btn ) ) {
            	$buttons = array( );
                foreach ( $show_btn as $key => $edv ) {
                    switch ($edv) {
                    	case 'view':
                    		 $buttons[ ] = '<a class="btn btn-primary view" title="' . $value[ $index_coloun ] . '" data-id="' . $value[ $index_coloun ] . '" href="javascript:;" role="button"> <i class="fa fa-eye"></i></a> ';
                    	break;
                    	
                		case 'edit':
                		 $buttons[ ] = '<a class="btn btn-warning edit" title="' . $value[ $index_coloun ] . '" data-id="' . $value[ $index_coloun ] . '" href="javascript:;" role="button"> <i class="fa fa-pencil"></i></a> ';
                		break;

                		case 'delete':
                		$buttons[ ] = ' <a class="btn btn-danger delete" title="' . $value[ $index_coloun ] . '" data-id="' . $value[ $index_coloun ] . '" href="javascript:;" role="button"> <i class="fa fa-remove"></i></a>';

                		break;

                		case 'print':
                		$buttons[ ] = ' <a class="btn btn-default print" title="' . $value[ $index_coloun ] . '" data-id="' . $value[ $index_coloun ] . '" href="javascript:;" role="button" style="color: #fff;background-color: #b8b0b0;border-color: #ccc;"> <i class="fa fa-print"></i></a>';

                		break;

                		case 'payment':
                		if($value['payment_amount']<$value['net_purchase_amount']){
                			$buttons[ ] = ' <a class="btn btn-primary payment" title="' . $value[ $index_coloun ] . '" pay-amount="'.$value['payment_amount'].'" data-id="' . $value[ $index_coloun ] . '" amount="' . $value["net_purchase_amount"] . '" href="javascript:;" role="button"> <i class="fa fa-paypal" aria-hidden="true"></i></a>';
                		}
                		break;

                		case 'reviews':
                			$buttons[ ] = ' <a class="btn btn-success reviews" data-id="' . $value[ $index_coloun ] . '" href="javascript:;" role="button"> Reviews</a>';
                			break;
                		case 'publish':
                			$buttons[ ] = ' <a class="btn btn-success publish" data-id="' . $value[ $index_coloun ] . '" href="javascript:;" role="button"> Publish</a>';
                			
                		break;
                		case 'active':
                    		$html_in= '<label class="custom-switch pl-0">';
						 	
                                if($value['is_active']==1){
						 	
                                $html_in.='<input type="checkbox" name="custom-switch-checkbox" data-id="' . $value[ $index_coloun ] . '" class="custom-switch-input input-switch-box input-change-status" checked>';
                            	}
                            	else{
                                $html_in.='<input type="checkbox" name="custom-switch-checkbox" data-id="' . $value[ $index_coloun ] . '" class="custom-switch-input input-switch-box input-change-status">';
                            	}
                            $html_in.='<span class="custom-switch-indicator"></span>
                            </label>';
                			$buttons[ ] = $html_in;
                    	default:
                    		# code...
                    		break;
                    }
                } //$sess as $key => $edv
                $str= implode( $buttons );
                $outputData[ ] = $str;
            } //!empty( $check_session_passed )
            $data[ ] = $outputData;
            $i++;
        } //$totalData1 as $key => $value
        /* return $data;
        return $buttons;*/
        $json_response = array(
            "recordsTotal" => count($totalData1),
            "data" => $data 
        );
        return $json_response;
    } //end getDataTablesByQuery function
    


    public function debug($array, $is_die){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
		if($is_die){
			die;
		}
	}

	public function number_round($number){
		$floor = floor($number);
		if( $floor == floor($number-0.50)){
			return ceil($number);
		}
		else{
			return $floor;
		}
	}

	public function unset_fields(){
		foreach ($this->fields as $f) {
			unset($this->$f);
		}
	}

	public function set_values($post){
		foreach ($post as $key => $value) {
			$this->$key=$value;
		}
	}

	public function get_time_ago($time)
		{
		    $time_difference = time() - $time;

		    if( $time_difference < 1 ) { return 'Just Now'; }
		    $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
		                30 * 24 * 60 * 60       =>  'month',
		                24 * 60 * 60            =>  'day',
		                60 * 60                 =>  'hour',
		                60                      =>  'minute',
		                1                       =>  'second'
		    );

		    foreach( $condition as $secs => $str )
		    {
		        $d = $time_difference / $secs;

		        if( $d >= 1 )
		        {
		            $t = round( $d );
		            return  $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
		        }
		    }
		}

	public function send_sms($mobile_no,$message){		
		$message = preg_replace('!\s+!', '+', $message);
		$plus_sign=substr($mobile_no,0);
		if($plus_sign=="+")
			$server_url="http://admin.technoplanetsoft.com/submitsms.jsp?user=myfarmer&key=8897d61e0aXX&mobile=".$mobile_no."&message=".$message."&senderid=INFOSM&accusage=1&unicode=1";
	    else
	    	$server_url="http://admin.technoplanetsoft.com/submitsms.jsp?user=myfarmer&key=8897d61e0aXX&mobile=+91".$mobile_no."&message=".$message."&senderid=INFOSM&accusage=1&unicode=1";
	    $ch = curl_init();
	    // set URL and other appropriate options
	    curl_setopt($ch, CURLOPT_URL, $server_url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
	    curl_setopt($ch,CURLOPT_HTTPHEADER,array (
	      "Content-Type: application/x-www-form-urlencoded; charset=utf-8"
	    ));
        ob_start();
	    // grab URL and pass it to the browser
	    curl_exec($ch);
	    $curlerrno = curl_errno($ch);
	    curl_close($ch);
	    if($curlerrno)
	    {
	        ob_clean();
	      	return "fail";
	    }
	    else{
	    	ob_clean();
	     	return "success"; 
	    }

   }
}

?>