var Recipemenurest ={
	base_url:null,
	group_id:null,
	init:function() {
		this.bind_events();
		var data={
			per_page : 15,
			page:1,
			group_id:Recipemenurest.group_id,
			searchkey:$('#searchRecipeInput').val()
		}
		this.listRecipes(data);
	},

	bind_events :function() {
		var self=this;
		$('.btn-search').on('click',function(){
			if($('#searchRecipeInput').val()==""){
				Recipemenurest.displaywarning("Search Input should not be empty.");
				return false;
			}
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:1,
				group_id:Recipemenurest.group_id,
				searchkey:$('#searchRecipeInput').val()
			}
			Recipemenurest.listRecipes(data,'fromsearch');
		});
		$('.btn-clear-filter').on('click',function(){
			$('#searchRecipeInput').val('');
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:1,
				group_id:Recipemenurest.group_id,
				searchkey:$('#searchRecipeInput').val()
			}
			Recipemenurest.listRecipes(data,'fromsearch');
		});
		$('.a-recipe-perpage').on('click',function(){
			$(this).closest('.btn-group').find('button').attr('selected-per-page',$(this).attr('data-per'));
			if($(this).attr('data-per')=="all")
				$(this).closest('.btn-group').find('button').html($(this).html()+' items');
			else
				$(this).closest('.btn-group').find('button').html($(this).html()+' items per page');
			var data={
				per_page:$(this).attr('data-per'),
				page:1,
				group_id:Recipemenurest.group_id,
				searchkey:$('#searchRecipeInput').val()
			}
			Recipemenurest.listRecipes(data);
		});
		$('.btn-prev').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
				group_id:Recipemenurest.group_id,
				searchkey:$('#searchRecipeInput').val()
			}
			Recipemenurest.listRecipes(data);
		});
		$('.btn-next').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
				group_id:Recipemenurest.group_id,
				searchkey:$('#searchRecipeInput').val()

			}
			Recipemenurest.listRecipes(data);
		});
		$('.input-menu-forall').on('click',function(){
			if($(this).is(':checked')){
				$('.input-menu-for-restaurant').prop('checked',true);
			}else{
				$('.input-menu-for-restaurant').prop('checked',false);
			}
		});
		$('.btn-recipe-restaurant').on('click',this.saveMenuRestaurant);
	},
	saveMenuRestaurant:function(){
		var self=this;
		var ids=new Array();
		$('.input-menu-for-restaurant').each(function(){
			var disabledattr = $(this).attr('disabled');
			if (!$(this).attr('disabled')) {
				if($(this).is(':checked')){
					var id=$(this).val();
					console.log(id);
					ids.push(id);
				}
			}
		});
		
		if(ids.length==0){
			Recipemenurest.displaywarning("Please select at least on recipe.");
			return false;
		}
		swal({
			title: 'Are you sure ?',
			text: "Save Recipe for reastaurant",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, save it!',
			cancelButtonText: 'No, cancel!',
			confirmButtonClass: 'btn btn-success',
			cancelButtonClass: 'btn btn-danger',
			buttonsStyling: false
		},function () {
			$('#image-loader').show();
			var formData = {
				ids:ids
			};
			$.ajax({
				url: Recipemenurest.base_url+"restaurant/save_menu_for_restaurant",
				type:'POST',
				data:formData ,
				success: function(result){
				   if (result.status) {
						var data={
							per_page:15,
							page:1,
							group_id:Recipemenurest.group_id,
							searchkey:$('#searchRecipeInput').val()

						}
						Recipemenurest.listRecipes(data);

						Recipemenurest.displaysucess("Successfully Added.");
						window.location.href=Recipemenurest.base_url+"recipes/group_not_selected";
				   }
				   else{
						Recipemenurest.displaywarning("Something went wrong please try again");
				   }
				   $('#image-loader').hide();
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
	listRecipes:function(data,fromevent){
		if(fromevent=="fromsearch"){
			$('#image-loader').show();
		}
		$.ajax({
			url: Recipemenurest.base_url+"restaurant/menu_for_restaurants/",
			type:'POST',
			dataType: 'json',
			data: data,
			success: function(response){
				$('#image-loader').hide();
				var recipe=response.recipes;
				var html="";
				for (i in recipe) {

					html+='<tr>';
					console.log(recipe[i].isadded_for_restaurant);
						if(recipe[i].is_created!=0)
							html+='<td><input type="checkbox" class="input-menu-for-restaurant" name="recipe_id'+i+'" value="'+recipe[i].id+'" checked disabled></td>';
						else
							html+='<td><input type="checkbox" class="input-menu-for-restaurant" name="recipe_id'+i+'" value="'+recipe[i].id+'"></td>';

						html+='<td>\
							<a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;">'+recipe[i].name+'</a>\
						</td>\
					</tr>';
				}
				$('.tbody-recipes-list').html(html);
				$('.span-all-recipes').html(response.total_count);
				$('.span-page-html').html(response.page_total_text);
				if(parseInt(response.page_no)>1){
					var prev_page=parseInt(response.page_no)-1;
					$('.btn-prev').attr('page-no',prev_page);
					$('.btn-prev').removeAttr('disabled');
				}else{
					$('.btn-prev').attr('disabled',true);
					 $('.btn-prev').prop('disabled', true);
					
				}

				if(parseInt(response.page_no)<parseInt(response.total_pages)){
					var next_page=parseInt(response.page_no)+1;
					$('.btn-next').attr('page-no',next_page);
					$('.btn-next').removeAttr('disabled');
				}else{
					 $('.btn-next').attr('disabled',true);
					 $('.btn-next').prop('disabled', true);
				}
/*
				if(fromevent=="fromsearch"){
					var input, filter, table, tr, td, i, txtValue;
					input = document.getElementById("searchRecipeInput");
					filter = input.value.toUpperCase();
					table = document.getElementById("table-recipes");
					tr = table.getElementsByTagName("tr");
					for (i = 0; i < tr.length; i++) {
						td = tr[i].getElementsByTagName("td")[1];
						if (td) {
						  txtValue = td.textContent || td.innerText;
						  if (txtValue.toUpperCase().indexOf(filter) > -1) {
							tr[i].style.display = "";
						  } else {
							tr[i].style.display = "none";
						  }
						}       
					}
				}*/
			},
			error:function(){
				$('#image-loader').hide();
			}
		});
	},
	displaysucess:function(msg)
	{
		swal("Success !",msg,"success");
	},

	displaywarning:function(msg)
	{
		swal("Error !",msg,"error");
	},

};