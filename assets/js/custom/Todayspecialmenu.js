var Recipemenurest ={
	base_url:null,
	group_id:null,
	init:function() {
		this.bind_events();
		var data={
			per_page : 15,
			page:1,
			group_id:Recipemenurest.group_id
		}
		this.listRecipes(data);
	},

	bind_events :function() {
		var self=this;
		$('#searchRecipeInput').on('keyup',function(){
			if($(this).val()==""){
				var data={
					per_page:$('.dropdown-toggle').attr('selected-per-page'),
					page:1,
					group_id:Recipemenurest.group_id
				}
			}else{
				var data={
					per_page:'all',
					page:1,
					group_id:Recipemenurest.group_id
				}
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
				group_id:Recipemenurest.group_id
			}
			Recipemenurest.listRecipes(data);
		});
		$('.btn-prev').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
				group_id:Recipemenurest.group_id
			}
			Recipemenurest.listRecipes(data);
		});
		$('.btn-next').on('click',function(){
			var data={
				per_page:$('.dropdown-toggle').attr('selected-per-page'),
				page:$(this).attr('page-no'),
				group_id:Recipemenurest.group_id

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
			if($(this).is(':checked')){
				var id=$(this).val();
				ids.push(id);
			}
		});
		if(ids.length==0){
			Recipemenurest.displaywarning("Please select at least on recipe.");
			return false;
		}
		swal({
			title: 'Are you sure ?',
			text: "add recipe for Todays special ",
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
			var formData = {
				ids:ids
			};
			$.ajax({
				url: Recipemenurest.base_url+"tspecial/save_todaysspecial_menus",
				type:'POST',
				data:formData ,
				success: function(result){
				   if (result.status) {

						var data={
							per_page:15,
							page:1,
							group_id:Recipemenurest.group_id

						}
						Recipemenurest.listRecipes(data);

						Recipemenurest.displaysucess("Successfully Added.");
						window.location.href="";
				   }
				   else{
						Recipemenurest.displaywarning("Something went wrong please try again");
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
	listRecipes:function(data,fromevent){
		$.ajax({
			url: Recipemenurest.base_url+"tspecial/todays_special_menus/",
			type:'POST',
			dataType: 'json',
			data: data,
			success: function(response){
				var recipe=response.recipes;
				var html="";
				for (i in recipe) {

					html+='<tr>';
					console.log(recipe[i].is_todays_special);
						if(recipe[i].is_todays_special!=0)
							html+='<td><input type="checkbox" class="input-menu-for-restaurant" name="recipe_id'+i+'" value="'+recipe[i].id+'" checked></td>';
						else
							html+='<td><input type="checkbox" class="input-menu-for-restaurant" name="recipe_id'+i+'" value="'+recipe[i].id+'"></td>';

						html+='<td>\
							'+recipe[i].name+'\
						</td>\
					</tr>';
					//<a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;">
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
				}
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