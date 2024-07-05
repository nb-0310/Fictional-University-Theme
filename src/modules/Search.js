class Search {
	constructor() {
		this.openButton = document.querySelectorAll(".js-search-trigger");
		this.closeButton = document.querySelector(".search-overlay__close");
		this.searchOverlay = document.querySelector(".search-overlay");
		this.resultsDiv = document.querySelector(".search-overlay__results");
		this.searchTerm = document.querySelector(".search-term");

		console.log(this.searchTerm);
		this.typingTimer;

		this.openButton.forEach((ele) => {
			ele.addEventListener("click", () => {
				console.log("Direct click on openButton");
			});
		});

		this.events();
	}

	events() {
		this.openButton.forEach((ele) => {
			ele.addEventListener("click", this.openOverlay.bind(this));
		});

		this.closeButton.addEventListener("click", this.closeOverlay.bind(this));

		document.addEventListener("keyup", this.keyPressDispatcher.bind(this));

		this.searchTerm.addEventListener("keyup", this.typingLogic.bind(this));
	}

	openOverlay() {
		event.stopPropagation();
		event.preventDefault();
		console.log("Open button clicked");
		if (this.searchOverlay) {
			this.searchOverlay.classList.add("search-overlay--active");
			document.querySelector("body").classList.add("body-no-scroll");
			console.log("Overlay should be active now");
		} else {
			console.error("Search overlay not found");
		}
	}

	closeOverlay() {
		console.log("Close button clicked");
		if (this.searchOverlay) {
			this.searchOverlay.classList.remove("search-overlay--active");
			document.querySelector("body").classList.remove("body-no-scroll");
			console.log("Overlay should be inactive now");
		} else {
			console.error("Search overlay not found");
		}
	}

	keyPressDispatcher(event) {
		if (event.key === "s" && activeElement.tagName !== "INPUT" && activeElement.tagName !== "TEXTAREA") {
			this.openOverlay(event);
		} else if (event.key === "Escape") {
			this.closeOverlay();
		}
	}

	typingLogic() {
		console.log("called!");
		clearTimeout(this.typingTimer);
        
        if (this.resultsDiv.innerHTML !== '<div class="spinner-loader"></div>') this.resultsDiv.innerHTML = '<div class="spinner-loader"></div>'

		this.typingTimer = setTimeout(() => {
			this.resultsDiv.innerHTML = "Imagine real search results";
		}, 500);
	}
}

export default Search;
