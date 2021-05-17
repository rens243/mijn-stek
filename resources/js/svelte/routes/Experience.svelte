<script>
    import { windowStore } from '../store.js'

	const xMiddle = window.innerWidth / 2
	const yMiddle = window.innerHeight / 2

	$windowStore = [
		{
			id: 'ziemijnlinked',
            title: 'LinkedIn',
            width: 300,
            titleColorFrom:'from-blue-300',
			titleColorTo:'to-blue-300',
            x: xMiddle - 150,
			y: 0,
            content: `Zie ook mijn <a href="https://www.linkedin.com/in/rens-moring/">LinkedIn</a> <br/>`
        },
		{	
			id: 'opleiding',
			title: 'Opleiding', 
			width: 600,
			x: xMiddle + 5, 
			y: 150, 
			isScrollable:false, 
			titleColorFrom:'from-blue-300',
			md: 'opleiding.md'
		},
		{	
			id: 'werkervaring',
			title: 'Werkervaring', 
            width: 600,
			x: xMiddle - 605, 
			y: 150, 
			md: 'werk.md'
		},
	]

</script>
