<?php
//saved
class User_model extends My_Model {
    var $name;
    var $email;
    var $password;
    var $business_name;
    var $address;
    var $city;
    var $country;
    var $postcode;
    var $contact_number;
    var $profile_photo;
    var $usertype;
    var $restauranttype;
    var $api_key;
    var $group_seq;
    var $food_company_id;
    var $is_individual_reg;
    var $is_reg_payment;
    var $is_active;
    var $payment_end_date;
    var $countrycode;
    var $img_url;
    var $forgot_link_used;
    var $latitude;
    var $longitude;
    var $is_alacalc_recipe;
    var $is_category_prices;
    var $opening_time;
    var $close_time;
    var $owner_contact_no;
    var $forcountry_countrycode;
    var $currency;
    var $currency_symbol;
    var $owner_address;
    var $rest_img_1;
    var $rest_img_2;
    var $rest_img_3;
    var $rest_img_4;
    var $rest_img_5;
    var $about_restaurant;
	var $date;
	var $is_new;
    var $tablename="user";
    var $fields=array('name','email','password','business_name','address','city','country','postcode','contact_number','profile_photo','usertype','restauranttype','api_key','group_seq','food_company_id','is_individual_reg','is_reg_payment','is_active','payment_end_date','countrycode','img_url','forgot_link_used','latitude','longitude','is_alacalc_recipe','is_category_prices','opening_time','close_time','owner_contact_no','currency','currency_symbol','forcountry_countrycode','owner_address','rest_img_1','rest_img_2','rest_img_3','rest_img_4','rest_img_5','about_restaurant','delivery_fee','date','is_new');
    public function __construct()
    {
        $this->load->database();
        $this->load->library('upload');
        $this->load->library('image_lib');
    }
    public function list_all(){
        $this->db->select("*");
        $this->db->from('user');
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

    public function list_user_post(){
        $this->db->select("*");
        $this->db->from('user');
        $this->db->where('postcode!=', '');
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }


    public function insert_user_data($user_data){
        $this->db->insert('user_data', array('user_data' => $user_data));
        $id = $this->db->insert_id();
		/* echo $this->db->last_query();exit; */
        return $id;
    }

    public function get_userdata($id){
        $this->db->select('u.*');
        $this->db->from('user_data u');
        $this->db->where('u.id', $id);
        $query = $this->db->get();
		/* echo $this->db->last_query();exit; */
        $row = $query->row_array();
        return  $row;       
    }

    public function get_active_user($id){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.id', $id);
        $this->db->where('u.is_active', 1);
        $query = $this->db->get();
        $row = $query->row_array();
        if($query->num_rows()==0)
            return "notactivated";
        else
            return  $row;       
    }

    public function get_table_details($id){
        $this->db->select('t.*');
        $this->db->from('table_details t');
        $this->db->where('t.id', $id);
        $this->db->where('t.is_active', 1);
        $this->db->where('t.is_delete', 0);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;       
    }


    public function list_rest_tablecategories($id){
        $this->db->select('t.*');
        $this->db->from('table_category t');
        $this->db->where('t.logged_user_id', $id);
        $this->db->where('t.is_active', 1);
        $this->db->where('t.is_delete', 0);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

     public function list_rest_tblcategories($id){
        $this->db->select('t.*');
        $this->db->from('table_category t');
        $this->db->where('t.logged_user_id', $id);
        $this->db->where('t.is_delete', 0);
        $this->db->where('t.is_active', 1);
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

    public function get_main_menugroup_byuser($user_id)
	{
        $this->db->select("m1.*,m1.id as main_menu_id,m1.name as main_group,(SELECT count(r.id) as cnt FROM `recipes` `r` 
            WHERE `r`.`main_menu_id`=m1.id
            AND `r`.`is_delete` =0 AND `r`.`is_active` = 1 AND `r`.`is_recipe_active` = 1 AND `r`.`logged_user_id` = ".$user_id.") as recipe_count",false);
        /*$this->db->from('menu_group m');*/
        $this->db->from('menu_master m1');
        $this->db->where('m1.restaurant_id',$user_id);
        $this->db->where('m1.is_active',1);
        $this->db->having('recipe_count>0');
        $this->db->order_by('m1.id','asc');
        $query = $this->db->get();
       
        $result=$query->result_array();
        if(empty($result))
            return array();
        else
            return $result;
    }

    public function update_link_used($id){
        $this->db->where('id',$id);
        $this->db->update('user_data',array('link_used'=>1));
        return  true;  
    } 

    public function update_user_subscrition_id($user_id,$subscription_id){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.id', $user_id);
        $query = $this->db->get();
        $user = $query->row_array();
        
        $data=array();
        $data['subscription_id']=$subscription_id;
        $this->db->where('id',$user_id);
        $this->db->update('user',$data);
        return  $user;       
    }
    public function get_userdata_byemail($email){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.email', $email);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;       
    }

    public function update_user_paymenydate($user_id,$subscription_end_date,$subscription_id="",$period=""){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.id', $user_id);
        $query = $this->db->get();
        $user = $query->row_array();
        if($user['payment_end_date']!=""){
            if($user['payment_end_date']>date('Y-m-d')){
                $payment_end_date=date('Y-m-d', strtotime($user['payment_end_date']." +".$period." months"));
            }
            else{
                $payment_end_date=$subscription_end_date;
            }
        }
        else
            $payment_end_date=$subscription_end_date;

        
        //$to_date
        $data=array(
            'payment_end_date'=>$payment_end_date
        );
        if($subscription_id!=""){
            $data['subscription_id']=$subscription_id;

            $this->db->where('id',$subscription_id);
            $this->db->update('subscriptions',array('user_id'=>$user_id));
        }

        $this->db->where('id',$user_id);
        $this->db->update('user',$data);
        return  $user;       
    }

   public function get_user($user_id){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.id', $user_id);
        $query = $this->db->get();
        $row = $query->row_array();
        return  $row;       
    }
    public function get_user_bytypes($user_type){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.usertype', $user_type);
        $this->db->where('u.name!=','');
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }
	
	/* new code by ashwini */
	public function get_restaurant_bytypes($user_type){
        $this->db->select('u.*');
        $this->db->from('user u');
        $this->db->where('u.restauranttype', $user_type);
        $this->db->where('u.name!=','');
        $query = $this->db->get();
        $row = $query->result_array();
        return  $row;       
    }

    public function get_company_registration_count($year=''){
        if($year=="")
            $year=date('Y');
        $data=array('01','02','03','04','05','06','07','08','09','10','11','12');
        $res=array();
        foreach ($data as $key=>$value) {
            $this->db->select('count(*) as cnt,DATE_FORMAT(datetime, "%m") as month');
            $this->db->from('user u');
            $this->db->where('u.food_company_id',$_SESSION['user_id']);
            $this->db->where('DATE_FORMAT(datetime, "%Y")=',$year);
            $this->db->where('DATE_FORMAT(datetime, "%m")=',$value);
            $query = $this->db->get();
            $result = $query->row_array();
            $res[$value]=$result['cnt'];
        }
      
        return  $res;       
    }

    public function userregistration_typewise($year='',$month=''){
        /* --- code change by ashwini ---  
		$array=array('Restaurant','Individual User','Food Company','School'); */
		$array=array('Restaurant','Restaurant chain','School','Individual User','Burger and Sandwich');
        $data=array();
        foreach ($array as $arr) {
            $this->db->select("count(*) as user_count");
            $this->db->from('user u');
            /* Code change by ashwini 'Restaurant' => 'Restaurant' */
			if(($arr=="Restaurant") || ($arr=="Burger and Sandwich")){
                $this->db->where('u.food_company_id',null);
                $this->db->where('u.usertype',$arr);
            }
            else
                $this->db->where('u.usertype',$arr);
            if($month!='')
                $this->db->where("DATE_FORMAT(u.datetime,'%m')",$month);
            if($year!='')
                $this->db->where("DATE_FORMAT(u.datetime,'%Y')",$year);
            $this->db->group_by('u.usertype');
            $query = $this->db->get();
            $result = $query->row_array();
            if(empty($result)){
                $data[$arr]=0;
            }
            else
                $data[$arr]=$result['user_count'];
        }
        return $data;
    }

    public function list_users_bycompanyids($company_id){
        $this->db->select('u.id,u.name,u.email,(SELECT count(*) as recipe_count FROM `recipes` `r` WHERE r.logged_user_id=u.id  AND r.is_active=1 AND r.is_delete=0) as recipes_count,(CASE WHEN payment_end_date > CURDATE() THEN "Active" ELSE "Inactive" END) as subscription_status,DATE_FORMAT(payment_end_date,"%d %M %Y") as payment_end_date,u.is_active');
        $this->db->from('user u');
        //$this->db->join('subscriptions s','s.user_id=u.id and s.is_used=0','left');
		/* Code change by ashwini 'Restaurant' => 'Restaurant' */
        if($company_id=="All"){
            $this->db->where('(u.usertype="Restaurant" AND u.food_company_id!="")');

        }else{
            $this->db->where('u.food_company_id',$company_id);
        }
        $query = $this->db->get();
        $result = $query->result_array();
       
        //$data[$arr]=$result;
        return $this->generateDatatables($result,'id',array('active'));
    }

    public function userlist_usertypewise(){
		/* --- code change by ashwini ---  
		$array=array('Restaurant','Individual User','Food Company','School'); */
		$array=array('Restaurant','Restaurant chain','School','Individual User','Burger and Sandwich');
        $data=array();
        foreach ($array as $arr) {
            $this->db->select('u.*,(CASE WHEN payment_end_date > CURDATE() THEN "Active" ELSE "Inactive" END) as subscription_status,DATE_FORMAT(payment_end_date,"%d %M %Y") as payment_end_date,(SELECT SUM(no_of_visits) as ttl_user_cnt FROM get_restaurant_count c WHERE c.restaurant_id=u.id) as total_user_count,(SELECT no_of_visits as daily_user_cnt FROM get_restaurant_count d WHERE d.restaurant_id=u.id AND d.visited_at= CURDATE()) as daily_user_count,(SELECT count(*) as recipe_count FROM `recipes` `r` WHERE r.logged_user_id=u.id AND r.is_active=1 AND r.is_delete=0) as recipes_count');
            $this->db->from('user u');
            //$this->db->join('subscriptions s','s.user_id=u.id and s.is_used=0','left');
            /* Code change by ashwini 'Restaurant' => 'Restaurant' */
            if(($arr=="Restaurant") || ($arr=="Burger and Sandwich")){
                $this->db->where('u.food_company_id',null);
                $this->db->where('u.usertype',$arr);
            }
            else if($arr=="Restaurant chain"){
                $this->db->where('u.usertype',"Restaurant");
                $this->db->where('u.food_company_id!=','');
            }else{

                $this->db->where('u.usertype',$arr);
            }
            $query = $this->db->get(); /* echo $this->db->last_query(); exit; */
            $result = $query->result_array();
           /* echo $this->db->last_query();
            die;*/
            $data[$arr]=$result;
        }
        return $data;
    }


    public function get_user_countbytype(){
      /*  $query = $this->db->query("SELECT u1.*,(SELECT count(*) as cnt 
                FROM `user` `u2` 
                WHERE `u2`.`usertype` = u1.usertype AND u2.is_active=1) as active_count,(SELECT count(*) as cnt 
                FROM `user` `u2` 
                WHERE `u2`.`usertype` = u1.usertype AND u2.is_active=0) as inactive_count
            FROM(
                SELECT count(*) as cnt, `usertype` 
                FROM `user` `u` 
                WHERE `u`.`usertype` != 'Admin' 
                GROUP BY `u`.`usertype`
            ) as u1");
        $result = $query->result_array();
        echo "<pre>";
        print_r($result);
        die;
        return  $result;  */     

		/* --- code change by ashwini ---  
		$array=array('Restaurant','Individual User','Food Company','School'); */
		$array=array('Restaurant','Restaurant chain','School','Individual User','Burger and Sandwich');
        $data=array();
        foreach ($array as $arr) {
            $this->db->select('COUNT(id) as cnt,COUNT(DISTINCT(CASE WHEN is_active=1 THEN id END)) AS active_count,COUNT(DISTINCT(CASE WHEN is_active=0 THEN id END)) AS inactive_count');
            $this->db->from('user');
            //$this->db->join('subscriptions s','s.user_id=u.id and s.is_used=0','left');
            if(($arr=="Restaurant") || ($arr=="Burger and Sandwich")){
                $this->db->where('food_company_id',null);
                $this->db->where('usertype',$arr);
            }
            /*else if($arr=="Food Company"){
                $this->db->where('(usertype="Restaurant" AND food_company_id!="") OR usertype="Food Company"');
            }*/else{

                $this->db->where('usertype',$arr);
            }
            $query = $this->db->get();
            $result = $query->row_array();
            $data[]=array(
                'cnt' => $result['cnt'],
                'usertype' => $arr,
                'active_count' =>$result['active_count'],
                'inactive_count' => $result['inactive_count']
            );
            //$data[$arr]=$result;
        }
       /* echo "<pre>";
        print_r($data);
        die;*/
        return $data;
    }

	/* Code by Ashwini on 19 Feb 2021 */
	public function get_ttlresto_count(){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('is_active','1');
        $this->db->where('usertype','Restaurant');
		$query=$this->db->get();
		if ($query->num_rows()>0) 
		{
			return $query->num_rows();
		}
		else 
		{
			return false;
		}
    }
	
	public function ttlrevenueocount(){
        $this->db->select_sum('net_total');
        $this->db->from('orders');
        $this->db->where('status','Completed');
		$query=$this->db->get();
		/* echo $this->db->last_query();exit; */
        if ($query->num_rows()>0) 
		{
			return $query->result();
		}
		else 
		{
			return false;
		}
    }
	
	public function ttlorderscount(){
        $this->db->select('id');
        $this->db->from('orders');
        /* $this->db->where('status','Completed'); */
		$query=$this->db->get();
		/* echo $this->db->last_query(); */
        if ($query->num_rows()>0) 
		{
			return $query->num_rows();
		}
		else 
		{
			return false;
		}
    }
	
	public function get_resto_list(){
        $this->db->select('u.id,u.name,u.email,(SELECT count(*) as tdcnt FROM `orders` `r` WHERE r.rest_id=u.id AND r.status="Completed" AND DATE(r.created_at)=CURDATE()) as tdcnt,(SELECT count(*) as tlcnt FROM `orders` `r` WHERE r.status="Completed" AND r.rest_id=u.id) as tlcnt,(SELECT ifnull(SUM(net_total),0) as earning FROM `orders` `r` WHERE r.rest_id=u.id AND r.status="Completed") as earning,u.is_active');
       /*  $this->db->select('u.id,u.name,u.email,(SELECT count(*) as tdcnt FROM `orders` `r` WHERE r.rest_id=u.id AND DATE(r.created_at)=CURDATE()) as tdcnt,(SELECT count(*) as tlcnt FROM `orders` `r` WHERE r.rest_id=u.id) as tlcnt,(SELECT ifnull(SUM(net_total),0) as earning FROM `orders` `r` WHERE r.rest_id=u.id AND r.status="Completed") as earning,u.is_active'); */
        $this->db->from('user u');
        $this->db->where('u.is_active','1');
        $this->db->where('u.usertype','Restaurant');
		$this->db->order_by("earning", "desc");
		$query=$this->db->get();
		if ($query->num_rows()>0) 
		{
			return $query->result();
		}
		else 
		{
			return false;
		}
    }
	
	public function get_dresto_list(){
        $this->db->select('u.id,u.name,u.city,(SELECT count(*) as tdcnt FROM `orders` `r` WHERE r.rest_id=u.id AND r.status="Completed" AND DATE(r.created_at)=CURDATE()) as tdcnt,(SELECT count(*) as tlcnt FROM `orders` `r` WHERE r.status="Completed" AND r.rest_id=u.id) as tlcnt,(SELECT ifnull(SUM(net_total),0) as earning FROM `orders` `r` WHERE r.rest_id=u.id AND r.status="Completed") as earning,u.is_active');
       
        $this->db->from('user u');
        $this->db->where('u.is_active','1');
        $this->db->where('u.usertype','Restaurant');
		$this->db->order_by("earning", "desc");
		$this->db->limit(10);
		$query=$this->db->get();
		if ($query->num_rows()>0) 
		{
			return $query->result();
		}
		else 
		{
			return false;
		}
    }
	
	public function get_revenuedata(){
        $this->db->select('u.id,u.name,u.email,(SELECT ifnull(SUM(net_total),0) as tdcnt FROM `orders` `r` WHERE r.rest_id=u.id AND r.status="Completed" AND DATE(r.created_at)=CURDATE()) as tdcnt,(SELECT ifnull(SUM(net_total),0) as earning FROM `orders` `r` WHERE r.rest_id=u.id AND r.status="Completed") as earning,u.is_active');
        $this->db->from('user u');
        $this->db->where('u.is_active','1');
        $this->db->where('u.usertype','Restaurant');
		$this->db->order_by("earning", "desc");
		$query=$this->db->get();
		if ($query->num_rows()>0) 
		{
			return $query->result();
		}
		else 
		{
			return false;
		}
    }
	/* End code by Ashwini on 19 Feb 2021 */

	
    public function is_passwordexist($id,$password){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id',$id);
        $this->db->where('password like binary "'.$password.'"', NULL, FALSE);
        $query=$this->db->get();
        if($query->num_rows()==0)
            return "not";
        else
            return "exist";
    }

    public function is_subscribe($user_id){
        $this->db->select('*,s.id as subscription_id');
        $this->db->from('subscriptions s');
        $this->db->where('s.user_id', $user_id);
        $query = $this->db->get();
        $row = $query->row_array();
        return $row;
    }
     
    public function check_subscription($user_id){
        if($_SESSION['usertype']=="Individual User"){
            $this->db->select('*,s.id as subscription_id');
            $this->db->from('user u');
            $this->db->join('subscriptions s','s.user_id=u.id');
            $this->db->where('s.is_used',0);
            $this->db->where('u.id', $user_id);
            ///$this->db->where('"'.date('Y-m-d').'" BETWEEN from_date and to_date');
            $query = $this->db->get();
            $row = $query->row_array();
            if(!empty($row)){
                if($row['period']=="perrecipe"){
                    return $row;
                }else{
                    $this->db->select('*');
                    $this->db->from('user u');
                    $this->db->join('subscriptions s','s.user_id=u.id','left');
                    $this->db->where('u.id', $user_id);
                    $this->db->where('s.is_used',0);
                    $this->db->where('u.payment_end_date>="'.date('Y-m-d').'"');
                    $query = $this->db->get();
                    $row = $query->row_array();
                    return $row;
                }
            }
           
        }else{
            $this->db->select('*');
            $this->db->from('user u');
            $this->db->join('subscriptions s','s.user_id=u.id','left');
            $this->db->where('u.id', $user_id);
            $this->db->where('s.is_used',0);
            $this->db->where('u.payment_end_date>="'.date('Y-m-d').'"');
            $query = $this->db->get();
            $row = $query->row_array();
        }
        return  $row;       
    }


    public function upload_image($key,$filename=""){

        $upload_path = './uploads/profile/';
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'jpg|jpeg|png|JPEG|PNG|JPG',
            'encrypt_name'=>TRUE
        );

        if($filename!=""){
            $config['file_name']=$filename;
            $config['encrypt_name']=false;
        }

        $this->upload->initialize($config);
        if(!$this->upload->do_upload($key)){
            $error = $this->upload->display_errors();
            return array('status'=>false,'msg'=>strip_tags($error));

        }
        else{
            $file_data = $this->upload->data();
            $image_name = $file_data['file_name'];
            $cover_imgpath = 'uploads/profile/'. $image_name;
            return array('status'=>true,'path'=>$cover_imgpath);

        }

    }

    public function upload_blob_file(){
        switch(strtolower($ImageType))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($_SERVER['DOCUMENT_ROOT'] . $fileUrl);
            break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($_SERVER['DOCUMENT_ROOT'] . $fileUrl);
            break;
            default:
                die('Unsupported File!'); //output error
        }
    }
    public function list_company_restaurant($company_id,$status=""){
        $this->db->select('*,DATE_FORMAT(datetime,"%d/%m/%Y") as register_date');
        $this->db->from('user');
        $this->db->where('food_company_id',$company_id);
        if($status=="active")
            $this->db->where('is_active',1);
        else if($status=="inactive")
            $this->db->where('is_active',0);
        $query = $this->db->get();
        $result=$query->result_array();
        return $result;
    }



    public function get_company_usercount($company_id,$is_active=null){
        $this->db->select('count(*) as cnt');
        $this->db->from('user');
        $this->db->where('food_company_id',$company_id);
        if($is_active==0 || $is_active==1)
            $this->db->where('is_active',$is_active);
        $query = $this->db->get();
        $result=$query->row_array();
        return $result['cnt'];
    }


    public function get_restaurant_api_key($usertype,$company_id){

            $this->db->select('*,MAX(group_seq) as group_seq,api_key,food_company_id');
            $this->db->from('user');
            $this->db->where('usertype',$usertype);
            $this->db->where('food_company_id',$company_id);
            $this->db->where('is_individual_reg',0);
            $this->db->where('usertype!=""');
            $this->db->order_by('id','desc');
            $this->db->group_by('usertype');
            $this->db->limit(1);
            $query = $this->db->get();
            $result=$query->row_array();

            if($result['group_seq']!=""){
                $group_seq=$result['group_seq'];
                $this->db->select('count(*)as cnt,api_key');
                $this->db->from('user');
                $this->db->where('usertype',$usertype); 
                $this->db->where('food_company_id',$company_id);
                $this->db->where('is_individual_reg',0);
                $this->db->where('group_seq',$group_seq);
                $query = $this->db->get();
                $row=$query->row_array();
                $cnt=$row['cnt'];
                if($cnt<20){
                    $api_key=$row['api_key'];
                    $group_seq=$group_seq;
                }else{
                    $api_key=$this->random_strings(32);
                    $group_seq=$group_seq+1;
                }
            }
            
            else{
                $api_key=$this->random_strings(32);
                $group_seq=1;
            }
        return array('api_key'=>$api_key,'group_seq'=>$group_seq);
    }

   
   public function get_api_key($usertype){
		/* code change by ashwini "Restaurant" => 'Restaurant' */
        if($usertype=="Restaurant" || $usertype=="Burger and Sandwich" || $usertype=="School"){
            $this->db->select('*,MAX(group_seq) as group_seq,api_key,food_company_id');
            $this->db->from('user');
            $this->db->where('usertype',$usertype);
            if(($usertype=="Restaurant")  || ($usertype=="Burger and Sandwich")){
                $this->db->where('is_individual_reg',1);
            } 
            $this->db->where('usertype!=""');
            $this->db->order_by('id','desc');
            $this->db->group_by('usertype');
            $this->db->limit(1);
            $query = $this->db->get();
           /* echo $this->db->last_query();
            die;*/
            $result=$query->row_array();
            if($result['group_seq']!=""){
                $group_seq=$result['group_seq'];
                $this->db->select('count(*)as cnt,api_key');
                $this->db->from('user');
                $this->db->where('usertype',$usertype); 
                if(($usertype=="Restaurant")  || ($usertype=="Burger and Sandwich")){
                    $this->db->where('is_individual_reg',1);
                } 
                $this->db->where('group_seq',$group_seq);
                $query = $this->db->get();
                $row=$query->row_array();
                $cnt=$row['cnt'];
                if($cnt<20){
                    $api_key=$row['api_key'];
                    $group_seq=$group_seq;
                }else{
                    $api_key=$this->random_strings(32);
                    $group_seq=$group_seq+1;
                }
            }
            
            else{
                $api_key=$this->random_strings(32);
                $group_seq=1;
            }
        }
        else if($usertype="Restaurant chain"){
            $api_key=$this->random_strings(32);
            $group_seq=0;
        }
        return array('api_key'=>$api_key,'group_seq'=>$group_seq);
    }

    function random_strings($length_of_string) 
    { 
      
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
        return substr(str_shuffle($str_result),  
                           0, $length_of_string); 
    } 

    public function do_login($email, $password){
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email',$email);  
        $this->db->where('password like binary "'.$password.'"', NULL, FALSE);
       /* $this->db->where('password',$password);*/
       /* $this->db->where('is_active',1);*/
        $query = $this->db->get();
        if($query->num_rows()){
            $result=$query->row_array();
            
			if($result['is_active']==1)
			{				
                $userdata = array(
                   'name'=> $result['name'],
                   'email'=> $result['email'],  
                   'business_name'=> $result['business_name'],   
                   'contact_number'=> $result['contact_number'],   
                   'user_id'   => $result['id'],
                   'logged_in' => TRUE,
                   'profile_photo'=>$result['profile_photo'],
                   'usertype'=>$result['usertype'],
                   'restauranttype'=>$result['restauranttype'],
                   'sess_rand_id'=>rand(111111,999999),
                   'is_active'=>$result['is_active'],
                   'is_alacalc_recipe'=>$result['is_alacalc_recipe'],
                   'is_category_prices'=>$result['is_category_prices'],
                   'currency_symbol'=>$result['currency_symbol']
                ); 
                $this->session->set_userdata($userdata);
                return $result;
            }
			else
			{
                return "notactivated";
            }
        }
        else{
            return false;
        }
    }

    public function insert_any_query($table,$data){
        return $this->db->insert($table,$data);
    }

    public function delete_authority($table,$condition){
        return $this->db->delete($table,$condition);
    }

    public function insert_authority_data($athority_data){
        $this->db->insert('restaurant_menu_authority', $athority_data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function select_where($table,$condition){
        return $this->db->where($condition)->get($table)->result_array();
    }

    public function list_company_users($page_no,$records_per_page,$company_id,$user_status=""){
        
        $this->db->select('count(*) as cnt');
        $this->db->from('user');
        $this->db->where('food_company_id',$company_id);
        if($user_status=="active")
            $this->db->where('is_active',1);
        else if($user_status=="inactive")
            $this->db->where('is_active',0);
        $query=$this->db->get();
        $user_count=$query->row_array();
     
        if($records_per_page=="all"){
            $this->db->select('*,DATE_FORMAT(datetime,"%d/%m/%Y") as register_date,(CASE WHEN payment_end_date > CURDATE() THEN "active" ELSE "inactive" END) as subscription_status');
            $this->db->from('user');
            $this->db->where('food_company_id',$company_id);
            if($user_status=="active")
                $this->db->where('is_active',1);
            else if($user_status=="inactive")
                $this->db->where('is_active',0);
            $this->db->order_by('id','desc');
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'users'=>$result,
                'total_count'=>$user_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$user_count['cnt']
            ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           /* echo $offset;
            die;*/
            $this->db->select('*,DATE_FORMAT(datetime,"%d/%m/%Y") as register_date,(CASE WHEN payment_end_date > CURDATE() THEN "active" ELSE "inactive" END) as subscription_status');
            $this->db->from('user');
            $this->db->where('food_company_id',$company_id);
            if($user_status=="active")
                $this->db->where('is_active',1);
            else if($user_status=="inactive")
                $this->db->where('is_active',0);
            $this->db->order_by('id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();


            $total_pages = ceil($user_count['cnt'] / $records_per_page);

            if($user_count['cnt']<$records_per_page)
                $to_page=$user_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'users'=>$result,
                'total_count'=>$user_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }


     public function list_restaurnts_pagination($page_no,$records_per_page){
        
        $this->db->select('count(*) as cnt');
        $this->db->from('user');
        $this->db->where('usertype','Restaurant');
        $query=$this->db->get();
        $user_count=$query->row_array();
     
        if($records_per_page=="all"){
            $this->db->select('*,DATE_FORMAT(datetime,"%d/%m/%Y") as register_date,(CASE WHEN payment_end_date > CURDATE() THEN "active" ELSE "inactive" END) as subscription_status');
            $this->db->from('user');
            $this->db->where('usertype','Restaurant');
            $this->db->order_by('id','desc');
            $query = $this->db->get();
            $result = $query->result_array();

            return  array(
                'users'=>$result,
                'total_count'=>$user_count['cnt'],
                'total_pages'=>1,
                'page_no'=>1,
                'page_total_text'=>"1 - ".$user_count['cnt']
            ); 
        }else{

            if (!isset($page_no)) {
                $page_no = 1;
            }

            if (!isset($records_per_page)) {
                $records_per_page = 30;
            }

            $offset = ($page_no-1) * $records_per_page;
           /* echo $offset;
            die;*/
            $this->db->select('*,DATE_FORMAT(datetime,"%d/%m/%Y") as register_date,(CASE WHEN payment_end_date > CURDATE() THEN "active" ELSE "inactive" END) as subscription_status');
            $this->db->from('user');
            $this->db->where('usertype','Restaurant');
            $this->db->order_by('id','desc');
            $this->db->limit($records_per_page,$offset);
            $query = $this->db->get();
            $result = $query->result_array();


            $total_pages = ceil($user_count['cnt'] / $records_per_page);

            if($user_count['cnt']<$records_per_page)
                $to_page=$user_count['cnt'];
            else
                $to_page=$records_per_page;
            return  array(
                'users'=>$result,
                'total_count'=>$user_count['cnt'],
                'total_pages'=>$total_pages,
                'page_no'=>$page_no,
                'page_total_text'=>($offset+1)." - ".$to_page
            ); 
        }
    }

    public function update_restaurant_visit_count($rest_id){
        $today=date('Y-m-d');
        $this->db->select('*');
        $this->db->from('get_restaurant_count');
        $this->db->where('restaurant_id', $rest_id);
        $this->db->where('visited_at',$today);
        $query = $this->db->get();
        $row = $query->row_array();
        if($row){
            $no_of_visits=$row['no_of_visits']+1;

            $this->db->where('restaurant_id', $rest_id);
            $this->db->where('visited_at',$today);
            $this->db->update('get_restaurant_count', array('no_of_visits' => $no_of_visits));
        }else{
            $this->db->insert('get_restaurant_count',array(
                'no_of_visits' => 1,
                'restaurant_id'=>$rest_id,
                'visited_at'=>$today
            ));
        }
        return  $row;       
    }

    public function getToken(){
         $token = "";
         $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
         $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
         $codeAlphabet.= "0123456789";
         $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < 16; $i++) {
            $token .= $codeAlphabet[rand(0, $max-1)];
        }

        return $token;
    }


    public function set_password($email, $password){
        $this->db->where('email', $email);
        $this->db->update('user', array('password' => $password));
    }

    public function file_get_contents_utf8($fn)
     { 
        $content = file_get_contents($fn); 
         return mb_convert_encoding($content, 'UTF-8', 
          mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true)); 
    } 
    
    public function update_authority($table,$condition,$data)
    {
        return $this->db->where($condition)->update($table, $data);
    }
}
?>