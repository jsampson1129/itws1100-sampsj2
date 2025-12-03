function validateForm() {
  const form = document.contactForm;
  let valid = true;
  let message = "";

  if (form.firstName.value.trim() === "") {
    message += "First Name is required.\n";
    valid = false;
  }
  if (form.lastName.value.trim() === "") {
    message += "Last Name is required.\n";
    valid = false;
  }
  if (form.nickname.value.trim() === "") {
    message += "Nickname is required.\n";
    valid = false;
  }
  if (form.email.value.trim() === "") {
    message += "Email is required.\n";
    valid = false;
  }
  if (form.comments.value === "" || form.comments.value === "Please enter your comments") {
    message += "Comments are required.\n";
    valid = false;
  }

  if (!valid) {
    alert(message);
    return false;
  }

  alert("Form submitted successfully!");
  return false; 
}

function clearComments(textarea) {
  if (textarea.value === "Please enter your comments") {
    textarea.value = "";
  }
}

function restoreComments(textarea) {
  if (textarea.value.trim() === "") {
    textarea.value = "Please enter your comments";
  }
}

function showName() {
  const first = document.getElementById("firstName").value.trim();
  const last = document.getElementById("lastName").value.trim();
  const nick = document.getElementById("nickname").value.trim();

  if (first && last && nick) {
    alert(`${first} ${last} is ${nick}`);
  } else {
    alert("Please fill in First Name, Last Name, and Nickname first.");
  }
}