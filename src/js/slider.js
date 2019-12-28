// global variables
const sliderView = document.querySelector('.ul-slider--view > ul'),
    sliderViewSlides = document.querySelectorAll('.ul-slider--view__slides'),
    arrowLeft = document.querySelector('.ul-slider--arrows__left'),
    arrowRight = document.querySelector('.ul-slider--arrows__right'),
    sliderLength = sliderViewSlides.length;

// sliding function
const slideMe = (sliderViewItems, isActiveItem) => {
    // update the classes
    isActiveItem.classList.remove('is-active');
    sliderViewItems.classList.add('is-active');

    // css transform the active slide position
    sliderView.setAttribute('style', 'transform:translateX(-' + sliderViewItems.offsetLeft + 'px)');
}

// before sliding function
const beforeSliding = i => {
    let isActiveItem = document.querySelector('.ul-slider--view__slides.is-active'),
        currentItem = Array.from(sliderViewSlides).indexOf(isActiveItem) + i,
        nextItem = currentItem + i,
        sliderViewItems = document.querySelector(`.ul-slider--view__slides:nth-child(${nextItem})`);

    // if nextItem is bigger than the # of slides
    if (nextItem > sliderLength) {
        sliderViewItems = document.querySelector('.ul-slider--view__slides:nth-child(1)');
    }

    // if nextItem is 0
    if (nextItem == 0) {
        sliderViewItems = document.querySelector(`.ul-slider--view__slides:nth-child(${sliderLength})`);
    }

    // trigger the sliding method
    slideMe(sliderViewItems, isActiveItem);
}

// triggers arrows
arrowRight.addEventListener('click', () => beforeSliding(1));
arrowLeft.addEventListener('click', () => beforeSliding(0));
