const piDeleteButtons = document.querySelectorAll('.delete-pi-btn');

piDeleteButtons.forEach(function (button) {
	button.addEventListener("click", function (event) {
		$('#confirmDeletePiModal').modal('show');
		const confirmButton = document.getElementById("deletePiEndpoint");
		confirmButton.href = "/endpoints/delete_pi.php?piId=" + button.dataset.piid;
	});
});

const piProvisionsButtons = document.querySelectorAll('.provision-pi-btn');

piProvisionsButtons.forEach(function (button) {
	button.addEventListener("click", function (event) {
		$('#confirmProvision').modal('show');
		const confirmButton = document.getElementById("provisionPiEndpoint");
		confirmButton.href = "/endpoints/provision_pi.php?piId=" + button.dataset.piid;
	});
});

function templateParamInputBuilder(type, internalId, placeholder) {
	if (type == "url") {
		input = document.createElement("input");
		input.setAttribute("type", "url");
		input.classList.add("form-control");
		input.classList.add("templateDynamicFormElement");
		input.setAttribute("placeholder", placeholder);
		input.setAttribute("id", "template-param-" + internalId);
		return input;
	}
}

function selectTemplate(value) {
	$.ajax({
		url: "/endpoints/templates.php",
		context: document.body
	}).done(function (data) {
		template_param_div = document.getElementById("template_param_container");
		template_param_div.innerHTML = "";
		data = JSON.parse(data);
			data.forEach(function (template) {
				if (template.template_name == value && template.params) {
					//Build the template parameter form
					for (var i = 0; i < template.params.length; i++) {
						//For each template parameter
	
						if (i == 0 || i % 2 == 0) {
							//For even parameters, create a new row
							row_div = document.createElement("div");
							row_div.classList.add("row");
						}
	
						col_div = document.createElement("div");
						col_div.classList.add("col-md-6");
						col_div.classList.add("col-12");
						form_group_div = document.createElement("div");
						form_group_div.classList.add("form-group");
						param_label = document.createElement("label");
						param_label.setAttribute("for", "param" + i);
						param_label.innerHTML = template.params[i].name;
						param_small = document.createElement("small");
						param_small.classList.add("form-text");
						param_small.classList.add("text-muted");
						param_small.innerHTML = template.params[i].description;
						input = templateParamInputBuilder(template.params[i].type, template.params[i].internal_id, template.params[i].placeholder)
	
						col_div.append(param_label);
						col_div.append(input);
						col_div.append(param_small);
						row_div.append(col_div);
	
						if (i % 2 == 1 || i == template.params.length - 1) {
							//For odd parameters, append the current_row to the page
							template_param_div = document.getElementById("template_param_container");
							template_param_div.append(row_div);
						}
					}
				}
			});
	});
}

function submit_new_pi() {

	const dynamicInputs = document.getElementsByClassName("templateDynamicFormElement");
	var values = [];

	for (var i = 0; i < dynamicInputs.length; i++) {
		param = {
			key : dynamicInputs[i].id,
			value: dynamicInputs[i].value
		}

		values.push(param);
	}

	templateJson = JSON.stringify(values);

	const jsonHiddenField = document.getElementById("templateParams");
	jsonHiddenField.value = templateJson;

	const form = document.getElementById("newPiForm");
	form.submit();
}