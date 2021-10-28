// Call this from the developer console and you can control both instances
var calendars = {};

(function($) {
    "use strict"; 
    init();
    function init(){  
        loadMenugroups();
        setEventListener();
        initializeCalendar();
        //bind_events();
    }

    function setEventListener() {
       

        $('#form-add-event').on('submit',function(){
            if($('#select-menu-group').val()==""){
               displaywarning("Please select menu group");
               return false;
            }

            var is_checked=0;
            $('.checkbox-recipe').each(function(){
                if($(this).is(':checked')){
                    is_checked=1;
                }
            });
            if(is_checked==0){
                displaywarning("Please select menu item");
                return false;
            }
            $.ajax({
                url: base_url+"school/save_calendar_events/",
                type:'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(response){
                    if(response.status){
                        var result=response.event;
                        window.location.href="";
                       /* var items=[];
                        for(var i in result['items']){
                            var data={
                                id:result['items'][i].id,
                                title:result['items'][i].name
                            }
                            items.push(data);
                        }*/
                       /* calendars.clndr1.addEvents([{
                            id:result.id,
                            date: $('#selected_calendar_date').val(),
                            title: result.name,
                            items:items
                        }]);*/
                        $('#modal-add-event').modal('hide');
                        $('#select-menu-group').val('');
                        $('.div-recipes-list').html('');
                    }else{
                        if(response.msg=="Already Selected")
                            displaywarning("This recipe already selected for "+$('#selected-date-text').html());
                    }
                }
            });
        });

        $('#select-menu-group').on('change',function(){
            if($(this).val()!=""){
                $.ajax({
                    url: base_url+"school/list_recipe_groupwise/",
                    type:'POST',
                    dataType: 'json',
                    data: {group_id:$(this).val()},
                    success: function(result){
                       var html='';
                       $('.div-recipes-list').html('');
                       $('#input-recipe-count').val(result.length);
                       for(var i in result){
                            html+='<div class="col-md-4">\
                                <div class="form-group">\
                                    <label class="custom-control custom-checkbox">\
                                        <input type="checkbox" class="custom-control-input checkbox-recipe" name="recipe_chk'+i+'" value="'+result[i].id+'">\
                                        <span class="custom-control-label">'+result[i].name+'</span>\
                                    </label>\
                                </div>\
                            </div>';
                       }
                       $('.div-recipes-list').html(html);
                    }
                });
            }else{
                $('.div-recipes-list').html('');
                $('#input-recipe-count').val(0);
            }
        });

        $('.cal1').on('click','.a-delete-item',function(e){
            var item_id=$(this).closest('li').attr('item-id');
            var event_id=$(this).closest('li').attr('event-id');
            var event_data=$(this).closest('li').attr('event-data');
            var data={
                item_id:item_id,
                event_id:event_id
            }
            var self=$(this);
            $.ajax({
                url: base_url+"school/delete_calendar_item/",
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(result){
                    if(result.is_delete=="recipe")
                        self.closest('li').remove();
                    else{
                        /*calendars.clndr1.removeEvents(event_data);*/
                        self.closest('.panel').remove();
                        window.location.href="";
                        //initializeCalendar();
                    }
                }
            });
            
        });

        $('.cal1').on('click','.a-view-item',function(e){
            $('#modal-view-event').modal('show');
            var item_id=$(this).closest('li').attr('item-id');
            var event_id=$(this).closest('li').attr('event-id');
             $('#image-loader').show();
             $('.event-name').html('');
             $('.div-row-allergens').html('');
             $('.nutrient-html').html('');
             $('.recipe-image').attr('src',base_url+"assets/images/products/2.png");
           /* var event_date=$(this).closest('li').attr('event-date');
            var a=moment(event_date, "DD MMM YYYY");
            $('#selected-date-text').html(a.format('DD MMM YYYY'));
            console.log(a.format('DD MMM YYYY'));*/
            var data={
                item_id:item_id,
                event_id:event_id
            }
            var self=$(this);
            $.ajax({
                url: base_url+"school/get_recipe/"+item_id+"/"+event_id,
                type:'POST',
                dataType: 'json',
                data: data,
                success: function(response){
                    var event=response.event;
                    $('.event-name').html(response.recipe.name);
                    $('.recipe-image').attr('src',base_url+response.recipe.recipe_image);
                    $('#image-loader').hide();
                    var nutrients=response.result.linked.nutrition;

                    var image="";
                    var html='';
                    if(response.result.linked.allergens){
                        var allergens=response.result.linked.allergens;
                        for(var i in allergens){
                            switch (allergens[i]) {
                                case 'sulphites':
                                    image = "sulphites.png";
                                break;
                                case 'corn':
                                    image = "corn.png";
                                break;
                                case 'egg':
                                    image = "egg.png";
                                break;
                                case 'fish':
                                    image = "fish.png";
                                break;
                                case 'gluten':
                                    image = "gluten.png";
                                break;
                                case 'gluten_from_wheat':
                                    image = "wheat.png";
                                break;
                                case 'milk':
                                    image = "milk.png";
                                break;
                                case 'msg':
                                    image = "msg.png";
                                break;
                                case 'peanuts':
                                    image = "peanuts.png";
                                    break;
                                case 'nuts':
                                     image = "nuts.png";
                                    break;
                                case 'vegan':
                                     image = "vegan.png";
                                    break;
                                case 'mustard':
                                     image = "mustard.png";
                                    break;
                                case 'celery':
                                     image = "celery.png";
                                    break;
                                case 'soy':
                                    image = "soy.png";
                                     break;
                                case 'transfats':
                                    image = "transfats.png";
                                     break;
                                case 'wheat':
                                    image = "wheat.png";
                                    break;
                                case 'contraversal':
                                    image = "contraversal.png";
                                    break;
                            }
                            html+='<div class="col-md-2 text-center">\
                                <img src="'+base_url+'assets/images/allergens/'+image+'">\
                                <p class="mt-2 text-center">'+allergens[i]+'</p>\
                            </div>';
                        }
                    }
                    if(html=="")
                        $('.div-row-allergens').closest('.expanel').hide();
                    else{
                        $('.div-row-allergens').closest('.expanel').show();
                    }
                    $('.div-row-allergens').html(html);

                    for(var i in nutrients){
                        var serving_qty=response.recipe.quantity_per_serving;

                        var per_serving_value=(parseFloat(nutrients[i].value)/100)*parseFloat(serving_qty);
                        nutrients[i].per_serving=per_serving_value.toFixed('2');
                        $('#'+i).html(nutrients[i].per_serving+''+nutrients[i].unit);
                    }
                    $('#servingsize').html(response.recipe.quantity_per_serving+'g');
                    
                }
            });
            
        });


    }

    function initializeCalendar(){
        var thisMonth = moment().format('YYYY-MM');
        $.ajax({
            url: base_url+"school/list_calendar_events/",
            type:'POST',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(result){
                /*if(calendars.clndr1)
                    calendars.clndr1.render();*/
                calendars.clndr1 = $('.cal1').clndr({
                    events: result,
                    clickEvents: {
                        click: function (target) {
                            console.log('Cal-1 clicked: ', target);
                            $('#selected-value-text').html(target.date.format("MMMM Do YYYY"));
                        },
                        onAddDayEvent: function (target) {
                            var curr_date=moment().format("YYYY-MM-DD");
                            var selected_date=target.date.format("YYYY-MM-DD");
                            if(curr_date>selected_date){
                                displaywarning("Please select valid date");
                                return false;
                            }
                            $('#modal-add-event').modal('show');
                            $('#selected_calendar_date').val(target.date.format("YYYY-MM-DD"));
                            $('#selected-date-text').html(target.date.format("MMMM Do YYYY"));
                        },
                        today: function () {
                            console.log('Cal-1 today');
                        },
                        nextMonth: function () {
                            console.log('Cal-1 next month');
                        },
                        previousMonth: function () {
                            console.log('Cal-1 previous month');
                        },
                        onMonthChange: function () {
                            console.log('Cal-1 month changed');
                        },
                        nextYear: function () {
                            console.log('Cal-1 next year');
                        },
                        previousYear: function () {
                            console.log('Cal-1 previous year');
                        },
                        onYearChange: function () {
                            console.log('Cal-1 year changed');
                        },
                        nextInterval: function () {
                            console.log('Cal-1 next interval');
                        },
                        previousInterval: function () {
                            console.log('Cal-1 previous interval');
                        },
                        onIntervalChange: function () {
                            console.log('Cal-1 interval changed');
                        }
                    },
                    multiDayEvents: {
                        singleDay: 'date'
                    },
                    showAdjacentMonths: true,
                    adjacentDaysChangeMonth: false
                });
            }
        });
    }

   

    // The order of the click handlers is predictable. Direct click action
    // callbacks come first: click, nextMonth, previousMonth, nextYear,
    // previousYear, nextInterval, previousInterval, or today. Then
    // onMonthChange (if the month changed), inIntervalChange if the interval
    // has changed, and finally onYearChange (if the year changed).
    

    
    
   
    function loadMenugroups(){
        $.ajax({
            url: base_url+"school/list_menugroup_ajax/",
            type:'POST',
            dataType: 'json',
            data: {},
            success: function(result){
               var html='<option value="">Select Group</option>';
               for(var i in result){
                    html+='<option value="'+result[i].id+'">'+result[i].title+'</option>';
               }
               $('#select-menu-group').html(html);
            }
        });
    }

    function displaysucess(msg)
    {
        swal("Success !",msg,"success");
    }

    function displaywarning(msg)
    {
        swal("Error !",msg,"error");
    }
})(jQuery);