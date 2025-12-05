

$(document).ready(async function() {
	var data = await fetchJSON();
	// console.log(data[0].name);
	console.log("data = "+data);

	petGrid = document.getElementById('pet-grid');
	// petGrid.innerHTML = data; hehehe
	console.log("add "+data.length+" blocks");
	for(var i = 0; i < data.length; i++) {
		petGrid.innerHTML += "<div class='pet-block'> <div class='cat-pic'><img src='" + getRandCat() + "'></div><div class='pet-info'> <h3>"+data[i].name+"</h3> <h5>"+data[i].type+"<br><br>"+data[i].gender+",<br>"+data[i].age+" old </h5> </div> <div class='pet-info'> <button type='button' class='btn'>View</button> </div> </div>";
		console.log("adding pet-block");
		console.log("image "+getRandCat());
	}
});


function fetchJSON() {
	return fetch('/intro_team19_F25/pet_data/info.json')
		.then(response => {
			if(!response.ok) {
				throw new Error(`HTTP error! Status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			console.log(data);
			return data;
		})
		.catch(error => console.error('Failed to fetch data:', error));
}


function getRandCat() {
	let num = (Math.floor(Math.random()*123)+1).toString();
	let string = "/intro_team19_F25/pet_data/Generic_Cat_Photos/catPics"+ num + ".jpg";
	return string;
}