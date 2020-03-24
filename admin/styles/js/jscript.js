//toggle password input
const btn = document.querySelector("#btn");
const pwd = document.querySelector("#pwd");
const pswd = document.querySelector("#pswd");
// const pd = document.querySelector("#pd");

btn.addEventListener('click', function(){
    if(pwd.type == "text"){
        pwd.type = "password";
        btn.innerHTML = '<i class="fas fa-eye fa-lg text-secondary " aria-hidden="true"></i>';
    }else{
        pwd.type = "text";
        btn.innerHTML = '<i class="fas fa-eye-slash fa-lg text-secondary " aria-hidden="true"></i>';
    }
});

btn.addEventListener('click', function () {
    if (pswd.type == "text") {
        pswd.type = "password";
        btn.innerHTML = '<i class="fas fa-eye fa-lg text-white " aria-hidden="true"></i>';
    } else {
        pswd.type = "text";
        btn.innerHTML = '<i class="fas fa-eye-slash fa-lg text-white " aria-hidden="true"></i>';
    }
});

// btn.addEventListener('click', function () {
//     if (pd.type == "text") {
//         pd.type = "password";
//         btn.innerHTML = '<i class="fas fa-eye fa-lg text-white " aria-hidden="true"></i>';
//     } else {
//         pd.type = "text";
//         btn.innerHTML = '<i class="fas fa-eye-slash fa-lg text-white " aria-hidden="true"></i>';
//     }
// });

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