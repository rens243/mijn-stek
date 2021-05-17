<script>
    import { windowStore } from '../store.js'

	const xMiddle = window.innerWidth / 2
	const yMiddle = window.innerHeight / 2

	$windowStore = [
		{	
			id: 1,
			title: 'ik heb dit gedaan', 
			x: xMiddle - 200, 
			y: 500, 
			isScrollable:false, 
			titleColorFrom:'from-purple-300',
			content: `niet zo veel`
		},
	]
</script>
