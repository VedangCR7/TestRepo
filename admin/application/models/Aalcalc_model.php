<?php
class Aalcalc_model extends My_Model {
	var $post=array();
    public function __construct()
    {
    	parent::__construct();
    	$this->load->database();
    	$this->post= array(
		    'email'=>'andrew@rwntrading.com',
    		'api_access_key'=>'c2bd9babd46fd572ee446cf77020f867'
		);
    }


    public function start_session(){
		$url = 'https://www.alacalc.com/api/v1/sessions';
		$ckfile=APPPATH."alacalc_cookie.txt";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$this->post);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $ckfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true); 
    }

    public function list_recipes(){

		$url = 'https://www.alacalc.com/api/v1/recipes';
		$ckfile=APPPATH."alacalc_cookie.txt";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true); 
    }


    public function get_recipe($recipe_id){

		$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id.'?include=allergens,nutrition,ingredient_items';
		$ckfile=APPPATH."alacalc_cookie.txt";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		$response = curl_exec($ch);
		/*echo "<pre>";
	    print_r(json_decode($response,true));
	    die;*/
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true); 
    }

    public function get_recipe_label($recipe_id){

		$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id.'/label.svg?design=nutrition_facts_horizontal&locale=en';
		$ckfile=APPPATH."alacalc_cookie.txt";
		$curl_log = fopen(APPPATH."../label.svg", 'w');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FILE, $curl_log);

		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true); 
    }


    public function list_recipes_ingredient($recipe_id){

		$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id.'/ingredient_items';
		$ckfile=APPPATH."alacalc_cookie.txt";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true); 
    }

    public function get_ingredient($ingredient_id){

		$url = 'https://www.alacalc.com/api/v1/ingredients/'.$ingredient_id.'?include=nutrition,costing';
		$ckfile=APPPATH."alacalc_cookie.txt";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true); 
    }

    public function list_ingredient_weights($ingedient_id){

		$url = 'https://www.alacalc.com/api/v1/ingredients/'.$ingedient_id.'/weights';
		$ckfile=APPPATH."alacalc_cookie.txt";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true); 
    }

    public function search_ingredients($query,$page_no,$post){
    	
    	$source="";
    	if(isset($post['custom']) && $post['custom']=="on")
    		$source.="&sources[]=custom";
		if(isset($post['nai_standard']) && $post['nai_standard']=="on")
			$source.="&sources[]=alacalc";
		if(isset($post['uk_standard']) && $post['uk_standard']=="on")
			$source.="&sources[]=cofids";
		if(isset($post['us_standard']) && $post['us_standard']=="on")
    		$source.="&sources[]=usda";

		$url = 'https://www.alacalc.com/api/v1/ingredients/search?locale=en&query='.$query;
		if($source!="")
			$url.=$source;
		$url.='&sources[]=bls&per_page=15&page='.$page_no;
		/*echo $url;
		die*/;
		$ckfile=APPPATH."alacalc_cookie.txt";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  json_decode($response,true);
    }


    public function get_recipe_declarationname($recipe_id){

		$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id.'/declaration_names';
		$ckfile=APPPATH."alacalc_cookie.txt";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo 'Error:' . curl_error($ch);
	    }
		curl_close ($ch);
        return  $response; 
    }


    public function create_recipe($post){
    	$url = 'https://www.alacalc.com/api/v1/recipes';
		$ckfile=APPPATH."alacalc_cookie.txt";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json'
		));
		
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo curl_error($ch);
	    }
		curl_close ($ch);
		
        return  json_decode($response,true); 
    }

    public function update_recipe($recipe_id,$post){
    	$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id;
		$ckfile=APPPATH."alacalc_cookie.txt";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json'
		));
		
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo curl_error($ch);
	    }
		curl_close ($ch);

        return  json_decode($response,true); 
    }

    public function add_ingredient_items($recipe_id,$post){
    	$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id.'/ingredient_items';
		$ckfile=APPPATH."alacalc_cookie.txt";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json'
		));
		
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo curl_error($ch);
	    }
		curl_close ($ch);
		
        return  json_decode($response,true); 
    }


    public function update_ingredient_items($recipe_id,$id,$post){
    	$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id.'/ingredient_items/'.$id;
		$ckfile=APPPATH."alacalc_cookie.txt";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json'
		));
		
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo curl_error($ch);
	    }
		curl_close ($ch);

        return  json_decode($response,true); 
    }


    public function delete_ingredient_items($id,$recipe_id){

		$url = 'https://www.alacalc.com/api/v1/recipes/'.$recipe_id.'/ingredient_items/'.$id;
		$ckfile=APPPATH."alacalc_cookie.txt";
		/*echo $url;
		die;*/
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $ckfile);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		/*curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode(array('recipe_id'=>$recipe_id,'id'=>$id)));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json'
		));*/
		
		$response = curl_exec($ch);
		if (curl_error($ch)) {
	        echo curl_error($ch);
	    }
		curl_close ($ch);
		/*echo $response;
		die;*/
        return  json_decode($response,true);
    }
   
    public function get_ingredient_html($ingredient){
    	$html='<div id="info_'.$ingredient['id'].'_container" class="info_container" style="display:none;">
			<div class="results_nutrient_container" id="info_'.$ingredient['id'].'">
				<div id="db_number">
					<div class="db_number db-text">'.$ingredient['data_source'].'-'.$ingredient['id'].'</div>
				</div>
				<ul>
					<li class="nutrient common">
						<h4>Main</h4>
					</li>
					<li class="nutrient energ_kj_id">Energy
						<div class="nutrient_quantity nutrient-Energ_KJ">';
						if(isset($ingredient['Energ_KJ']))
							 $html.=$ingredient['Energ_KJ'].' kJ';
						else
							$html.='n/a';
						$html.='
						</div>
					</li>
					<li class="nutrient energ_kcal_id">Energy
						<div class="nutrient_quantity nutrient-Energ_Kcal">
							';
							if(isset($ingredient['Energ_Kcal']))
								 $html.=$ingredient['Energ_Kcal'].'  kcal';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient lipid_tot_id">Fat
						<div class="nutrient_quantity nutrient-Lipid_Tot ">
							';
							if(isset($ingredient['Lipid_Tot']))
								 $html.=$ingredient['Lipid_Tot'].'  g';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient fa_sat_id">
					  of which saturates
						<div class="nutrient_quantity nutrient-FA_Sat">
							';
							if(isset($ingredient['FA_Sat']))
								 $html.=$ingredient['FA_Sat'].'  g';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient fa_mono_id">
						Fatty Acids Monounsaturated
						<div class="nutrient_quantity nutrient-FA_Mono">
							';
							if(isset($ingredient['FA_Mono']))
								 $html.=$ingredient['FA_Mono'].'  g';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient fa_poly_id">
						Fatty Acids Polyunsaturated
						<div class="nutrient_quantity nutrient-FA_Poly">
							';
							if(isset($ingredient['FA_Poly']))
								 $html.=$ingredient['FA_Poly'].'  g';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient fa_trans_id">
						Trans Fatty Acids
						<div class="nutrient_quantity nutrient-FA_Trans">
							';
							if(isset($ingredient['FA_Trans']))
								 $html.=$ingredient['FA_Trans'].'  g';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient carbohydrt_id">
						Carbohydrate
						<div class="nutrient_quantity nutrient-Carbohydrt">
						';
						if(isset($ingredient['Carbohydrt']))
							 $html.=$ingredient['Carbohydrt'].'  g';
						else
							$html.='n/a';
						$html.='
						</div>
					</li>
					<li class="nutrient sugar_tot_id">
						of which sugars
						<div class="nutrient_quantity nutrient-Sugar_Tot">
							';
							if(isset($ingredient['Sugar_Tot']))
								 $html.=$ingredient['Sugar_Tot'].'  g';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient sugar_added_id">
						Added Sugar
						<div class="nutrient_quantity nutrient-Sugar_Added">';
						if(isset($ingredient['Sugar_Added']))
							 $html.=$ingredient['Sugar_Added'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient fiber_td_id">
						Fibre
						<div class="nutrient_quantity nutrient-Fiber_TD">';
						if(isset($ingredient['Fiber_TD']))
							 $html.=$ingredient['Fiber_TD'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient protein_id">
						Protein
						<div class="nutrient_quantity nutrient-Protein">';
						if(isset($ingredient['Protein']))
							 $html.=$ingredient['Protein'].'  g';
						else
							$html.='n/a';
						$html.='
						</div>
					</li>
					<li class="nutrient salt_id">
						Salt
						<div class="nutrient_quantity nutrient-Salt">';
						if(isset($ingredient['Salt']))
							 $html.=$ingredient['Salt'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient sodium_id">
						Sodium
						<div class="nutrient_quantity nutrient-Sodium">
							';
							if(isset($ingredient['Sodium']))
								 $html.=$ingredient['Sodium'].'	mg';
							else
								$html.='n/a';
							$html.='
						</div>
					</li>
					<li class="nutrient vitamins">
						<h4>Vitamins</h4>
					</li>
					<li class="nutrient vit_a_iu_id">
						Vitamin A IU
						<div class="nutrient_quantity nutrient-Vit_D_IU">';
						if(isset($ingredient['Vit_D_IU']))
							 $html.=$ingredient['Vit_D_IU'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient vit_a_rae_id">
						Vitamin A RAE
						<div class="nutrient_quantity nutrient-Vit_D_mcg">';
						if(isset($ingredient['Vit_D_mcg']))
							 $html.=$ingredient['Vit_D_mcg'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient carotene_id">
						Carotene
						<div class="nutrient_quantity nutrient-Carotene">';
						if(isset($ingredient['Carotene']))
							 $html.=$ingredient['Carotene'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient alpha_carot_id">
						Alpha Carotene
						<div class="nutrient_quantity nutrient-Alpha_Carot">';
						if(isset($ingredient['Alpha_Carot']))
							 $html.=$ingredient['Alpha_Carot'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient beta_carot_id">
						Beta Carotene
						<div class="nutrient_quantity nutrient-Beta_Carot">';
						if(isset($ingredient['Beta_Carot']))
							 $html.=$ingredient['Beta_Carot'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient retinol_id">
						Retinol
						<div class="nutrient_quantity nutrient-Retinol">';
						if(isset($ingredient['Retinol']))
							 $html.=$ingredient['Retinol'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient beta_crypt_id">
						Beta Cryptoxanthin
						<div class="nutrient_quantity nutrient-Beta_Crypt">';
						if(isset($ingredient['Beta_Crypt']))
							 $html.=$ingredient['Beta_Crypt'];
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient thiamin_id">
						Thiamin
						<div class="nutrient_quantity nutrient-Thiamin">';
						if(isset($ingredient['Thiamin']))
							 $html.=$ingredient['Thiamin'].' mg';
						else
							$html.='n/a';
						$html.='
						</div>
					</li>
					<li class="nutrient riboflavin_id">
						Riboflavin
						<div class="nutrient_quantity nutrient-Riboflavin">';
						if(isset($ingredient['Riboflavin']))
							 $html.=$ingredient['Riboflavin'].' mg';
						else
							$html.='n/a';
						$html.='
						</div>
					</li>
					<li class="nutrient niacin_id">
						Niacin
						<div class="nutrient_quantity nutrient-Niacin">';
						if(isset($ingredient['Niacin']))
							 $html.=$ingredient['Niacin'].' mg';
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient panto_acid_id">
						Pantothenic Acid
						<div class="nutrient_quantity nutrient-Panto_Acid">';
						if(isset($ingredient['Panto_Acid']))
							 $html.=$ingredient['Panto_Acid'].' mg';
						else
							$html.='n/a';
						$html.='</div>
					</li>
					<li class="nutrient vit_b6_id">
						Vitamin B6
						<div class="nutrient_quantity nutrient-Vit_B6">';
						if(isset($ingredient['Vit_B6']))
							 $html.=$ingredient['Vit_B6'].' mg';
						else
							$html.='n/a';
						$html.='
						</div>
					</li>
					<li class="nutrient folic_acid_id">
					Folic Acid
					<div class="nutrient_quantity nutrient-Folic_Acid">';
					if(isset($ingredient['Folic_Acid']))
						 $html.=$ingredient['Folic_Acid'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient folate_dfe_id">
					Dietary Folate Equivalents
					<div class="nutrient_quantity nutrient-Folate_DFE">';
					if(isset($ingredient['Folate_DFE']))
						 $html.=$ingredient['Folate_DFE'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient food_folate_id">
					Food Folate
					<div class="nutrient_quantity nutrient-Food_Folate">';
					if(isset($ingredient['Food_Folate']))
						 $html.=$ingredient['Food_Folate'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient folate_tot_id">
					Folate
					<div class="nutrient_quantity nutrient-Folate_Tot">
					';
					if(isset($ingredient['Folate_Tot']))
						 $html.=$ingredient['Folate_Tot'].'μg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient vit_b12_id">
					Vitamin B12
					<div class="nutrient_quantity nutrient-Vit_B12">
					';
					if(isset($ingredient['Vit_B12']))
						 $html.=$ingredient['Vit_B12'].'μg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient vit_c_id">
					Vitamin C
					<div class="nutrient_quantity nutrient-Vit_C">
					';
					if(isset($ingredient['Vit_C']))
						 $html.=$ingredient['Vit_C'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient vit_d_iu_id">
					Vitamin D IU
					<div class="nutrient_quantity nutrient-Vit_D_IU">';
					if(isset($ingredient['Vit_D_IU']))
						 $html.=$ingredient['Vit_D_IU'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient vit_d_mcg_id">
					Vitamin D MCG
					<div class="nutrient_quantity nutrient-Vit_D_mcg">';
					if(isset($ingredient['Vit_D_mcg']))
						 $html.=$ingredient['Vit_D_mcg'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient vit_e_id">
					Vitamin E
					<div class="nutrient_quantity nutrient-Vit_E">';
					if(isset($ingredient['Vit_E']))
						 $html.=$ingredient['Vit_E'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient biotin_id">
					Biotin
					<div class="nutrient_quantity nutrient-Biotin">
					';
					if(isset($ingredient['Biotin']))
						 $html.=$ingredient['Biotin'].' μg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient vit_k_id">
					Vitamin K
					<div class="nutrient_quantity nutrient-Vit_K">';
					if(isset($ingredient['Vit_K']))
						 $html.=$ingredient['Vit_K'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient minerals">
					<h4>Minerals</h4>
					</li>
					<li class="nutrient calcium_id">
					Calcium
					<div class="nutrient_quantity nutrient-Calcium">
					';
					if(isset($ingredient['Calcium']))
						 $html.=$ingredient['Calcium'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient chloride_id">
					Chloride
					<div class="nutrient_quantity nutrient-Chloride">
					';
					if(isset($ingredient['Chloride']))
						 $html.=$ingredient['Chloride'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient choline_tot_id">
					Choline
					<div class="nutrient_quantity nutrient-Choline_Tot">';
					if(isset($ingredient['Choline']))
						 $html.=$ingredient['Choline'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient copper_id">
					Copper
					<div class="nutrient_quantity nutrient-Copper">
					';
					if(isset($ingredient['Copper']))
						 $html.=$ingredient['Copper'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient iodine_id">
					Iodine
					<div class="nutrient_quantity nutrient-Iodine">';
					if(isset($ingredient['Iodine']))
						 $html.=$ingredient['Iodine'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient iron_id">
					Iron
					<div class="nutrient_quantity nutrient-Iron">
					';
					if(isset($ingredient['Iron']))
						 $html.=$ingredient['Iron'].' mg';
					else
						$html.='n/a';
					$html.='
					
					</div>
					</li>
					<li class="nutrient magnesium_id">
					Magnesium
					<div class="nutrient_quantity nutrient-Magnesium">
					';
					if(isset($ingredient['Magnesium']))
						 $html.=$ingredient['Magnesium'].' mg';
					else
						$html.='n/a';
					$html.='
					
					</div>
					</li>
					<li class="nutrient manganese_id">
					Manganese
					<div class="nutrient_quantity nutrient-Manganese">
					';
					if(isset($ingredient['Manganese']))
						 $html.=$ingredient['Manganese'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient nitrogen_id">
					Nitrogen
					<div class="nutrient_quantity nutrient-Nitrogen">
					';
					if(isset($ingredient['Nitrogen']))
						 $html.=$ingredient['Nitrogen'].' g';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient phosphorus_id">
					Phosphorus
					<div class="nutrient_quantity nutrient-Phosphorus">
					';
					if(isset($ingredient['Phosphorus']))
						 $html.=$ingredient['Phosphorus'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient potassium_id">
					Potassium
					<div class="nutrient_quantity nutrient-Potassium">
					';
					if(isset($ingredient['Potassium']))
						 $html.=$ingredient['Potassium'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient selenium_id">
					Selenium
					<div class="nutrient_quantity nutrient-Selenium">
					';
					if(isset($ingredient['Selenium']))
						 $html.=$ingredient['Selenium'].' μg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient tryptophan60_id">
					Tryptophan/60
					<div class="nutrient_quantity nutrient-Tryptophan60">
					';
					if(isset($ingredient['Tryptophan60']))
						 $html.=$ingredient['Tryptophan60'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient zinc_id">
					Zinc
					<div class="nutrient_quantity nutrient-Zinc">
					';
					if(isset($ingredient['Zinc']))
						 $html.=$ingredient['Zinc'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient other">
					<h4>Other</h4>
					</li>
					<li class="nutrient ash_id">
					Ash
					<div class="nutrient_quantity nutrient-Ash">';
					if(isset($ingredient['Ash']))
						 $html.=$ingredient['Ash'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient cholestrl_id">
					Cholesterol
					<div class="nutrient_quantity nutrient-Cholestrl">
					';
					if(isset($ingredient['Cholestrl']))
						 $html.=$ingredient['Cholestrl'].' mg';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient lut_zea_id">
					Lutein Zeaxanthin
					<div class="nutrient_quantity nutrient-Lut_Zea">';
					if(isset($ingredient['Lut_Zea']))
						 $html.=$ingredient['Lut_Zea'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient lycopene_id">
					Lycopene
					<div class="nutrient_quantity nutrient-Lycopene">';
					if(isset($ingredient['Lycopene']))
						 $html.=$ingredient['Lycopene'];
					else
						$html.='n/a';
					$html.='</div>
					</li>
					<li class="nutrient star_id">
					Starch
					<div class="nutrient_quantity nutrient-Star">
					';
					if(isset($ingredient['Star']))
						 $html.=$ingredient['Star'].' g';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
					<li class="nutrient water_id">
					Water
					<div class="nutrient_quantity nutrient-Water">
					';
					if(isset($ingredient['Water']))
						 $html.=$ingredient['Water'].' g';
					else
						$html.='n/a';
					$html.='
					</div>
					</li>
				</ul>
				<div id="allergens">
					<h4>Allergens</h4>
					<ul>';
					if($ingredient['gluten_from_wheat']!="" || $ingredient['gluten_from_barley']!="" || $ingredient['gluten_from_oats']!="" || $ingredient['gluten_from_rye']!="" || $ingredient['gluten_from_millet']!="")
							$html.='<li class="nutrient allergen-gluten">Gluten</li>';
						if($ingredient['gluten_from_wheat']!="")
							$html.='<li class="nutrient allergen-gluten_from_wheat">Wheat</li>';
						if($ingredient['gluten_from_barley']!="")
							$html.='<li class="nutrient allergen-gluten_from_barley">Barley</li>';
						if($ingredient['gluten_from_oats']!="")
							$html.='<li class="nutrient allergen-gluten_from_oats">Oats</li>';
						if($ingredient['gluten_from_rye']!="")
							$html.='<li class="nutrient allergen-gluten_from_rye">Rye</li>';
						if($ingredient['gluten_from_millet']!="")
							$html.='<li class="nutrient allergen-gluten_from_millet">Millet</li>';
						if($ingredient['milk']!="")
							$html.='<li class="nutrient allergen-milk">Milk</li>';
						if($ingredient['egg']!="")
							$html.='<li class="nutrient allergen-egg">Egg</li>';
						if($ingredient['nuts']!="")
							$html.='<li class="nutrient allergen-nuts">Nuts</li>';
						if($ingredient['peanuts']!="")
							$html.='<li class="nutrient allergen-peanuts">Peanuts</li>';
						if($ingredient['soya']!="")
							$html.='<li class="nutrient allergen-soya">Soya</li>';
						if($ingredient['fish']!="")
							$html.='<li class="nutrient allergen-fish">Fish</li>';
						if($ingredient['crustaceans']!="")
							$html.='<li class="nutrient allergen-crustaceans">Crustaceans</li>';
						if($ingredient['mustard']!="")
							$html.='<li class="nutrient allergen-mustard">Mustard</li>';
						if($ingredient['celery']!="")
							$html.='<li class="nutrient allergen-celery">Celery</li>';
						if($ingredient['sulphites']!="")
						$html.='<li class="nutrient allergen-sulphites">Sulphites : <span 
						class="allergen-sulphites_ppm"></span></li>';
						if($ingredient['sulphites']!="")
							$html.='<li class="nutrient allergen-sesame">Sesame</li>';
						if($ingredient['lupin']!="")
							$html.='<li class="nutrient allergen-lupin">Lupin</li>';
						if($ingredient['molluscs']!="")
							$html.='<li class="nutrient allergen-molluscs">Molluscs</li>';
					$html.='</ul>
				</div>
			</div>
		</div>';
		/*<div id="info_'.$ingredient['id'].'_container" class="info_container loading" style="display: none;"></div>*/
		return $html;
    }
   
}
?>