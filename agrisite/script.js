gsap.registerPlugin(Flip);

let layouts = ["final", "plain", "columns", "grid"],
		container = document.querySelector(".container"),
		curLayout = 0; 

function nextState() {
  const state = Flip.getState(".letter, .for, .gsap", {props: "color,backgroundColor", simple: true}); 
  
  container.classList.remove(layouts[curLayout]); 
  curLayout = (curLayout + 1) % layouts.length;   
  container.classList.add(layouts[curLayout]);    

  Flip.from(state, { 
    stagger: 0.07,
    duration: 0.7,
    ease: "power2.inOut",
    spin: curLayout === 0, 
    simple: true,
    onEnter: (elements, animation) => gsap.fromTo(elements, {opacity: 0}, {opacity: 1, delay: animation.duration() - 0.1}),
    onLeave: elements => gsap.to(elements, {opacity: 0})
  });

  gsap.delayedCall(curLayout === 0 ? 3.5 : 1.5, nextState);
}

gsap.delayedCall(1, nextState);