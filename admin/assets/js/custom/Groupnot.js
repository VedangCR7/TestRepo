var Groupnot ={
    base_url:null,
    group_id:null,
    init:function() {
        this.bind_events();
        var data={
            per_page : 30,
            page:1,
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
                }
            }else{
                var data={
                    per_page:'all',
                    page:1,
                }
            }
            Groupnot.listRecipes(data,'fromsearch');

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
                group_id:Groupnot.group_id
            }
            Groupnot.listRecipes(data);
        });
        $('.btn-prev').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),
            }
            Groupnot.listRecipes(data);
        });
        $('.btn-next').on('click',function(){
            var data={
                per_page:$('.dropdown-toggle').attr('selected-per-page'),
                page:$(this).attr('page-no'),

            }
            Groupnot.listRecipes(data);
        });
        $('.tbody-recipes-list').on('click','.btn-delete-recipe',this.deleteRecipe);
    },
    deleteRecipe:function(){
        var self=this;
        var data_id=$(this).attr('data-id');
        var alacalc_recipe_id=$(this).attr('alacalc-recipe-id');
        swal({
            title: 'Are you sure ?',
            text: "Delete Recipe",
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
                id: data_id,
                alacalc_recipe_id:alacalc_recipe_id
            };
            $.ajax({
                url: Groupnot.base_url+"recipes/delete_recipe",
                type:'POST',
                data:formData ,
                success: function(result){
                   if (result.status) {
                    var data={
                        per_page:30,
                        page:1,

                    }
                       Groupnot.listRecipes(data);
                   }
                   else{
                        Groupnot.displaywarning("Something went wrong please try again");
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
            url: Groupnot.base_url+"recipes/list_groupnot_recipes/",
            type:'POST',
            dataType: 'json',
            data: data,
            success: function(response){
                var recipe=response.recipes;
                var html="";
                for (i in recipe) {

                    html+='<tr>\
                        <td>\
                            <a href="'+Groupnot.base_url+'recipes/create/'+recipe[i].id+'" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" style="color:#000;">'+recipe[i].name+'</a>\
                        </td>\
                        <td>'+recipe[i].recipe_date+'</td>';
                    html+='<td><a href="javascript:;" data-id="'+recipe[i].id+'" alacalc-recipe-id="'+recipe[i].alacal_recipe_id+'" class="btn-delete-recipe"><i class="fas fa-trash c-usda_sr28"></i></a></td>';
                    html+='</tr>';
                }
                if(recipe.length>0){
                     Groupnot.displaywarningmsg("Please select group for currently added recipes.");
                 }else{
                    window.location.href=Groupnot.base_url+'recipes/overview';
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
                        td = tr[i].getElementsByTagName("td")[0];
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
     displaywarningmsg:function(msg)
    {
        swal("Warning !",msg,"warning");
    },

};