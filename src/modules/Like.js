export default class Like {
	constructor() {
		this.events();
	}

	events() {
		document
			.querySelector(".like-box")
			.addEventListener("click", this.ourClickDispatcher.bind(this));
	}

	ourClickDispatcher(e) {
		const currentLikeBox = e.target.closest(".like-box");
		const exists = currentLikeBox.getAttribute("data-exists");

		console.log(exists);

		if (exists === "yes") {
			this.deleteLike();
		} else {
			this.createLike();
		}
	}

	async createLike() {
		try {
			const res = await fetch(
				`http://localhost:10013/wp-json/university/manageLike`,
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						Authorization: "Bearer YOUR_ACCESS_TOKEN",
						"X-WP-Nonce": universityData.nonce,
					},
                    body: {
                        professorId: '123'
                    }
				}
			);

			if (!res.ok) {
				throw new Error(`HTTP error! Status: ${res.status}`);
			}

			const data = await res.json();
			console.log("Update successful", data);
		} catch (err) {
            console.log('there was an error')
			console.error(err);
		}
	}

	async deleteLike() {
		try {
			const res = await fetch(
				`http://localhost:10013/wp-json/university/manageLike`,
				{
					method: "DELETE",
					headers: {
						"Content-Type": "application/json",
						Authorization: "Bearer YOUR_ACCESS_TOKEN",
						"X-WP-Nonce": universityData.nonce,
					},
				}
			);

			if (!res.ok) {
				throw new Error(`HTTP error! Status: ${res.status}`);
			}

			const data = await res.json();
			console.log("Update successful", data);
		} catch (err) {
			console.error(err);
		}
	}
}
