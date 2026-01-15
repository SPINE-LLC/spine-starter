// Function to handle the visibility changes and add/remove classes
const handleVisibilityChange = (entries) => {
	entries.forEach((entry) => {
		const position = entry.target.getAttribute("data-position");
		if (position) {
			if (entry.isIntersecting) {
				document.body.classList.add(position);
			} else {
				document.body.classList.remove(position);
			}
		}
	});
};

export const init = () => {
	// Set up the IntersectionObserver to observe elements with data-position
	const observer = new IntersectionObserver(handleVisibilityChange, {
		threshold: 0, // Adjust this based on how much of the element needs to be visible
	});

	// Select all elements with a data-position attribute and observe them
	document
		.querySelectorAll("[data-position]")
		.forEach((element) => observer.observe(element));
};
