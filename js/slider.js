document.querySelectorAll(".product .img").forEach(function (img){
    img.style.scrollBehavior = "auto";
    img.scrollLeft = 0;
    img.style.scrollBehavior = "smooth";
});

function change_image(l){
    let i = 0;
    document.querySelectorAll(".product .img").forEach(function (img){
        img.scrollLeft = (img.clientWidth*l)+img.scrollLeft;
        i+=1;
    });

}
window.addEventListener("keydown", function (e){
    if(e.key === "ArrowLeft") change_image(-1);
    if(e.key === "ArrowRight") change_image(1);
});

