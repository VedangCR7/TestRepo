var IncentiveList ={
    base_url:null,
    init:function() {
        this.bind_events();
    },

    bind_events :function() {
        var self=this;

        $('#update_non_captain_incentive').click(function(){
            $('#image-loader').show();
            usertype = $('#master_menu').val();
            incentives_price = $('#incentive_per').val();
            $.ajax({
                url: IncentiveList.base_url+"Manage_Incentive_master_controller/update_non_captain_incentive",
                type:'POST',
                dataType: 'json',
                data: {
                    category_name : usertype,
                    incentives_price:incentives_price
                },
                success: function(result)
                {
                    if(result.status){
                        $('#image-loader').hide();
                        IncentiveList.displaysucess('Incentive save successfully');
                    }else{
                        $('#image-loader').hide();
                        IncentiveList.displaysucess('something went wrong');
                    }
                }
            });
        });

        $('#master_menu').change(function(){
            usertype = $(this).val();
            if(usertype == 'Restaurant manager'){
                $('#captain').show();
                $('#non_captain').hide();
                location.reload();
            }else{
                $('#usertypeincentive').html( $(this).val()+' Incentives ( % )');
                $('#non_captain').show();
                $('#captain').hide();
                $.ajax({
                    url: IncentiveList.base_url+"Manage_Incentive_master_controller/get_non_captain_incentive",
                    type:'POST',
                    dataType: 'json',
                    data: {
                        category_name : usertype
                    },
                    success: function(result)
                    {
                        $('#image-loader').hide();
                        $('#incentive_per').val(result.incentives_price);
                    }
                });
            }
        });


        $('#save_recipe_incentive').click(function(){
            var incentives_price = [];
            var values = $("input[name='recipe_incentive[]']").map(function(){
                incentives_price.push($(this).val());
            }).get();

            var menu_id = [];
            var values = $("input[name='recipe_id[]']").map(function(){
                menu_id.push($(this).val());
            }).get();

            $.ajax({
                url: IncentiveList.base_url+"Manage_Incentive_master_controller/save_captain_incentive",
                type:'POST',
                dataType: 'json',
                data: {
                    incentives_price:incentives_price,
                    menu_id:menu_id
                },
                success: function(result)
                {
                    if(result.status){
                        $('#image-loader').hide();
                        IncentiveList.displaysucess('Incentive save successfully');
                        location.reload();
                    }else{
                        $('#image-loader').hide();
                        IncentiveList.displaysucess('something went wrong');
                    }
                }
            });
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