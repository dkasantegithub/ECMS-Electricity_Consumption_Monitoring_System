//toggle password input
const btn = document.querySelector("#btn");
const pwd = document.querySelector("#pwd");

btn.addEventListener('click', function(){
    if(pwd.type == "text"){
        pwd.type = "password";
        btn.innerHTML = '<i class="fas fa-eye fa-lg text-secondary " aria-hidden="true"></i>';
    }else{
        pwd.type = "text";
        btn.innerHTML = '<i class="fas fa-eye-slash fa-lg text-secondary " aria-hidden="true"></i>';
    }
});

// highlight an item on sidebar when clicked
// const link_container = document.getElementById("myitem");
// const link = document.getElementsByClassName("nav-item");

// for(var i=0; i < link.length; i++){
//     link[i].addEventListener('click', function(){
//         var now =document.getElementsByClassName("active");

//         now[0].className = now[0].className.replace("active", "");
    
//         this.className += "active";
//     });
    
// }