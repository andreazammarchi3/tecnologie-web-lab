$(document).ready(function() {
    let table = document.createElement('table');
    let tbody = document.createElement('tbody');
    let row = document.createElement('tr');
    for(i = 1; i <10; i++) {
        let row_data = document.createElement('td');
        row_data.innerHTML = i;
        row.appendChild(row_data);
    }
    tbody.appendChild(row);
    table.appendChild(tbody);
    $("main").append(table);
    table.id = "numeri";

    let selectedCell = null;
    let cells = document.querySelectorAll('.tabellone td');
    cells.forEach(e => e.addEventListener("click", function() {
        if(selectedCell == null) {
            e.style.backgroundColor = "#cacaca";
            selectedCell = e;
        } else if(selectedCell == e) {
            selectedCell.style.backgroundColor = "";
            selectedCell = null;
        } else {
            selectedCell.style.backgroundColor = "";
            selectedCell = e;
            e.style.backgroundColor = "#cacaca";
        }
    }));

    let nums = document.querySelectorAll('#numeri td');
    let string;
    nums.forEach(e => e.addEventListener("click", function() {
        if(selectedCell == null) {
            document.querySelectorAll('.log')[0].innerHTML = "Cella non selezionata";
        } else {
            selectedCell.innerHTML = e.innerHTML;
            document.querySelectorAll('.log')[0].innerHTML = "Numero inserito correttamente";
        }
    }));
 });



