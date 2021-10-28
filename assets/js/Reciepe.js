var Reciepe ={
    base_url:null,
    ingredients_data:[],
    recipe_id:null,
    alacalc_recipe_id:null,
    is_nutrition:0,
    recipe_name:null,
    name:null,
    init:function() {
        this.bind_events();
        this.loadMenuGroup();
        this.loadRecipe();
        this.loadRecipeAlacalc();
    },

    bind_events :function() {
        $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
        $('#imgupload').on('change',function(){
             $('#image-loader').show();
            $('#OpenImgUpload').attr('disabled','');
            $('#OpenImgUpload').css('pointer-events','none');
            $('#OpenImgUpload').css('cursor','no-drop');
            var self=this;
            var $form_data = new FormData();
            var inputFile = $('#imgupload');   
            if(inputFile){   
                var fileToUpload = inputFile[0].files[0];
                if (fileToUpload != 'undefined') {
                    $form_data.append('image', fileToUpload);
                }
            }
            $form_data.append('id', Reciepe.recipe_id);
            $.ajax({
                url: Reciepe.base_url+"recipes/update_recipe_image",
                type:'POST',
                data: $form_data,
                processData:false,
                contentType:false,
                cache:false,
                success: function(result){
                    $('#image-loader').hide();
                    if (result.status) { 
                        $('.recipe-image-upload').attr('data-image-src',Reciepe.base_url+result.path);
                        $(".recipe-image-upload").css("background", "url(" + Reciepe.base_url+result.path + ")");
                        $('#OpenImgUpload').css('pointer-events','all');
                        $('#OpenImgUpload').css('cursor','pointer');
                    } 
                    else{
                        if(result.msg){
                            Reciepe.displaywarning(result.msg);
                        }
                        else
                            Reciepe.displaywarning("Something went wrong please try again");
                    }
                }
            });
        });
        $('.custom-switch-indicator').trigger('click');
       
        $(".a-add-ingredient").on('click',function(){
            if($('.input-recipe-name').val()=="" || $('.input-group-name').val()==""){
                /*$('.a-add-ingredient').css('pointer-events','none');
                $('.a-add-ingredient').css('cursor','no-drop !important');*/
                Reciepe.displaywarning("Please add group name and recipe name.");
                return false;
            }
            $('.recipe-add-ingredient').toggle();
            $('.recipe-overview').toggle();
            $('.input-search-ingredient').trigger('focus');
        });
        
        $('.div-ingredient-result').on('mouseover','.lv-item',function(){
            var item_no=$(this).attr('data-add-ingredient');
            if(item_no){
                $('.info_container').hide();
                //console.log($('#info_'+item_no+'_container'));
                if($('#info_'+item_no+'_container').length == 0)
                    Reciepe.showNutrientInformation($(this).attr('data-add-ingredient'));
                else
                    $('#nutrition_breakdown').find('#info_'+item_no+'_container').show();
            }
        });

        $('.input-search-ingredient').on('keyup',function(){
            if($(this).val()=="")
                $('.row-msg-enter').show();
            Reciepe.searchIngredients($('.input-search-ingredient').val(),1);
        });
        $('.div-ingredient-result').on('click','.a-page-ingredient',function(){
            Reciepe.searchIngredients($(this).attr('query'),$(this).attr('page-no'));
        });

        $(".input-group-name").on('keydown',function(){
                $('.input-group-id').val('');
            //if($(this).val()=="")
        });
       /* $('.div-ingredient-result').on('mouseover','.lv-item',function(){
            R
        });*/
        $('.custom-switch-input').on('click',function(){
            if($(this).is(':checked'))
                $(this).val("on");
            else
                $(this).val("off");

            Reciepe.searchIngredients($('.input-search-ingredient').val(),1);
        });

        $('.div-ingredient-result').on('click','.ingredient-add-item',function(){
            var ingredient_id=$(this).attr('data-add-ingredient');
            var data=$('#info_'+ingredient_id+'_container').attr('ingredient-data');
            $('.input-search-ingredient').val('');
            //$('.input-search-ingredient').trigger('keyup');

            $(this).css("cursor", "not-allowed");
            $(this).css("pointer-events", "none");
            $('#image-loader').show();
            Reciepe.saveIngredientItems(ingredient_id,data);
        });
        $('.btn-back-ingredient').on('click',function(){
            $('.recipe-add-ingredient').toggle();
            $('.recipe-overview').toggle();
        });
        $('#current_ingredients_list').on('change','.ingredient_quantity_box',function(){
        	var data=$(this).closest('form').serialize();
        	Reciepe.updateIngredientItems(data);
        	Reciepe.calculateAllTotal();
        	$('#net_weight').trigger('change');
        });
        //$('#current_ingredients_list').on('change','.ingredient_quantity_box',this.onChangeWeightloss);
        $('#net_weight').on('change',this.calculateNetWeight);
        $('#weight_loss').on('change',this.onChangeWeightloss);
        $('.input-group-name').on('change',this.onChangeGroupName);
        $('#current_ingredients_list').on('click','.ingredient-item-delete',this.onDeleteItem);
        $('.input-recipe-name').on('change',this.updateRecipes);
        $('.btn-select-input').on('click',function(){
        	$(this).closest('.row').find('input').select();
            $(this).closest('.row').find('.input-group-id').val('');
        });
        $('.select-recommendation').on('click',function(){
        	$('.select-recommendation').removeClass('bgm-blue');
        	$(this).addClass('bgm-blue');
        	var b=$(this).attr('data-elements').toString();
        	var obj = JSON.parse(b);
        	if(!$(this).hasClass('btn-select-custom')){
        		$('.nutrient-selector').removeClass('bgm-blue');
        	}
        	for (i in obj) {
        		if(obj[i]=="show"){
        			$('.div-nutrition #'+i).show();
        			$('.div-nutrition #'+i+'-selector').addClass('bgm-blue');
        		}
        		else if(obj[i]=="toggle"){
        			$('.div-nutrition #'+i).toggle();
        		}
        		else{
        			$('.div-nutrition #'+i).hide();
        			$('.div-nutrition #'+i+'-selector').removeClass('bgm-blue');
        		}
        	}
        });
        $('#nutritional_selections_nutrients').on('click',".nutrient-selector",function(){
            var b=$(this).attr('data-elements').toString();

            var obj = JSON.parse(b);
            if($(this).hasClass('bgm-blue')){
                //$('.nutrient-selector').removeClass('bgm-blue');
                $(this).removeClass('bgm-blue');
            }else{
                $(this).addClass('bgm-blue');
            }
            for (i in obj) {
                var category=$('.div-nutrition #'+i).attr('data-category').toString();
                $('.div-nutrition #'+i).toggle();
            }
            var cnt=0;
            $('.'+category).each(function(){
                if($(this).css('display') === 'none')
                    cnt++;
            });
            if($('.'+category).length==cnt){
                $('#'+category+'_nutrient_header').hide();
            }else{
                $('#'+category+'_nutrient_header').show();
            }
        });
		/*$('#big8-recommendation').on('click',function(){
        });
		$('#vitamins-recommendation').on('click',function(){
        });
		$('#custom-recommendation').on('click',function(){
        });*/
    },
    updateRecipes:function(data){
        if($('.input-recipe-name').val()==""){
            Reciepe.displaywarning("please enter recipe name");
            $('.input-recipe-name').focus();
            $('.input-recipe-name').val(Reciepe.recipe_name);
            return false;
        }

        if($('.input-recipe-name').val()!="" && $('.input-group-name').val()!=""){
            $('.nutrition a').css('pointer-events','all');
            $('.nutrition a').css('cursor','pointer');
            //return false;
        }else{
            $('.nutrition a').css('pointer-events','none');
            $('.nutrition a').css('cursor','no-drop');
        }
       

    	var data={
    		id : Reciepe.recipe_id,
    		name:$('.input-recipe-name').val(),
    		total_weight: $('#gross_weight').val(),
    		quantity_per_serving:$('#net_weight').val(),
    		weight_loss:$('#weight_loss').val(),
    		alacalc_recipe_id:Reciepe.alacalc_recipe_id
    	}
    	$.ajax({
            url: Reciepe.base_url+"recipes/update_recipe/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                  
                }else{
                    Reciepe.displaywarning(result.msg);
                }
            }
        });
    },
    updateIngredientItems:function(data){
    	data+="&recipe_id="+Reciepe.recipe_id;
    	data+="&alacalc_recipe_id="+Reciepe.alacalc_recipe_id;

    	$.ajax({
            url: Reciepe.base_url+"recipes/update_ingredient_items/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                  
                }else{
                    Reciepe.displaywarning(result.msg);
                }
            }
        });
    },
    onDeleteItem:function(){
    	var self=this;
        var $id = $(this).attr( 'data-id' );
        var ingredient_id=$(this).attr('ingredient-id');
        var alacalc_item_id=$(this).closest('form').find('[name="alacalc_item_id"]').val();
        swal({
            title: 'Are you sure ?',
            text: "Delete Ingredient",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false
        },function () {
          	var formData = {
          		id: $id,
          		ingredient_id:ingredient_id,
          		recipe_id:Reciepe.recipe_id,
          		alacalc_recipe_id:Reciepe.alacalc_recipe_id,
          		alacalc_item_id:alacalc_item_id
          	};
         	$.ajax({
                url: Reciepe.base_url+"recipes/delete_ingredient_item",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                   		$('#current_ingredients_list').html('');
                       Reciepe.showCurrentIngredient(result['ingredient_items']);
                   }
                   else{
                        Reciepe.displaywarning("Something went wrong please try again");
                   }
                }
            });
             
        }, function (dismiss) {
            if (dismiss === 'cancel') {
                swal(
                  'Cancelled',
                  'Your record is safe :)',
                  'error'
                )
            }
        });
    },
    loadRecipeAlacalc:function(){
    	$.ajax({
            url: Reciepe.base_url+"aalcalc/get_recipe/"+Reciepe.alacalc_recipe_id,
            type:'POST',
            dataType: 'json',
            data: {},
            success: function(response){
                var result=response.result;
                if (response.status) { 
                   var nutrition=result.linked.nutrition;
                   Reciepe.loadNutrition(nutrition,result.recipes);
                   Reciepe.loadAllergens(result.linked.ingredient_items,result.linked.allergens);

                }else{
                    Reciepe.displaywarning(result.msg);
                }
            }
        });
    },
    loadAllergens:function(ingredient_items,allergens){
    	for(i in allergens){
    		$('.p-allergens-li').append(allergens[i]+',');
    	}
    	for (k in ingredient_items) {
	    	var html='<li class="border-bottom-0 p-2">\
			  		<div class="row">\
			  			<div class="col-md-3">\
			  				'+ingredient_items[k].quantity+''+ingredient_items[k].quantity_unit.desc+'\
			  			</div>\
			  			<div class="col-md-9">\
			  				'+ingredient_items[k].ingredient.Shrt_Desc+'\
			  			</div>\
			  		</div>\
			  	</li>';
			$('.ul-allgerens').append(html);
    	}
    },
    loadNutrition:function(data,recipe_details){
    	var new_data=[];
    	for(i in data){
    		var serving_qty=recipe_details.quantity_per_serving;

    		var per_serving_value=(parseFloat(data[i].value)/100)*parseFloat(serving_qty);
    		data[i].per_serving=per_serving_value.toFixed('2');
    	}
    	var html='<div class="nutritionals_table">\
			<div class="row" id="header_row">\
				<div class="col-md-5 nutrient_name"></div>\
				<div class="col-md-3 text-center trace">per 100g</div>\
				<div class="col-md-4 text-center trace">\
					per\
					<span class="serving_size">'+recipe_details.quantity_per_serving+'</span>\
					g serving\
				</div>\
			</div>\
			<div class="nutrient_selection_header" id="common_nutrient_header" style="display: block;">Main</div>\
			<div class="common row" data-energ_kj="true" data-category="common" id="Energ_KJ" style="display:block">\
				<div class="col-md-5 nutrient_name">Energy</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Energ_KJ.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Energ_KJ.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Energ_KJ.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Energ_KJ.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-energ_kcal="true" data-category="common" id="Energ_Kcal" style="display:block">\
				<div class="col-md-5 nutrient_name">Energy</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Energ_Kcal.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Energ_Kcal.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Energ_Kcal.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Energ_Kcal.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-lipid_tot="true" data-category="common" id="Lipid_Tot" style="display:block">\
				<div class="col-md-5 nutrient_name">Fat</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Lipid_Tot.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Lipid_Tot.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Lipid_Tot.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Lipid_Tot.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-fa_sat="true" data-category="common" id="FA_Sat" style="display:block">\
				<div class="col-md-5 nutrient_name">  of which saturates</div>\
				<div class="col-md-3 trace per_100">'+parseFloat(data.FA_Sat.value).toFixed('2')+'</div>\
				<div class="col-md-4 trace per_portion">'+parseFloat(data.FA_Sat.per_serving).toFixed('2')+'</div>\
			</div>\
			<div class="common row" data-fa_mono="true" data-category="common" id="FA_Mono" style="display:block">\
				<div class="col-md-5 nutrient_name">Fatty Acids Monounsaturated</div>\
				<div class="col-md-3 trace per_100">'+parseFloat(data.FA_Mono.value).toFixed('2')+'</div>\
				<div class="col-md-4 trace per_portion">'+parseFloat(data.FA_Mono.per_serving).toFixed('2')+'</div>\
			</div>\
			<div class="common row" data-fa_poly="true" data-category="common" id="FA_Poly" style="display:block">\
				<div class="col-md-5 nutrient_name">Fatty Acids Polyunsaturated</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.FA_Poly.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.FA_Poly.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.FA_Poly.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.FA_Poly.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-fa_trans="true" data-category="common" id="FA_Trans" style="display:block">\
				<div class="col-md-5 nutrient_name">Trans Fatty Acids</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.FA_Trans.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.FA_Trans.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.FA_Trans.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.FA_Trans.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-carbohydrt="true" data-category="common" id="Carbohydrt" style="display:block">\
				<div class="col-md-5 nutrient_name">Carbohydrate</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Carbohydrt.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Carbohydrt.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Carbohydrt.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Carbohydrt.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-sugar_tot="true" data-category="common" id="Sugar_Tot" style="display:block">\
				<div class="col-md-5 nutrient_name">of which sugars</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Sugar_Tot.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Sugar_Tot.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Sugar_Tot.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Sugar_Tot.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-sugar_added="true" data-category="common" id="Sugar_Added" style="display:block">\
				<div class="col-md-5 nutrient_name">Added Sugar</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Sugar_Added.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Sugar_Added.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Sugar_Added.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Sugar_Added.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-fiber_td="true" data-category="common" id="Fiber_TD" style="display:block">\
				<div class="col-md-5 nutrient_name">Fibre</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Fiber_TD.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Fiber_TD.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Fiber_TD.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Fiber_TD.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-protein="true" data-category="common" id="Protein" style="display:block">\
				<div class="col-md-5 nutrient_name">Protein</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Protein.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Protein.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Protein.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Protein.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-salt="true" data-category="common" id="Salt" style="display:block">\
				<div class="col-md-5 nutrient_name">Salt</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Salt.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Salt.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Salt.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Salt.unit+'</div>\
				</div>\
			</div>\
			<div class="common row" data-sodium="true" data-category="common" id="Sodium" style="display:block">\
				<div class="col-md-5 nutrient_name">Sodium</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Sodium.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Sodium.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Sodium.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Sodium.unit+'</div>\
				</div>\
			</div>\
			<div class="nutrient_selection_header" id="vitamins_nutrient_header" style="display: block;">Vitamins</div>\
			<div class="row vitamins" data-vit_a_iu="true" data-category="vitamins" id="Vit_A_IU" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin A IU</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_A_IU.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_A_IU.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_A_IU.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_A_IU.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_a_rae="true" data-category="vitamins" id="Vit_A_RAE" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin A RAE</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_A_RAE.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_A_RAE.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_A_RAE.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_A_RAE.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-carotene="true" data-category="vitamins" id="Carotene" style="display:block">\
				<div class="col-md-5 nutrient_name">Carotene</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Carotene.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Carotene.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Carotene.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Carotene.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-alpha_carot="true" data-category="vitamins" id="Alpha_Carot" style="display:block">\
				<div class="col-md-5 nutrient_name">Alpha Carotene</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Alpha_Carot.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Alpha_Carot.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Alpha_Carot.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Alpha_Carot.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-beta_carot="true" data-category="vitamins" id="Beta_Carot" style="display:block">\
				<div class="col-md-5 nutrient_name">Beta Carotene</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Beta_Carot.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Beta_Carot.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Beta_Carot.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Beta_Carot.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-retinol="true" data-category="vitamins" id="Retinol" style="display:block">\
				<div class="col-md-5 nutrient_name">Retinol</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Retinol.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Retinol.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Retinol.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Retinol.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-beta_crypt="true" data-category="vitamins" id="Beta_Crypt" style="display:block">\
				<div class="col-md-5 nutrient_name">Beta Cryptoxanthin</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Beta_Crypt.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Beta_Crypt.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Beta_Crypt.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Beta_Crypt.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-thiamin="true" data-category="vitamins" id="Thiamin" style="display:block">\
				<div class="col-md-5 nutrient_name">Thiamin</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Thiamin.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Thiamin.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Thiamin.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Thiamin.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-riboflavin="true" data-category="vitamins" id="Riboflavin" style="display:block">\
				<div class="col-md-5 nutrient_name">Riboflavin</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Riboflavin.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Riboflavin.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Riboflavin.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Riboflavin.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-niacin="true" data-category="vitamins" id="Niacin" style="display:block">\
				<div class="col-md-5 nutrient_name">Niacin</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Niacin.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Niacin.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Niacin.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Niacin.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-panto_acid="true" data-category="vitamins" id="Panto_Acid" style="display:block">\
				<div class="col-md-5 nutrient_name">Pantothenic Acid</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Panto_Acid.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Panto_Acid.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Panto_Acid.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Panto_Acid.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_b6="true" data-category="vitamins" id="Vit_B6" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin B6</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_B6.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_B6.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_B6.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_B6.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-folic_acid="true" data-category="vitamins" id="Folic_Acid" style="display:block">\
				<div class="col-md-5 nutrient_name">Folic Acid</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Folic_Acid.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Folic_Acid.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Folic_Acid.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Folic_Acid.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-folate_dfe="true" data-category="vitamins" id="Folate_DFE" style="display:block">\
				<div class="col-md-5 nutrient_name">Dietary Folate Equivalents</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Folate_DFE.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Folate_DFE.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Folate_DFE.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Folate_DFE.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-food_folate="true" data-category="vitamins" id="Food_Folate" style="display:block">\
				<div class="col-md-5 nutrient_name">Food Folate</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Food_Folate.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Food_Folate.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Food_Folate.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Food_Folate.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-folate_tot="true" data-category="vitamins" id="Folate_Tot" style="display:block">\
				<div class="col-md-5 nutrient_name">Folate</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Folate_Tot.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Folate_Tot.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Folate_Tot.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Folate_Tot.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_b12="true" data-category="vitamins" id="Vit_B12" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin B12</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_B12.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_B12.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_B12.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_B12.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_c="true" data-category="vitamins" id="Vit_C" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin C</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_C.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_C.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_C.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_C.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_d_iu="true" data-category="vitamins" id="Vit_D_IU" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin D IU</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_D_IU.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_D_IU.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_D_IU.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_D_IU.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_d_mcg="true" data-category="vitamins" id="Vit_D_mcg" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin D MCG</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_D_mcg.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_D_mcg.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_D_mcg.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_D_mcg.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_e="true" data-category="vitamins" id="Vit_E" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin E</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_E.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_E.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_E.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_E.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-biotin="true" data-category="vitamins" id="Biotin" style="display:block">\
				<div class="col-md-5 nutrient_name">Biotin</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Biotin.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Biotin.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Biotin.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Biotin.unit+'</div>\
				</div>\
			</div>\
			<div class="row vitamins" data-vit_k="true" data-category="vitamins" id="Vit_K" style="display:block">\
				<div class="col-md-5 nutrient_name">Vitamin K</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Vit_K.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_K.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Vit_K.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Vit_K.unit+'</div>\
				</div>\
			</div>\
			<div class="nutrient_selection_header" id="minerals_nutrient_header" style="display: block;">Minerals</div>\
			<div class="minerals row" data-calcium="true" data-category="minerals" id="Calcium" style="display:block">\
				<div class="col-md-5 nutrient_name">Calcium</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Calcium.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Calcium.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Calcium.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Calcium.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-chloride="true" data-category="minerals" id="Chloride" style="display:block">\
				<div class="col-md-5 nutrient_name">Chloride</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Chloride.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Chloride.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Chloride.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Chloride.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-choline_tot="true" data-category="minerals" id="Choline_Tot" style="display:block">\
				<div class="col-md-5 nutrient_name">Choline</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Choline_Tot.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Choline_Tot.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Choline_Tot.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Choline_Tot.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-copper="true" data-category="minerals" id="Copper" style="display:block">\
				<div class="col-md-5 nutrient_name">Copper</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Copper.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Copper.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Copper.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Copper.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-iodine="true" data-category="minerals" id="Iodine" style="display:block">\
				<div class="col-md-5 nutrient_name">Iodine</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Iodine.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Iodine.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Iodine.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Iodine.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-iron="true" data-category="minerals" id="Iron" style="display:block">\
				<div class="col-md-5 nutrient_name">Iron</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Iron.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Iron.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Iron.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Iron.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-magnesium="true" data-category="minerals" id="Magnesium" style="display:block">\
				<div class="col-md-5 nutrient_name">Magnesium</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Magnesium.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Magnesium.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Magnesium.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Magnesium.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-manganese="true" data-category="minerals" id="Manganese" style="display:block">\
				<div class="col-md-5 nutrient_name">Manganese</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Manganese.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Manganese.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Manganese.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Manganese.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-nitrogen="true" data-category="minerals" id="Nitrogen" style="display:block">\
				<div class="col-md-5 nutrient_name">Nitrogen</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Nitrogen.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Nitrogen.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Nitrogen.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Nitrogen.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-phosphorus="true" data-category="minerals" id="Phosphorus" style="display:block">\
				<div class="col-md-5 nutrient_name">Phosphorus</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Phosphorus.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Phosphorus.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Phosphorus.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Phosphorus.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-potassium="true" data-category="minerals" id="Potassium" style="display:block">\
				<div class="col-md-5 nutrient_name">Potassium</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Potassium.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Potassium.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Potassium.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Potassium.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-selenium="true" data-category="minerals" id="Selenium" style="display:block">\
				<div class="col-md-5 nutrient_name">Selenium</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Selenium.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Selenium.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Selenium.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Selenium.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-tryptophan60="true" data-category="minerals" id="Tryptophan60" style="display:block">\
				<div class="col-md-5 nutrient_name">Tryptophan/60</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Tryptophan60.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Tryptophan60.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Tryptophan60.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Tryptophan60.unit+'</div>\
				</div>\
			</div>\
			<div class="minerals row" data-zinc="true" data-category="minerals" id="Zinc" style="display:block">\
				<div class="col-md-5 nutrient_name">Zinc</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Zinc.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Zinc.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Zinc.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Zinc.unit+'</div>\
				</div>\
			</div>\
			<div class="nutrient_selection_header" id="other_nutrient_header" style="display: block;">Other</div>\
			<div class="other row" data-ash="true" data-category="other" id="Ash" style="display:block">\
				<div class="col-md-5 nutrient_name">Ash</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Ash.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Ash.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Ash.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Ash.unit+'</div>\
				</div>\
			</div>\
			<div class="other row" data-cholestrl="true" data-category="other" id="Cholestrl" style="display:block">\
				<div class="col-md-5 nutrient_name">Cholesterol</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Cholestrl.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Cholestrl.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Cholestrl.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Cholestrl.unit+'</div>\
				</div>\
			</div>\
			<div class="other row" data-lut_zea="true" data-category="other" id="Lut_Zea" style="display:block">\
				<div class="col-md-5 nutrient_name">Lutein Zeaxanthin</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Lut_Zea.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Lut_Zea.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Lut_Zea.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Lut_Zea.unit+'</div>\
				</div>\
			</div>\
			<div class="other row" data-lycopene="true" data-category="other" id="Lycopene" style="display:block">\
				<div class="col-md-5 nutrient_name">Lycopene</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Lycopene.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Lycopene.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Lycopene.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Lycopene.unit+'</div>\
				</div>\
			</div>\
			<div class="other row" data-star="true" data-category="other" id="Star" style="display:block">\
				<div class="col-md-5 nutrient_name">Starch</div>\
				<div class="col-md-3 trace per_100">'+parseFloat(data.Star.value).toFixed('2')+'</div>\
				<div class="col-md-4 trace per_portion">'+parseFloat(data.Star.per_serving).toFixed('2')+'</div>\
			</div>\
			<div class="other row" data-water="true" data-category="other" id="Water" style="display:block">\
				<div class="col-md-5 nutrient_name">Water</div>\
				<div class="col-md-3 trace per_100">\
					<div class="col-md-6 p-0 text-right nutrient_value per_100">'+parseFloat(data.Water.value).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Water.unit+'</div>\
				</div>\
				<div class="col-md-4 trace per_portion">\
					<div class="col-md-6 p-0 text-right nutrient_value per_portion">'+parseFloat(data.Water.per_serving).toFixed('2')+'</div>\
					<div class="col-md-6 p-0 nutrient_measure">'+data.Water.unit+'</div>\
				</div>\
			</div>\
		</div>';
		$('.div-nutrition').append(html);
    },
    loadRecipe:function(){
    	$.ajax({
            url: Reciepe.base_url+"recipes/get_recipe/"+Reciepe.recipe_id,
            type:'POST',
            dataType: 'json',
            data: {},
            success: function(result){
                var data=result.recipe;
                if (result.status) { 
                    for (i in data) {
                        $('[name="'+i+'"]').val(data[i]);
                    }
                    Reciepe.recipe_name=data['name'];
                    if(data['name']=="" || data['group_id']=="" || data['group_id']==null || data['name']==null){
                        $('.nutrition a').css('pointer-events','none');
                        $('.nutrition a').css('cursor','no-drop');
                    }

                    $('.recipe-image-upload').attr('data-image-src',Reciepe.base_url+data.recipe_image);
                    $(".recipe-image-upload").css("background", "url(" + Reciepe.base_url+data.recipe_image + ")");

                    if(Reciepe.is_nutrition==0){
	                    if(data['ingedient_items'].length>0){
	                        Reciepe.showCurrentIngredient(data['ingedient_items']);
	                        $('.curr-ingredient-list').toggle();
	                        $('.li-no-ingredients').toggle();
	                    }
	                    $('[name="net_weight"]').val(data.quantity_per_serving);
                    }else{
	                    $('[name="net_weight"]').val(data.quantity_per_serving);
	                    $('[name="weight_loss"]').val(data.weight_loss);
	                    $('#gross_weight').val(data.total_weight);
	                    $('#gross_weight').attr('disabled','');
                    }
                    if(data['is_sample']==1){
                        $('input').attr('disabled',true);
                        $('button').attr('disabled',true);
                        $('.ingredient-item-delete').hide();
                        $('.btn-danger').hide();
                    }
                }else{
                    Reciepe.displaywarning(result.msg);
                }
            }
        });
    },
    showCurrentIngredient:function(ingredient_items){
       for (i in ingredient_items) {
            var ingredients=ingredient_items[i];
            //console.log(ingredients);
            var k=parseInt(i)+1;
            var html='<div seq="'+k+'" id="id_item_'+ingredients['ingredient_id']+'" class="ingredient-items-div" style="display: block;">\
                <form method="post" action="javascript:;" class="form-ingredientitems-'+ingredients['ingredient_id']+'">\
                    <input type="hidden" name="id" value="'+ingredients['id']+'">\
                	<input type="hidden" name="ingredient_id" value="'+ingredients['ingredient_id']+'">\
                	<input type="hidden" name="alacalc_item_id" value="'+ingredients['alacalc_item_id']+'">\
                    <div class="row m-t-5 p-l-3 mb-2">\
                        <div class="col-md-11 border rounded p-5">\
                            <div class="row">\
                                <div class="col-md-1 p-r-0">\
                                </div>\
                                <div class="col-md-1 p-r-0">\
                                    <div class="fg-line">\
                                        <input value="'+ingredients['quantity']+'" name="quantity" class="ingredient_quantity_box form-control text-right"  data-validate-on="keyup" tabindex="3" type="text">\
                                    </div>\
                                </div>\
                                <div class="col-md-1 p-l-0 p-r-0">\
                                    <div class="fg-line">\
                                        <select class="text-left form-control" name="quantity_unit_id">';
                                        for(k in ingredients['weights']){
                                            if(ingredients['quantity_unit_id']==ingredients['weights'][k].alacalc_id)
                                                html+='<option amount="'+ingredients['weights'][k].amount+'" data-weighting="'+ingredients['weights'][k].gm_wgt+'" selected="" value="'+ingredients['weights'][k].alacalc_id+'">'+ingredients['weights'][k].description+'</option>';
                                            else
                                                html+='<option amount="'+ingredients['weights'][k].amount+'" data-weighting="'+ingredients['weights'][k].gm_wgt+'" value="'+ingredients['weights'][k].alacalc_id+'">'+ingredients['weights'][k].description+'</option>';

                                        }
                                    html+='</select>\
                                    </div>\
                                </div>\
                                <div class="col-md-9 p-t-10">\
                                    <i class="c-'+ingredients['data_source']+' fas fa-square-full"></i>';
                                if(ingredients['declaration_name']!="")
                                    html+=ingredients['declaration_name'];
                                else
                                    html+=ingredients['long_desc'];
                                html+='</div>\
                            </div>\
                        </div>\
                        <div class="col-md-1">\
                            <a href="javascript:;" class="a-red ingredient-item-delete" data-id="'+ingredients['id']+'" ingredient-id="'+ingredients['ingredient_id']+'"><i class="fas fa-trash c-usda_sr28"></i></a>\
                        </div>\
                    </div>\
                </form>\
            </div>';
            $('#current_ingredients_list').append(html);
        }
        Reciepe.calculateAllTotal();
    },
    onChangeGroupName:function(){
       if($('.input-recipe-name').val()!="" && $('.input-group-name').val()!=""){
            $('.nutrition a').css('pointer-events','all');
            $('.nutrition a').css('cursor','pointer');
            //return false;
        }else{
            $('.nutrition a').css('pointer-events','none');
            $('.nutrition a').css('cursor','no-drop');
        }
        if($('.input-group-name').val()!=""){
            if($('.input-group-id').val()==""){
                $.ajax({
                    url: Reciepe.base_url+"recipes/save_menu_group",
                    type:'POST',
                    dataType: 'json',
                    data: {group_name : $('.input-group-name').val(),recipe_id:Reciepe.recipe_id},
                    success: function(result){
                        if (result.status) { 
                            var menu_group_id=result.menu_group_id;
                            $('.input-group-id').val(menu_group_id);
                        }else{
                            Reciepe.displaywarning(result.msg);
                        }
                    }
                });
            }else{
                $.ajax({
                    url: Reciepe.base_url+"recipes/save_menu_group",
                    type:'POST',
                    dataType: 'json',
                    data: {group_name : $('.input-group-name').val(),recipe_id:Reciepe.recipe_id,group_id:$('.input-group-id').val()},
                    success: function(result){
                        if (result.status) { 
                            
                            
                        }else{
                            Reciepe.displaywarning(result.msg);
                        }
                    }
                });
            }
        }

    },
    calculateNetWeight:function(){
        if($(this).val()==""){
            var net_weight=0;

        }else{
            var net_weight=$(this).val();
        }
        var gross_total=0;
        $('#current_ingredients_list .ingredient_quantity_box').each(function(){
            gross_total=gross_total+parseFloat($(this).val());
        });

        if(gross_total==0)
            var weight_loss=0;
        else
            var weight_loss=((gross_total-parseFloat(net_weight))/gross_total)*100;
        $('#net_weight').val(parseFloat(net_weight).toFixed('2'));
        $('#weight_loss').val(parseFloat(weight_loss).toFixed('2'));
        Reciepe.updateRecipes();
    },
    onChangeWeightloss:function(){
        if($(this).val()==""){
            var weight_loss=0;
            $('#weight_loss').val(0);

        }else{
            var weight_loss=$(this).val();
        }
        var gross_total=0;
        $('#current_ingredients_list .ingredient_quantity_box').each(function(){
            gross_total=gross_total+parseFloat($(this).val());
        });

       // var weight_loss=$(this).val();
        var net_weight=gross_total-(gross_total*weight_loss)/100;
        $('#net_weight').val(parseFloat(net_weight).toFixed('2'));
        Reciepe.updateRecipes();
    },
    calculateAllTotal:function(){
        var gross_total=0;
        $('#current_ingredients_list .ingredient_quantity_box').each(function(){
            gross_total=gross_total+parseFloat($(this).val());
        });
        if(gross_total!=0){
	        var net_weight=$('#net_weight').val(); 
	        if(!net_weight)
	            net_weight=0;

	        var weight_loss=$('#weight_loss').val(); 
	        if(!weight_loss)
	            weight_loss=0;
	        
	        if(weight_loss!=0){
	            var net_weight=gross_total-(gross_total*weight_loss)/100;
            }
            if(weight_loss==0){
                var net_weight=gross_total;
            }
	        
	        $('#weight_loss').val(weight_loss);
	        $('#gross_weight').val(parseFloat(gross_total).toFixed('2'));
	        $('#net_weight').val(parseFloat(net_weight).toFixed('2'));
        }
    },
    saveIngredientItems:function(ingredient_id,ingredients){
        var ingredients=Reciepe.ingredients_data[ingredient_id];
        if(ingredients){
            $('.recipe-add-ingredient').toggle();
            $('.recipe-overview').toggle();
            Reciepe.showIngredientHTML(ingredients);
            var data={
                ingredient_data:ingredients,
                ingredient_id :ingredient_id,
                recipe_id :Reciepe.recipe_id,
                alacalc_recipe_id:Reciepe.alacalc_recipe_id,
                quantity : 0,
                quantity_unit_id: ingredients['weights'][0].id
            };
            Reciepe.saveRecipeItems(data);
        }else{
            $.ajax({
                url: Reciepe.base_url+"aalcalc/get_ingredient_data/"+ingredient_id,
                type:'POST',
                dataType: 'json',
                data: {},
                success: function(result){
                    if (result.status) { 
                        var ingredients=result['data']['ingredients'];
                        $('.recipe-add-ingredient').toggle();
                        $('.recipe-overview').toggle();
                        Reciepe.showIngredientHTML(ingredients);
                        var data={
                            ingredient_data:ingredients,
                            ingredient_id :ingredient_id,
                			alacalc_recipe_id:Reciepe.alacalc_recipe_id,
                            recipe_id :Reciepe.recipe_id,
                            quantity : 0,
                            quantity_unit_id: ingredients['weights'][0].id
                        };
                        Reciepe.saveRecipeItems(data);
                        
                    }else{
                        Reciepe.displaywarning(result.msg);
                    }
                }
           });
        }
        
    },
    saveRecipeItems:function(data){
        $.ajax({
            url: Reciepe.base_url+"recipes/save_recipe_items/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(result){
                if (result.status) { 
                    var id=result.id;
                    $('#current_ingredients_list .form-ingredientitems-'+data.ingredient_id).find('[name="id"]').val(id);
                    $('#current_ingredients_list .form-ingredientitems-'+data.ingredient_id).find('[name="alacalc_item_id"]').val(result.alacalc_item_id);
                    $('#current_ingredients_list .form-ingredientitems-'+data.ingredient_id).find('.ingredient-item-delete').attr('data-id',id);
                    $(this).css("cursor", "pointer");
                    $(this).css("pointer-events", "all");
                    $('#image-loader').hide();

                }else{
                    Reciepe.displaywarning(result.msg);
                }
            }
        });
    },
    showIngredientHTML:function(ingredients){
      
        var k=0;
        $('#current_ingredients_list .ingredient-items-div').each(function(){
            k++;
        });
        k=k+1;
        var html='<div seq="'+k+'" id="id_item_'+ingredients['id']+'" class="ingredient-items-div ingredients-items-'+k+'" style="display: block;">\
            <form method="post" action="javascript:;" class="form-ingredientitems-'+ingredients['id']+'">\
                <input type="hidden" name="id">\
                <input type="hidden" name="alacalc_item_id">\
                <input type="hidden" name="ingredient_id" value="'+ingredients['id']+'">\
                <div class="row m-t-5 p-l-3 mb-2">\
                    <div class="col-md-11 border rounded p-5">\
                        <div class="row">\
                            <div class="col-md-1 p-r-0">\
                            </div>\
                            <div class="col-md-1 p-r-0">\
                                <div class="fg-line">\
                                    <input class="ingredient_quantity_box form-control text-right" name="quantity" data-validate-on="keyup" tabindex="3" type="text" value="0" onClick="this.select();">\
                                </div>\
                            </div>\
                            <div class="col-md-1 p-l-0 p-r-0">\
                                <div class="fg-line">\
                                    <select class="text-left form-control" name="quantity_unit_id">';
                                    for(k in ingredients['weights']){
                                        if(k==0)
                                            html+='<option amount="'+ingredients['weights'][k].amount+'" data-weighting="'+ingredients['weights'][k].gm_wgt+'" selected="" value="'+ingredients['weights'][k].id+'">'+ingredients['weights'][k].desc+'</option>';
                                        else
                                            html+='<option amount="'+ingredients['weights'][k].amount+'" data-weighting="'+ingredients['weights'][k].gm_wgt+'" value="'+ingredients['weights'][k].id+'">'+ingredients['weights'][k].desc+'</option>';

                                    }
                                html+='</select>\
                                </div>\
                            </div>\
                            <div class="col-md-9 p-t-10">\
                                <i class="c-'+ingredients['data_source']+' fas fa-square-full"></i>';
                                if(ingredients['declaration_name']!="")
                                    html+=ingredients['declaration_name'];
                                else
                                    html+=ingredients['long_desc'];
                             html+='</div>\
                        </div>\
                    </div>\
                    <div class="col-md-1">\
                        <a href="javascript:;" class="a-red ingredient-item-delete" ingredient-id="'+ingredients['id']+'"><i class="fas fa-trash c-usda_sr28"></i></a>\
                    </div>\
                </div>\
            </form>\
        </div>';
        $('#current_ingredients_list').append(html);
        Reciepe.calculateAllTotal();
        $('.curr-ingredient-list').show();
        $('.li-no-ingredients').hide();
        console.log(("#current_ingredients_list .ingredient-items-div:last-child" ));
        $("#current_ingredients_list .ingredient-items-div:last-child" ).find('.ingredient_quantity_box').trigger('click').focus();
        //$('#current_ingredients_list').find('.ingredients-items-'+k).find('.ingredient_quantity_box').trigger('focus');
    },
    loadMenuGroup:function(){
        var $input = $(".input-group-name");
        $.get(Reciepe.base_url+"recipes/menu_group/", function(data){
            $input.typeahead({ 
                source:data,autoSelect: true,
                afterSelect:function(item){
                    $('.input-group-id').val(item.id);
                }
            });
        },'json');
    },
    showNutrientInformation:function(ingredient_id){
        $.ajax({
            url: Reciepe.base_url+"aalcalc/get_ingredient/"+ingredient_id,
            type:'POST',
            dataType: 'json',
            data: {},
            success: function(result){
                if (result.status) { 
                    $('.row-msg-enter').hide();
                    Reciepe.ingredients_data[result.data.ingredients.id]=result.data.ingredients;
                    $('#nutrition_breakdown').append(result.html);
                }else{
                    Reciepe.displaywarning(result.msg);
                }
            }
       });
    },
    
    searchIngredients: function(query,page_no){
        $('#nutrition_breakdown').html('');
        $('.div-ingredient-result').html('');

        $.ajax({
            url: Reciepe.base_url+"aalcalc/search_ingredients/"+query+"/"+page_no,
            type:'POST',
            dataType: 'json',
            data: {
                nai_stand:$('.input-nai-standard').val(),
                uk_standard:$('.input-uk-standard').val(),
                us_standard:$('.input-us-standard').val(),
                custom:$('.input-custom-recipes').val()
            },
            success: function(result){
                if (result.status) { 
                    $('.row-msg-enter').hide();
                    $('.div-ingredient-result').html(result.html);
                    /*$('.div-ingredient-result .lv-item').each(function(){
                        Reciepe.showNutrientInformation($(this).attr('data-add-ingredient'));
                    });*/
                }else{
                    Reciepe.displaywarning(result.msg);
                }
            }
       });
       /* $('#ingredient-results').show();*/
    },
    displaysucess:function(msg)
    {
        swal("Success !",msg,"success");
    },

    displaywarning:function(msg)
    {
        swal("Error !",msg,"error");
    }
};