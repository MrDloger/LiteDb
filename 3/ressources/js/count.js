fetch('https://ipapi.co/json/').then(response => response.json())
	.then(response => {
		console.log(response)
	});