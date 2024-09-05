const url = 'https://testamo/3/count.php';
fetch('https://ipapi.co/json/').then(response => response.json())
	.then(response => {
		fetch(
			url,
			{
				method: 'POST',
				body: JSON.stringify({
					ip: response.ip,
					city: response.city,
					platform: navigator.platform
				})
			} 
		).then(r => r.text()).then(r => console.log(r))
	});