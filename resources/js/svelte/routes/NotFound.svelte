<script>
    import { windowStore } from '../store.js'

	const xMiddle = window.innerWidth / 2
	const yMiddle = window.innerHeight / 2

	$windowStore = [
		{	
			id: 1,
			title: 'not found', 
			x: xMiddle - 150, 
			y: yMiddle - 150, 
			isScrollable:false, 
            width: 300,
            height: 300,
			titleColorFrom:'from-red-300',
			content: '<h1 class="text-2xl"> sorry not found </h1>'
		}
	]
</script>
