const counters = document.querySelectorAll(".counter");

const startCounter = (entry) => {

    if (!entry.isIntersecting) return;

    const counter = entry.target;
    const target = +counter.dataset.target;

    let count = 0;

    const update = () => {

        count += target / 60;

        if (count < target) {
            counter.innerText = Math.ceil(count);
            requestAnimationFrame(update);
        } else {
            counter.innerText = target;
        }
    };

    update();
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(startCounter);
});

counters.forEach(counter => observer.observe(counter));




const form = document.querySelector(".contact-form");

form.addEventListener("submit", (event) => {

    event.preventDefault();

    alert("Заявка успешно отправлена!");

    form.reset();

});