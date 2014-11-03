function loadAPic(i){
    var j=i-1;
    document.getElementById("nid"+i).innerHTML=img_html_array[j];
}
function loadAllImage(){
    for(i in img_html_array){
        document.getElementById("nid"+(parseInt(i)+1)).innerHTML=img_html_array[i];
    }
    document.getElementById("loading_button").innerHTML="";
}