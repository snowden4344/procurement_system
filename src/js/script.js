let hamburger = document.getElementById("hamburger"),
    align_center = document.getElementById("align_center"),
    report_editor = document.getElementById("report_editor"),
    sidebar = document.getElementById("sidebar");

hamburger.addEventListener("click", function (){
    sidebar.classList.toggle("visible_sidebar");
})

align_center.addEventListener("mouseover", function (){
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }
    alert(text)
})