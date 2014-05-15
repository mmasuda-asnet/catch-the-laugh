function saveData(id, pw){
    localStorage.setItem("id", id);
    localStorage.setItem("pw", pw);
}

function getData(){
    return localStorage.getItem("id");
   
}
