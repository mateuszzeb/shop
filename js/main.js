let message_y = 10;
let message_x = 0;
let how_many_massages = 0;
function message(text, color="green"){
    how_many_massages+=1;
    let message_div = document.createElement('div');
    message_div.style.backgroundColor = color;
    message_div.style.transform = 'translateX(-50%)';
    message_div.classList.add("message");
    message_div.style.setProperty("--td", how_many_massages*2+"00ms");
    message_y += 10;
    message_div.style.top = message_y + "px";
    message_div.style.left = "calc(50% + " + message_x + "px)";
    const close_btn = document.createElement("button");
    close_btn.innerHTML = '<i class="fa-solid fa-xmark"></i>';
    close_btn.classList.add("hide");
    close_btn.addEventListener("click", function (){
        this.parentElement.style.display = "none";
        how_many_massages-=1;
    });
    message_div.innerHTML = '<span>' + text + '</span>';
    document.body.appendChild(message_div);
    document.querySelectorAll(".message").forEach(function (m){
        m.appendChild(close_btn);
    })
}
window.addEventListener('load', function () {
    const search_input = document.querySelector(".search_input");
   
    let search_input_on = false;
    search_input.style.width = "0";
    search_input.addEventListener("keydown", function (e){
        if(e.key == 'Enter' && search_input.value != ""){
            window.location.href = "search.php?q=" + search_input.value;
        }
    })
    search_input.style.width = "100%";
    document.querySelector(".search_btn").addEventListener("click", function (){
        if(!search_input_on){
            search_input.style.transform = "scaleX(1)";
            search_input_on = true;
        }
        else if(search_input.value === ""){
            search_input.style.transform = "scaleX(0)";
            search_input_on = false;
        }
        else{
            window.location.href = "search.php?q=" + search_input.value;
        }

    });
    let mobilemenu_on = false;
    document.querySelector(".mobilemenu_btn").addEventListener("click", function (){
        var mobilemenu = document.querySelector(".mobilemenu");
        if(mobilemenu_on){
            mobilemenu.style.height = "0";
            mobilemenu_on = false;
            document.querySelector(".mobilemenu_btn").classList.remove("mobilemenu_btn_on");
        }
        else{
            mobilemenu.style.height = "300px";
            mobilemenu_on = true;
            document.querySelector(".mobilemenu_btn").classList.add("mobilemenu_btn_on");
        }
    });
    let slider_on = false;
    document.querySelectorAll(".product .img img").forEach(function (img){
        img.addEventListener("click", function (){
            const slider = document.createElement("div");
            slider.classList.add("slider");
            const switch_slider = document.createElement("div");
            switch_slider.innerHTML = '<i class="fa-solid fa-xmark"></i>';
            switch_slider.classList.add("switch_slider");
            const img_in_slider = document.createElement("img");
            img_in_slider.setAttribute("src", img.getAttribute("src"));
            slider_on = true;
            switch_slider.addEventListener("click", function (){
                this.parentElement.style.transform = "translateX(-100%)";
                document.body.style.overflow = "auto";
                setTimeout(function (){delete_element(slider)}, 500);
                slider_on = false;
            });
            slider.appendChild(img_in_slider);
            const magnifier = document.createElement("div");
            magnifier.classList.add("magnifier");
            slider.appendChild(magnifier);
            document.body.appendChild(slider);

            const zoom_button = document.createElement("button");
            zoom_button.innerHTML = '<i class="fa-solid fa-magnifying-glass-plus"></i>';
            slider.appendChild(switch_slider);
            zoom_button.classList.add("zoom_button");
            slider.appendChild(zoom_button);
            let zoom_button_on = false;
            zoom_button.addEventListener("click", function(){
                if(zoom_button_on){
                    zoom_button_on = false;
                }
                else{
                    zoom_button_on = true;
                }
            });
            slider.addEventListener("mousemove", function (e){
                magnifier.style.top = e.clientY - 100 + "px";
                magnifier.style.left = e.clientX - 100 + "px";
                magnifier.style.backgroundImage = "url('" + img.getAttribute("src") + "')";
                
                let img_pos = img_in_slider.getBoundingClientRect()
                console.log((e.clientX - img_pos.left) + "px " + Math.round(e.clientY - img_pos.top) + "px");
                
                magnifier.style.transform="scale(2)";
                magnifier.style.backgroundSize = img_pos.width + "px " + img_pos.height + "px";
                magnifier.style.display = "none";
                magnifier.style.backgroundPosition = -(e.clientX - img_pos.left -100) + "px " + -Math.round(e.clientY - img_pos.top-100) + "px";
                if(zoom_button_on){
                    magnifier.style.display = "block";
                }
                if(e.clientX < img_pos.left || e.clientX > img_pos.right || e.clientY < img_pos.top || e.clientY > img_pos.bottom){
                    magnifier.style.transform = "scale(0)";
                }
                else{
                    magnifier.style.transform = "scale(200%)";
                }
            });
        });
    });
    window.addEventListener("paste", function(e) {
        if (!document.querySelector("form #img").value){
            document.querySelector("form #img").files = e.clipboardData.files;
        }
    })
    const pices_counter = document.querySelector(".pieces_counter");
    const pieces_input = document.querySelector('#pieces');
    const pieces_span = document.querySelector(".pieces_counter .counter");
    const pieces_buttons = document.querySelectorAll(".pieces_counter .button_span");
    pieces_buttons.forEach(function(btn){
        btn.addEventListener("click", function(e) {
            if(!(this.getAttribute('add') == '-1' && parseInt(pieces_span.innerHTML) == 1)){
                pieces_span.innerHTML = parseInt(pieces_span.innerHTML) + parseInt(this.getAttribute('add'));
                pieces_input.value =  parseInt(pieces_span.innerHTML) + parseInt(this.getAttribute('add'));
            }
            
        })
    });

    const inputs = this.document.querySelectorAll("form input");
    inputs.forEach(function(inp){
        const d = document.createElement("span");
        d.innerHTML = inp.getAttribute("placeholder");
        d.classList.add("desc");
        inp.addEventListener("focus", ()=>{
            if(inp.value != "")
            insertAfter(d, inp);
        })
        inp.addEventListener("blur", ()=>{
            d.remove();
        })
        inp.addEventListener("input", ()=>{
            if(inp.value != ""){
                if (!document.body.contains(d))
                {
                    insertAfter(d, inp);
                }
               
            }
            else{
                d.remove();
            }
        });
    });

})
function delete_element(elem){
    elem.remove();
}
function insertAfter(newNode, existingNode) {
    existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
}
function shuffle(sourceArray) {
    for (var i = 0; i < sourceArray.length - 1; i++) {
        var j = i + Math.floor(Math.random() * (sourceArray.length - i));

        var temp = sourceArray[j];
        sourceArray[j] = sourceArray[i];
        sourceArray[i] = temp;
    }
    return sourceArray;
}
function padTo2Digits(num) {
    return num.toString().padStart(2, '0');
  }
function formatDate(date = new Date()) {
    return [
      date.getFullYear(),
      padTo2Digits(date.getMonth() + 1),
      padTo2Digits(date.getDate()),
    ].join('-');
  }