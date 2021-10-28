function responsiveNav() {
    var x = document.getElementById("myTopnav");
    if (x.className === "nav-menu") {
        x.className += " responsive";
    } else {
        x.className = "nav-menu";
    }
}

function burger() {
  location.replace("./burger-shop.html")
}

function restaurant(){
    location.replace("./restaurant.html")
}

function restaurant_chain(){
    location.replace("./restaurant-chain.html")
}

function school(){
    location.replace("./school.html")
}

function why_foodnai(){
    location.replace("./why-foodnai.html")
}

function nutrition(){
    location.replace("./nutrition.html")
}

function live_demo(){
    location.replace("./live-demo.html")
}
function success(){
    location.replace("./customer-success.html")
}
function demo_button(){
    location.replace("http://www.youcloudresto.com/demo")
}
// function contact(){
//      var email=jQuery("#emailID").val();
//     console.log(email);
//     $.ajax({
//         url: "./mailer/class.phpmailer_bg.php",
//         data: email,
//         success: function(result){
//         console.log(result);
//       }});
// }

function onSocialMedia(obj)
{
    var val = jQuery(obj).html();
    var name = jQuery(val).attr("value");
    if(name == "youtube")
    {
        window.open('https://www.youtube.com/channel/UC8FOmotGfXT4LHlEXzoVeCQ'); 
    }
    else if(name == "linkedin")
    {
        window.open('https://www.linkedin.com/company/food-nai-nutrition-allergen-information/');
    }
    else if(name == "facebook")
    {
        window.open('https://www.facebook.com/foodnai');
    }
    else if(name == "twitter")
    {
        window.open('https://twitter.com/FoodNAI20');
    }
    else if(name == "skype")
    {
        window.open('https://www.skype.com/munotrupesh/ ');
    }
    else if(name == "instagram")
    {
        window.open('https://www.instagram.com/munotrupesh/ ');
    }

}

function contact_us(){
    location.replace("./contact-us.html")
}

function login(){
    location.replace("http://www.youcloudresto.com/admin/")
}

function demo_video(){
    location.replace("./live-demo.html")
}

function user(){
    location.replace("./nutrition.html")
}
function restaurant(){
    location.replace("./restaurant.html")
}
function resta_chain(){
    location.replace("./restaurant-chain.html")
}
function schl(){
    location.replace("./school.html")
}

function playVideo() {
    document.getElementById("restaurantPlayer").style.display = "block";
    vid.play(); 
    vid.currentTime = 0;
}

function closeVideo() {
    vid.pause(); 
    vid.currentTime = 0;
    document.getElementById("restaurantPlayer").style.display = "none";
}

function signup(){
    location.replace("http://www.youcloudresto.com/admin/register")
}