const pauseAnimations = (buttonId) => {
	// Get the button
	const pauseAnimationsBtn = document.getElementById(buttonId);

	// Run if the button exists
	if (pauseAnimationsBtn) {
		// Set OS's reduced motion state when local storage isn't present
		!localStorage.animationsPaused ? setReducedMotionState() : null;

		// Update HTML data attribute
		switchAnimationPreference(localStorage.animationsPaused, 'data-pause-animations');

		// Get all initially autoplaying videos
		const autoplayVideos = document.querySelectorAll('video[autoplay]');

		// Set button initial state
		localStorage.animationsPaused ? pauseAnimationsBtn.setAttribute('aria-checked', localStorage.animationsPaused) : '';

		// toggle animation pause if active
		localStorage.animationsPaused == 'true' ? toggleAutoplay(autoplayVideos) : null;

		// Watch for button click
		pauseAnimationsBtn.addEventListener('click', () => {
			// Switch aria-checked to updated value
			switchAnimations(pauseAnimationsBtn);

			// Update local storage value of animationPaused
			localStorage.animationsPaused = pauseAnimationsBtn.getAttribute("aria-checked");

			// Update HTML data attribute
			switchAnimationPreference(localStorage.animationsPaused, 'data-pause-animations');

			toggleAutoplay(autoplayVideos);
		});
	}
};

// Toggles the checked state and <html> data attribute
const switchAnimations = (el) => {
	// Switch the aria-checked state
	el.getAttribute("aria-checked") == "true" ? el.setAttribute("aria-checked", "false") : el.setAttribute("aria-checked", "true");
};

// Toggle the autoplay feature
const toggleAutoplay = (videos) => {
	if (localStorage.animationsPaused) {
		videos.forEach(video => {
			if (localStorage.animationsPaused == 'true') {
				video.pause();
				video.autoplay = false;
			} else if (localStorage.animationsPaused == 'false') {
				video.play();
				video.autoplay = true;
			}
		});
	}
};

// Set HTML data attribute
const switchAnimationPreference = (value, attr) => {
	const html = document.documentElement;
	html.setAttribute(attr, value);
};

// Set OS's reduced motion state
const setReducedMotionState = () => {
	// get media reduced motion state
	const mediaQuery = window.matchMedia("(prefers-reduced-motion: reduce)");

	// if reduced animation is set
	if (!mediaQuery || mediaQuery.matches) {
		// Set paused animations
		localStorage.animationsPaused = true;
	} else {
		// Set animations
		localStorage.animationsPaused = false;
	}
};

export const init = () => {
	// Run the pause animation
	pauseAnimations('pause-animations');
};
