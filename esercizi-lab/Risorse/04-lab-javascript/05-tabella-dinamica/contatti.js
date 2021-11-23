const datiTabella = [{
    "Autore": "Gino Pino",
    "Email": "ginopino@blogtw.com",
    "Argomenti": "HTML, CSS, JS"
},
{
    "Autore": "Cippa Lippa",
    "Email": "cippalippa@blogtw.com",
    "Argomenti": "PHP"
}]

function stringaToID(stringa){
    return stringa.toLowerCase().replace(/[^a-zA-Z]/g, "");
}
