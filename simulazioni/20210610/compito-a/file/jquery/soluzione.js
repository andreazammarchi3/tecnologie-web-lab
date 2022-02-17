$(document).ready(function() {
    
    $.ajax({url: "data.json", success: function(res){
        const dati = res.data;
        console.log(dati);
        
        document.querySelectorAll("button")[0].onclick = function() {
            dati.forEach(dato => {
                let div = document.createElement("div");
                let ul = document.createElement("ul");
                Object.keys(dato).forEach(key => {
                    let li = document.createElement("li");
                    li.append(key, ": ", dato[key]);
                    ul.append(li);
                })
                $('main').append(div);
                div.append(ul);
                let up = document.createElement("button");
                up.innerHTML = "Up";
                up.onclick = function() {moveDiv(div, "up")};
                let down = document.createElement("button");
                down.innerHTML = "Down";
                down.onclick = function() {moveDiv(div, "down")};
                ul.append(up, down);
            });
        };
    }});
});

function moveDiv(div, direction) {
    var main = div.parentNode;
    if (direction == "up" && div.previousElementSibling) {
        main.insertBefore(div, div.previousElementSibling);
    } else if (direction == "down" && div.nextElementSibling) {
        main.insertBefore(div, div.nextElementSibling.nextElementSibling)
    }
}