// Types of inputs
const inputTypes = {
	mouse: "mouse",
	keyboard: "keyboard",
	touch: "touch",
	pen: "pen",
};

// Store the last detected input type
let lastInputType = "";

// Update the data attribute if the input type has changed
function setInputType(type) {
	// Only update if the input type is different
	if (lastInputType !== type) {
		document.documentElement.setAttribute("data-is-input", type);
		lastInputType = type;
	}
}

// Detect mouse interactions
function detectMouse() {
	document.addEventListener("mousedown", function () {
		setInputType(inputTypes.mouse);
	});
	document.addEventListener("click", function () {
		setInputType(inputTypes.mouse);
	});
}

// Detect keyboard interactions
function detectKeyboard() {
	document.addEventListener("keydown", function () {
		setInputType(inputTypes.keyboard);
	});
	document.addEventListener("keypress", function () {
		setInputType(inputTypes.keyboard);
	});
}

// Detect touch interactions
function detectTouch() {
	document.addEventListener("touchstart", function () {
		setInputType(inputTypes.touch);
	});
	document.addEventListener("touchend", function () {
		setInputType(inputTypes.touch);
	});
}

// Detect pen interactions (via pointer events)
function detectPen() {
	document.addEventListener("pointerdown", function (event) {
		if (event.pointerType === "pen") {
			setInputType(inputTypes.pen);
		}
	});
}

export const init = () => {
	// Set default to mouse
	setInputType(inputTypes.mouse);
	detectMouse();
	detectKeyboard();
	detectTouch();
	detectPen();
};
