/*slider*/
var b = document.body;
if (b.classList.contains('home')) {
    let sliderImages = document.querySelectorAll('.slide');
    let right = document.querySelector('#right');
    let left = document.querySelector('#left');
    let now = 0;

    // არესეტებს ყველაფერს 
    function reset() {
        for (var i = 0; i < sliderImages.length; i++) {
            sliderImages[i].style.display = "none";
        }
    }

    // გამოაჩენს პირველ სლაიდს

    function startSlider() {
        reset();
        sliderImages[0].style.display = 'block';

    }

    // წინა სლაიდზე გადასვლა 
    function slideLeft() {
        reset();
        sliderImages[now - 1].style.display = 'block';
        now--;
    }

    // მომდევნოზე გადასვლა 
    function slideRight() {
        reset();
        sliderImages[now + 1].style.display = 'block';
        now++;
    }

    // მარცხენა ისარზე დაჭერა 

    left.addEventListener('click', goLeft);

    function goLeft() {
        if (now === 0) {
            now = sliderImages.length;
        }
        slideLeft();
    }
    // მარჯვენა ისარზე დაჭერა 
    right.addEventListener('click', goRight);

    function goRight() {
        if (now === sliderImages.length - 1) {
            now = -1;
        }
        slideRight();
    }

    startSlider();
}

//our recipes' height changin on click
var descrBtns = document.querySelectorAll('.descr-btn');
var shop = document.querySelector('.shop');
descrBtns.forEach(function(item) {
    item.onclick = function(e) {
        let parent = e.target.parentElement;
        let displayP = parent.querySelector('.descr');
        displayP.classList.toggle('comon');
        // shop.classList.toggle('mtop')
        if (displayP.classList.contains('comon')) {
            item.innerHTML = "იხილეთ ნაკლები";
        } else {
            item.innerHTML = "იხილეთ სრულად";
        }

    }
})

//shop product flip on click
var btns = document.querySelectorAll('.flip');

btns.forEach(item => {

    item.onclick = function(e) {
        let parent = e.target.parentElement;
        var firstSide = parent.querySelector('.first_side');
        var secondSide = parent.querySelector('.second_side');
        firstSide.classList.toggle('none');
        secondSide.classList.toggle('slide_start');
        firstSide.classList.add('slide_start');
        firstSide.style.border = 'none'
    }
})


//filter recipes
let filterRecipes = document.querySelectorAll('.filter-r');
let recipes = document.querySelectorAll('.rec')
let dough = document.querySelectorAll('.dough');
let meat = document.querySelectorAll('.meat');
let dessert = document.querySelectorAll('.dessert');
let drinking = document.querySelectorAll('.drinking');

filterRecipes.forEach(function(e, index) {
    e.addEventListener('click', function() {
        for (var i = 0; i < recipes.length; i++) {
            recipes[i].style.display = 'none'
        }

        if (index == 0) {
            for (var i = 0; i < dough.length; i++) {
                dough[i].style.display = "block";
            }

        }
        if (index == 1) {
            for (var i = 0; i < meat.length; i++) {
                meat[i].style.display = "block";
            }

        }
        if (index == 2) {
            for (var i = 0; i < dessert.length; i++) {
                dessert[i].style.display = "block";
            }

        }
        if (index == 3) {
            for (var i = 0; i < drinking.length; i++) {
                drinking[i].style.display = "block";
            }

        }
    })
})

//jquery

$(document).ready(function() {
    $("#checkbtn").click(function() {
        $("#menu").toggle();
    });
});