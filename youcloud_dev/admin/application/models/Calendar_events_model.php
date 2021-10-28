<?php
class Calendar_events_model extends My_Model {
    var $calendar_date;
    var $group_id;
    var $recipes_id;
    var $logged_user_id;
    var $is_delete;
    var $tablename="calendar_events";
    var $fields=array('calendar_date','group_id','recipes_id','logged_user_id','is_delete');
    public function __construct()
    {
    	$this->load->database();
    }


    public function get_calendar_event($id){
        $this->db->select("c.*,m.title as group_name");
        $this->db->from('calendar_events c');
        $this->db->join('menu_group m','m.id=c.group_id AND m.is_active=1');
        //$this->db->where('c.logged_user_id',$_SESSION['user_id']);
        $this->db->where('c.is_delete',0);
        $this->db->where('c.id',$id);
        $query = $this->db->get();
        $data = $query->row_array();
        return $data;
    }

     public function check_calendar_event($recipe_ids){
        $this->db->select('*');
        $this->db->from($this->tablename);
        $this->db->where('calendar_date',$this->calendar_date);
        $this->db->where('group_id',$this->group_id);
        $this->db->where('is_delete',0);
        $query=$this->db->get();
        if($query->num_rows()==0)
            return array("status"=>"not");
        else{
            $data = $query->row_array();
            $exist_recipe_ids=json_decode($data['recipes_id']);
            foreach ($exist_recipe_ids as $id) {
                if(in_array($id, $recipe_ids)){
                    return  array("status"=>"recipeexist");
                }
            }
            return array("status"=>"exist","id"=>$data['id'],"exist_recipe_ids"=>$exist_recipe_ids);
        }
        
    }

    public function get_calendar_events($id){
        $this->db->select("c.*,m.title as name");
        $this->db->from('calendar_events c');
        $this->db->join('menu_group m','m.id=c.group_id AND m.is_active=1');
        //$this->db->where('c.logged_user_id',$_SESSION['user_id']);
        $this->db->where('c.is_delete',0);
        $this->db->where('c.id',$id);
        $query = $this->db->get();
        $data = $query->row_array();

        $recipe_ids=json_decode($data['recipes_id']);
        foreach ($recipe_ids as $recipe_id) {
            $this->db->select("*");
            $this->db->from('recipes r');
            $this->db->where('r.is_delete',0);
            $this->db->where('r.id',$recipe_id);
            $query = $this->db->get();
            $result = $query->row_array();
            $data['items'][]=$result;
        }
        return  $data;       
    }


    public function list_calendar_events(){
        $this->db->select("c.*,m.title as group_name");
        $this->db->from('calendar_events c');
        $this->db->join('menu_group m','m.id=c.group_id AND m.is_active=1');
        $this->db->where('c.logged_user_id',$_SESSION['user_id']);
        $this->db->where('c.is_delete',0);
        $query = $this->db->get();
        $result = $query->result_array();
        $events=array();
        foreach ($result as $row) {
            $event=array();
            $event['id']=$row['id'];
            $event['date']=$row['calendar_date'];
            $event['title']=$row['group_name'];
            $event['items']=array();
            $recipe_ids=json_decode($row['recipes_id']);
            foreach ($recipe_ids as $recipe_id) {
                $this->db->select("*");
                $this->db->from('recipes r');
                $this->db->where('r.is_delete',0);
                $this->db->where('r.id',$recipe_id);
                $query = $this->db->get();
                $result = $query->row_array();
                $event['items'][]=array(
                    'id'=>$result['id'],
                    'title'=>$result['name']
                );
            }
            $events[]=$event;
        }
        return  $events;       
    }

}
?>