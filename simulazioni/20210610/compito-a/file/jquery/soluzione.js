$(document).ready(function() {
    $.ajax({url: "data.json", success: function(res){
        const dati = Object.keys(res.data[0]);
        console.log(res);
        console.log(dati);
        /*
        document.querySelectorAll("button")[0].addEventListener("click", function() {
            console.log(data[0]);
        });
        */
    }});
});