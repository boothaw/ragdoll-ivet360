$ = jQuery;

// ─── GSAP: hide animated elements immediately to prevent flash ───────────────
if (typeof gsap !== "undefined") {
  gsap.set(
    ".entry-title h1, .entry-title p, .entry-title .buttons-ctn, .thumbnail-image",
    { opacity: 0, y: 20 },
  );
}

// ─── HAMBURGER MENU ──────────────────────────────────────────────────────────
function hamburgerMenu() {
  const hamburger = document.getElementById("hamburger");
  const mobileMenu = document.getElementById("mobile-menu-container");
  const subMenus = document.getElementsByClassName("sub-menu");
  let hamburgerOpen = false;

  hamburger.addEventListener("click", () => {
    if (!hamburgerOpen) {
      let subMenuTotals = 0;
      for (let i = 0; i < subMenus.length; i++) {
        subMenuTotals += parseInt(subMenus[i].scrollHeight);
      }
      hamburger.classList.add("open");
      hamburgerOpen = true;
      mobileMenu.style.maxHeight = mobileMenu.scrollHeight + subMenuTotals + "px";
    } else {
      hamburger.classList.remove("open");
      hamburgerOpen = false;
      mobileMenu.style.maxHeight = null;
    }
  });
}

function animateElement(e, className, duration) {
  const elements = document.getElementsByClassName(e);
  for (let i = 0; i < elements.length; i++) {
    setTimeout(() => elements[i].classList.add(className), i * parseInt(duration));
  }
}

// ─── ONLOAD ──────────────────────────────────────────────────────────────────
window.onload = function () {
  if (!document.body.classList.contains("page-template-landing")) {
    // Disable href="#" links
    const menuItems = document.getElementsByClassName("menu-item");
    for (let i = 0; i < menuItems.length; i++) {
      if (menuItems[i].children[0].href === `${window.location.href}#`) {
        menuItems[i].children[0].addEventListener("click", (e) => e.preventDefault());
      }
    }

    // Desktop nav: add dropdown arrow icons
    document.querySelectorAll("#menu .menu > li").forEach((item) => {
      if (item.querySelector("ul")) {
        const icon = document.createElement("i");
        icon.classList.add("fas", "fa-angle-down");
        item.appendChild(icon);
      }
    });

    hamburgerMenu();
    animateElement("hero-fade", "fade-in", 250);

    // Mobile nav: submenu toggles
    const mobileMenu = document.getElementById("mobile-menu-container");
    if (mobileMenu) {
      const subMenus = mobileMenu.children[0].children[0].children;
      for (let i = 0; i < subMenus.length; i++) {
        if (subMenus[i].classList.contains("menu-item-has-children")) {
          const icon = document.createElement("i");
          icon.className = "fas fa-chevron-right";
          subMenus[i].querySelector("a").after(icon);

          subMenus[i].addEventListener("click", function () {
            const isOpen = this.classList.contains("sub-menu-open");
            this.querySelector("i").classList.toggle("rotate", !isOpen);
            this.classList.toggle("sub-menu-open", !isOpen);
            this.querySelector(".sub-menu").style.maxHeight = isOpen
              ? null
              : this.querySelector(".sub-menu").scrollHeight + "px";
          });
        }
      }
    }

    if ($(".accordion").length) {
      $(".accordion .body").hide();
      $(".accordion .head").click(function () {
        $(this).next().slideToggle();
      });
    }
  }

  // ─── GSAP animations ───────────────────────────────────────────────────────
  if (typeof gsap !== "undefined") {
    const h1       = document.querySelector(".entry-title h1");
    const thumb    = document.querySelector(".thumbnail-image");
    const excerpt  = document.querySelector(".entry-title p");
    const buttons  = document.querySelector(".entry-title .buttons-ctn");

    const tl = gsap.timeline({ defaults: { ease: "power2.out", duration: 0.3 } });

    const phase1 = [h1, thumb].filter(Boolean);
    if (phase1.length) {
      tl.fromTo(phase1,  { opacity: 0, y: 20 }, { opacity: 1, y: 0 }, 0);
    }
    if (excerpt) {
      tl.fromTo(excerpt, { opacity: 0, y: 20 }, { opacity: 1, y: 0 }, 0.2);
    }
    if (buttons) {
      tl.fromTo(buttons, { opacity: 0 },         { opacity: 1 },         0.4);
    }
  }

  testimonialSlider();
  lpSlider();
  enableImageModals();
  moveEars();
  setInterval(moveEars, 4000);
};

