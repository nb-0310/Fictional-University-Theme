export default class MyNotes {
	constructor() {
		this.events();
	}

	events() {
		const notesList = document.querySelector("#my-notes");

		notesList.addEventListener("click", (event) => {
			const target = event.target;

			if (target.classList.contains("edit-note")) {
				this.editNote(event);
			} else if (target.classList.contains("delete-note")) {
				this.deleteNote(event);
			} else if (target.classList.contains("update-note")) {
				this.updateNote(event);
			}
		});

		const createButton = document.querySelector(".submit-note");
		if (createButton) {
			createButton.addEventListener("click", this.createNote.bind(this));
		}
	}

	editNote(e) {
		const editButton = e.target.closest(".edit-note");
		const liElement = editButton.closest("li");
		const inputField = liElement.querySelector(".note-title-field");

		if (!inputField.readOnly) {
			this.makeNoteReadOnly(liElement);
		} else {
			this.makeNoteEditable(liElement);
		}
	}

	makeNoteEditable(liElement) {
		const inputField = liElement.querySelector(".note-title-field");
		const textareaField = liElement.querySelector(".note-body-field");
		const updateBtn = liElement.querySelector(".update-note");
		const editButton = liElement.querySelector(".edit-note");

		inputField.removeAttribute("readonly");
		textareaField.removeAttribute("readonly");

		inputField.classList.add("note-active-field");
		textareaField.classList.add("note-active-field");

		updateBtn.classList.add("update-note--visible");
		editButton.innerHTML = '<i class="fa fa-times"></i> Cancel';
	}

	makeNoteReadOnly(liElement) {
		const inputField = liElement.querySelector(".note-title-field");
		const textareaField = liElement.querySelector(".note-body-field");
		const updateBtn = liElement.querySelector(".update-note");
		const editButton = liElement.querySelector(".edit-note");

		inputField.setAttribute("readonly", true);
		textareaField.setAttribute("readonly", true);

		inputField.classList.remove("note-active-field");
		textareaField.classList.remove("note-active-field");

		updateBtn.classList.remove("update-note--visible");
		editButton.innerHTML = '<i class="fa fa-pencil"></i> Edit';
	}

	async deleteNote(e) {
		const deleteButton = e.target.closest(".delete-note");
		const liElement = deleteButton.closest("li");
		const id = liElement.id;

		try {
			const res = await fetch(
				`http://localhost:10013/wp-json/wp/v2/note/${id}`,
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
			console.log("Delete successful", data);

            liElement.classList.remove("fade-in");
			liElement.classList.add("fade-out");

			liElement.addEventListener("transitionend", () => {
				liElement.remove();
			});
		} catch (error) {
			console.error("Error deleting note:", error);
		}
	}

	async updateNote(e) {
		const updateButton = e.target.closest(".update-note");
		const liElement = updateButton.closest("li");
		const id = liElement.id;
		const inputField = liElement.querySelector(".note-title-field");
		const textareaField = liElement.querySelector(".note-body-field");

		this.makeNoteReadOnly(liElement);

		const noteData = {
			title: inputField.value,
			content: textareaField.value,
		};

		try {
			const res = await fetch(
				`http://localhost:10013/wp-json/wp/v2/note/${id}`,
				{
					method: "POST",
					headers: {
						"Content-Type": "application/json",
						Authorization: "Bearer YOUR_ACCESS_TOKEN",
						"X-WP-Nonce": universityData.nonce,
					},
					body: JSON.stringify(noteData),
				}
			);

			if (!res.ok) {
				throw new Error(`HTTP error! Status: ${res.status}`);
			}

			const data = await res.json();
			console.log("Update successful", data);
		} catch (error) {
			console.error("Error updating note:", error);
		}
	}

	async createNote(e) {
		const updateButton = e.target.closest(".create-note");
		const inputField = document.querySelector(".new-note-title");
		const textareaField = document.querySelector(".new-note-body");
		const notes = document.querySelector("#my-notes");

		const noteData = {
			title: inputField.value,
			content: textareaField.value,
			status: "publish",
		};

		try {
			const res = await fetch(`http://localhost:10013/wp-json/wp/v2/note`, {
				method: "POST",
				headers: {
					"Content-Type": "application/json",
					Authorization: "Bearer YOUR_ACCESS_TOKEN",
					"X-WP-Nonce": universityData.nonce,
				},
				body: JSON.stringify(noteData),
			});

			if (!res.ok) {
				throw new Error(`HTTP error! Status: ${res.status}`);
			}

			const data = await res.json();
			console.log("Update successful", data);

			const newNote = document.createElement("li");
			newNote.id = data.id;
			newNote.innerHTML = `
            <input readonly type="text" class="note-title-field" value="${data.title.raw}">
            <span class="edit-note"><i class="fa fa-pencil"></i> Edit</span>
            <span class="delete-note"><i class="fa fa-trash-o"></i> Delete</span>
            <textarea readonly class="note-body-field">${data.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right"></i> Save</span>
        `;

			notes.prepend(newNote);
			newNote.classList.add("fade-in");

			inputField.value = "";
			textareaField.value = "";
		} catch (error) {
			console.error("Error updating note:", error);
		}
	}
}
