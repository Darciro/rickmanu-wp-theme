import theaterJS from "theaterjs";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { ScrollSmoother } from "gsap/ScrollSmoother";
import Swiper from "swiper";
import { EffectCoverflow, Navigation, Autoplay } from "swiper/modules";
import { Fancybox } from "@fancyapps/ui";

gsap.registerPlugin(ScrollTrigger, ScrollSmoother);

const smoother = ScrollSmoother.create({
    wrapper: "#smooth-wrapper",
    content: "#smooth-content",
    smooth: 1.5,
    effects: true,
});

const anchorLinks = document.querySelectorAll('a[href^="#"]');

anchorLinks.forEach(link => {
  link.addEventListener('click', (e) => {
    e.preventDefault(); // Stop native jump
    
    // Get the ID from href (e.g., "#section-1")
    const targetId = link.getAttribute('href'); 
    
    if (targetId && document.querySelector(targetId)) {
      // Scroll to element over 1.2 seconds
      smoother.scrollTo(targetId, true, 'top top'); 
    }
  });
});

const swiperContainer = document.querySelector(".projects-slider");
if (swiperContainer) {
    const slides = [...swiperContainer.querySelectorAll(".swiper-slide")];
    const wrapper = swiperContainer.querySelector(".swiper-wrapper");
    slides.sort(() => Math.random() - 0.5).forEach((s) => wrapper.appendChild(s));
}

new Swiper(".projects-slider", {
    modules: [EffectCoverflow, Navigation, Autoplay],
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    loop: true,
    slidesPerView: "auto",
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: true,
    },
    navigation: {
        nextEl: ".projects-swiper-button-next",
        prevEl: ".projects-swiper-button-prev",
    },
});

if( document.getElementById('role') ) {
    const roles = [
        'full stack developer',
        'php developer',
        'software engineer',
        'back-end developer',
        'front-end developer',
        'web developer',
        'wordpress developer',
        'cms developer',
        'e-commerce developer',
        'api integration developer',
        'technical lead',
        'tech leader',
        'team lead',
        'scrum master',
        'agile practitioner',
        'project manager',
        'consultant',
        'international consultant',
    ].sort(() => Math.random() - 0.5);

    var theater = theaterJS();

    theater
        .on('type:start, erase:start', function () {
            theater.getCurrentActor().$element.classList.add('actor__content--typing');
        })
        .on('type:end, erase:end', function () {
            theater.getCurrentActor().$element.classList.remove('actor__content--typing');
        });

    theater.addActor('role', { speed: 0.8, accuracy: 0.6 }, '#role');

    let scene = theater;
    roles.forEach(role => {
        scene = scene.addScene(`role:${role}`, 1500, -(role.length + 7), 800);
    });
    scene.addScene(theater.replay.bind(theater));

    Fancybox.bind('[data-fancybox]', {
        animated: true,
        showClass: "fancybox-zoomInUp",
        hideClass: "fancybox-fadeOut",
        Thumbs: { type: "modern" },
    });

}