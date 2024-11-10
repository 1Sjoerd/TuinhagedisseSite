// Openen en sluiten modal nuujts
var objs = document.getElementsByClassName('show-modal');

for(var i = 0; i < objs.length; i++) {
    (function(index) {
        objs[index].addEventListener("click", function() {
            document.getElementById(this.dataset.id).style.display = 'block';
            document.body.style.overflow = 'hidden';
        })
    })(i);
}

var objs = document.getElementsByClassName('hide-modal');

for(var i = 0; i < objs.length; i++) {
    (function(index) {
        objs[index].addEventListener("click", function() {
            document.getElementById(this.dataset.id).style.display = 'none';
            document.body.style.overflow = '';
        })
    })(i);
}