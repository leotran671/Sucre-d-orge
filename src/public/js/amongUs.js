let amongUs = document.querySelector("#AmongUs");
let white = document.querySelector("#white");
white.addEventListener('mouseover', function(){
  amongUs.style.visibility="visible";
}
);
white.addEventListener('mouseleave', function(){
  amongUs.style.visibility="hidden";
});