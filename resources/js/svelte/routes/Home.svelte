<script>
    import { windowStore } from '../store.js'

    const getAge = (dateString) => {
		const today = new Date();
		const birthDate = new Date(dateString);
		let age = today.getFullYear() - birthDate.getFullYear();
		const m = today.getMonth() - birthDate.getMonth();
		if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
			age--;
		}
		return age;
	}

	const xMiddle = window.innerWidth / 2
	const yMiddle = window.innerHeight / 2

	$windowStore = [
		{
			id: 'whocares',
			titleColorFrom:'from-yellow-300',
			titleColorTo:'to-gray-900',
			x: xMiddle - 289,
			y: 0,
			md: 'under-construction.md'
		},
		{
			id: 'welcome',
			title: 'Welkom',
			titleColorFrom:'from-green-300',
			titleColorTo:'to-blue-900',
			width: 500,
			x: xMiddle - 505,
			y: 200,
			md: 'welcome.md'
		},
		{
			id: 'goals',
			title: 'Doelstellingen',
			titleColorFrom:'from-yellow-300',
			titleColorTo:'to-green-900',
			width: 500,
			x: xMiddle + 25,
			y: 200,
			md: 'goals.md'
		},
		{
			id: 'easter-egg',
			y: window.innerHeight,
			x: window.innerWidth,
			content: `<img width=100  on:click="{() => push('/contact')}" src="https://cdn.pixabay.com/photo/2015/02/28/20/30/easter-653985_960_720.png"/>`
		},
		{
			id: 'todo',
			title: 'secret to-do list',
			titleColorFrom:'from-yellow-300',
			titleColorTo:'to-gray-900',
			width: 300,
			y: 0,
			x: window.innerWidth - 300,
			md: 'todo.md'
		},
		{	
			id: 'foto',
			title: 'foto', 
			x: xMiddle - 656, 
			y: yMiddle - 200, 
			isScrollable:false, 
			titleColorFrom:'from-purple-300',
			content: `<img src="/media/me.jpg" alt="👨"/>`
		},
		{
			id: 'over-mij',
			title: 'over mij', 
			width:600, 
			x: xMiddle + 30, 
			y: yMiddle - 200, 
			isScrollable:false, 
			titleColorFrom:'from-red-300', 
			titleColorTo:'to-yellow-500',
			content: 
				`<h1 class="text-2xl"> Rens Moring </h1>
				<p>
					Om even een korte profielschets te geven; Ik ben ${getAge('November 26, 1993')} jaar oud, en ik heb Informatica gestudeerd aan de Hogeschool Rotterdam. 
					Als hobby's heb ik onder andere zeilen, en gamen. Ik heb een oude laptop (en vps) met ubuntu en in mijn rommel-lade liggen een raspberry pi, arduino en een rtl-sdr die ik af en toe pak om mee te experimenteren. 
					Verder heb ik nog een gezonde interesse in muziek, films, Nederlandse taal, en design.
				</p>`
		},
	]
</script>
