const piDeleteButtons = document.querySelectorAll('.delete-pi-btn');

piDeleteButtons.forEach(function (button) {
	button.addEventListener("click", function(event) {
		$('#confirmDeletePiModal').modal('show');
		const confirmButton = document.getElementById("deletePiEndpoint");
		confirmButton.href = "/endpoints/delete_pi.php?piId=" + button.dataset.piid;
	});
});

const piProvisionsButtons = document.querySelectorAll('.provision-pi-btn');

piProvisionsButtons.forEach(function (button) {
	button.addEventListener("click", function(event) {
		$('#confirmProvision').modal('show');
		const confirmButton = document.getElementById("provisionPiEndpoint");
		confirmButton.href = "/endpoints/provision_pi.php?piId=" + button.dataset.piid;
	});
});