<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Aalcalc extends MY_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->load->model('aalcalc_model');		
	}
	
	public function index() {
	}

	public function start_session(){
		$result = $this->aalcalc_model->start_session();

		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>"Something went wrong."));
		}
	}

	public function list_recipes(){
		$result = $this->aalcalc_model->list_recipes();
		
		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function delete_items(){
		//https://www.alacalc.com/api/v1/recipes/240703/ingredient_items/1845568
		$result = $this->aalcalc_model->delete_ingredient_items(1845568,240703);

		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}
	public function get_recipe($recipe_id){
		$result = $this->aalcalc_model->get_recipe($recipe_id);

		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}


	public function list_recipes_ingredient($recipe_id){
		$result = $this->aalcalc_model->list_recipes_ingredient($recipe_id);

		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function create_recipe(){
		
		$data="{
				\"recipes\":{
					\"name\":\"Untitled Recipe\",
					\"quantity_per_serving\":100,
					\"weight_loss\":0
				}
			}";

		$result = $this->aalcalc_model->create_recipe($data);
		
		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function add_ingredient_items($recipe_id){
		
			$data="{
				\"recipe_id\":240189,

				\"ingredient_items\":{
					\"ingredient_id\":1252,
					\"quantity\":100,
					\"quantity_unit_id\":0
				}
			}";
		$data=array(
			'recipe_id'=>205493,
			'id'=>1845565,
			'ingredient_items'=>array(
				'ingredient_id'=>1252,
				'quantity'=>11,
				'quantity_unit_id'=>2503
			)
		);

		$result = $this->aalcalc_model->update_ingredient_items($recipe_id,1845565,json_encode($data));
		
		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function get_recipe_labels($recipe_id){
		$result = $this->aalcalc_model->get_recipe_label($recipe_id);

		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function get_ingredient($ingredient_id){
		$result = $this->aalcalc_model->get_ingredient($ingredient_id);
		
		if($result['ingredients']){
			$html=$this->aalcalc_model->get_ingredient_html($result['ingredients']);
		}else{
			$html="";
		}
		if($result){
			if($result['ingredients']){
				$arr=explode('-', $result['ingredients']['long_desc']);
				$result['ingredients']['long_desc']=$arr[0];
			}
		    $this->json_output(array('status'=>true,'html'=>$html,'data'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function get_ingredient_data($ingredient_id){
		$result = $this->aalcalc_model->get_ingredient($ingredient_id);

		if($result){
		    $this->json_output(array('status'=>true,'data'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function list_ingredient_weights($ingredient_id){
		$result = $this->aalcalc_model->list_ingredient_weights($ingredient_id);


		if($result){
		    $this->json_output(array('status'=>true,'html'=>$html));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	public function search_ingredients($query,$page_no){
		$result = $this->aalcalc_model->search_ingredients($query,$page_no,$_POST);

		if(!empty($result['ingredients'])){
			$ingredients=$result['ingredients'];
			
			$added_ingredient=0;
			$html='<div id="ingredient-results">
				<div class="listview">
					<div class="lv-body">';
					foreach ($ingredients as $ingredient) {
						if($ingredient['data_source']=="custom"){
							$user_id=$_SESSION['user_id'];
							$arr=explode('-', $ingredient['long_desc']);
							if($arr[1]){
								$this->db->select("r.*");
						        $this->db->from('recipes r');
						        $this->db->where('r.id',$arr[1]);
						        $this->db->where('r.logged_user_id',$user_id);
						        $query10 = $this->db->get();
						        $row = $query10->row_array();
					
								if(!empty($row)){
									$html.='<a class="lv-item p-t-5 p-b-5 p-l-10 p-r-10 ingredient-add-item" data-add-ingredient="'.$ingredient['id'].'" href="#">
										<div class="media">
											<div class="pull-left" ingredient-data="'.json_encode($ingredient).'">
												<i class="c-'.$ingredient['data_source'].' fas fa-plus-circle" style="font-size:25px"></i>
											</div>
											<div class="media-body">
												<div class="lv-title">'.$ingredient['declaration_name'].'</div>
												<div class="lv-small">'.$arr[0].'</div>
											</div>
										</div>
									</a>';
									$added_ingredient++;
								}
							}
						}else{
							$html.='<a class="lv-item p-t-5 p-b-5 p-l-10 p-r-10 ingredient-add-item" data-add-ingredient="'.$ingredient['id'].'" href="#">
								<div class="media">
									<div class="pull-left" ingredient-data="'.json_encode($ingredient).'">
										<i class="c-'.$ingredient['data_source'].' fas fa-plus-circle" style="font-size:25px"></i>
									</div>
									<div class="media-body">
										<div class="lv-title">'.$ingredient['declaration_name'].'</div>
										<div class="lv-small">'.$ingredient['long_desc'].'</div>
									</div>
								</div>
							</a>';
							$added_ingredient++;
						}
					}
					$html.='</div>
				</div>
				<div id="new_ingredient_pagination">
					<div role="navigation" aria-label="Pagination" class="pagination">
						<ul class="pagination">
							<li class="prev previous_page disabled"><a href="#">←</a></li>';
							for ($i=1; $i <=5; $i++) {
								if($page_no==$i) 
									$class="active";
								else 
									$class="";
								$html.='<li class="'.$class.'">
								 	<a class="a-page-ingredient"  query="'.$query.'" page-no="'.$i.'">'.$i.'</a>
								</li>';
							
							}
							$next_page_no=$page_no+1;
							$html.='<li class="disabled"><a href="#"><span class="gap">…</span></a></li> 
							<li class="next next_page ">
							<a rel="next" class="a-page-ingredient" query="'.$query.'" page-no="'.$next_page_no.'">→</a></li>
						</ul>
					</div>
				</div>
			</div>';
			if($added_ingredient==0){
				$html='<div id="ingredient-results">
				<div class="listview">
					<div class="lv-body">
						<a class="lv-item p-t-5 p-b-5 p-l-10 p-r-10" href="#">
							<div class="media">
								<div class="media-body">
									<div class="lv-title">
										Cant find what you were looking for?
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>';
			}
		}else{
			$html='<div id="ingredient-results">
				<div class="listview">
					<div class="lv-body">
						<a class="lv-item p-t-5 p-b-5 p-l-10 p-r-10" href="#">
							<div class="media">
								<div class="media-body">
									<div class="lv-title">
										Cant find what you were looking for?
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>';
		}
		if($result){
		    $this->json_output(array('status'=>true,'html'=>$html));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}


	public function get_recipe_declarationname($recipe_id){
		$result = $this->aalcalc_model->get_recipe_declarationname($recipe_id);

		if($result){
		    $this->json_output(array('status'=>true,'result'=>$result));
		}
		else{
			$this->json_output(array('status'=>false,'msg'=>$result));
		}
	}

	
}
?>