// ─── EARS ANIMATION ──────────────────────────────────────────────────────────
const moveEars = () => {
  const earSvgs = document.querySelectorAll(".ears");
  earSvgs.forEach((svg, i) => {
    setTimeout(() => {
      earSvgs.forEach((s) => s.classList.remove("ears-active"));
      svg.classList.add("ears-active");
    }, i * 1000);
  });
};

// ─── LP SLIDER ───────────────────────────────────────────────────────────────
function lpSlider() {
  let slCounter = 0;
  const slSlideArray = $(".sl-lp-content").toArray();
  $(slSlideArray).hide();
  $(slSlideArray[0]).show();

  function setCounter(increment) {
    $(slSlideArray[slCounter]).hide();
    slCounter = increment;
    $(slSlideArray[slCounter]).show();
  }

  function changeSlides() {
    setCounter(slCounter < slSlideArray.length - 1 ? slCounter + 1 : 0);
  }

  let myTimer = setInterval(changeSlides, 5000);

  $(".sl-lp-right").click(function () {
    clearInterval(myTimer);
    myTimer = setInterval(changeSlides, 5000);
    changeSlides();
  });

  $(".sl-lp-left").click(function () {
    clearInterval(myTimer);
    setCounter(slCounter > 0 ? slCounter - 1 : slSlideArray.length - 1);
  });
}

// ─── IMAGE MODALS ─────────────────────────────────────────────────────────────
function enableImageModals() {
  document.querySelectorAll(".new-lp .hero-card img.modal-on").forEach((img) => {
    img.style.cursor = "pointer";
    img.addEventListener("click", (event) => {
      event.preventDefault();

      const dialog = document.createElement("dialog");
      const modalContainer = document.createElement("div");
      modalContainer.className = "modal-container";

      const closeBtn = document.createElement("button");
      closeBtn.textContent = "✕";
      closeBtn.className = "close-btn";
      closeBtn.addEventListener("click", (e) => { e.stopPropagation(); dialog.close(); dialog.remove(); });
      dialog.addEventListener("click", (e) => { if (e.target === dialog) { dialog.close(); dialog.remove(); } });

      modalContainer.appendChild(closeBtn);
      modalContainer.appendChild(img.cloneNode());
      dialog.appendChild(modalContainer);
      document.body.appendChild(dialog);
      dialog.showModal();
    });
  });
}

// ─── TESTIMONIAL SLIDER ──────────────────────────────────────────────────────
function testimonialSlider({ debug = false } = {}) {
  const carousel = document.querySelector(".testimonial-section .carousel-body");
  if (!carousel) return;

  const inner = carousel.querySelector(".carousel-inner");
  const arrow = document.querySelector(".testimonial-section .title-arrow");
  const cards = Array.from(carousel.getElementsByClassName("carousel-card"));
  if (!inner || !arrow || cards.length === 0) return;

  arrow.addEventListener("click", () => {
    const style = window.getComputedStyle(cards[0]);
    const increment = cards[0].offsetWidth + (parseFloat(style.marginRight) || 0);
    inner.scrollBy({ left: increment, behavior: "smooth" });
  });
}

// ─── FIRST ACCORDION CLASS (homepage) ────────────────────────────────────────
(function () {
  if (!document.body?.classList.contains("home")) return;

  function mark() {
    const first = document.querySelector(".entry-content .accordion-block");
    if (first && !first.classList.contains("first-accordion")) {
      first.classList.add("first-accordion");
    }
    return !!first;
  }

  function init() {
    if (mark()) return;
    const root = document.querySelector(".entry-content") || document.body;
    const observer = new MutationObserver((_, obs) => { if (mark()) obs.disconnect(); });
    observer.observe(root, { childList: true, subtree: true });
    setTimeout(() => observer.disconnect(), 5000);
  }

  document.readyState === "loading"
    ? document.addEventListener("DOMContentLoaded", init)
    : init();
})();
