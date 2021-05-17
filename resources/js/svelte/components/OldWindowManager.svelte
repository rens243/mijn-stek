<script>
	import { windowStore, activeWindow } from '../store'
	import OldWindow from './OldWindow.svelte'

	// export let name;
    export let list = []
    $windowStore = list

	let bgPosX = 0;
	let bgPosY = 0;

	// Dragging logic	
	let cursor = 'grab'
    let dragActive = false
    const dragStart = (e) => {
		cursor = 'grabbing'
        dragActive = true	
    }
    const dragMove = (e) => {
        if (!dragActive) return

		// Move windows
		$windowStore = windowStoreMap((oldWindow) => {
			oldWindow.x = oldWindow.x + e.movementX
			oldWindow.y =  oldWindow.y + e.movementY
			return oldWindow
		})
		
		// Move background
		bgPosX = bgPosX + e.movementX
		bgPosY = bgPosY + e.movementY
    }
    const dragEnd = (e) => {
		dragActive = false
		cursor = 'grab'
	}

	// Window drag logic
	let dragActiveWindow = null
	const dragStartWindow = (e) => {
        if (dragActiveWindow == null) dragActiveWindow = e.detail.id
        
		// Set current active
        $activeWindow = e.detail.id 
    }
    const dragMoveWindow = (e) => {
		const currentId = e.detail.id
        if (dragActiveWindow !== currentId) return

		windowStoreMap((oldWindow) => {
			if (oldWindow.id == currentId) {
				// Add position difference to window
				oldWindow.y = oldWindow.y + e.detail.mouseEvent.movementY
				oldWindow.x = oldWindow.x + e.detail.mouseEvent.movementX 
			}
			return oldWindow
		})
    }
    const dragEndWindow = (e) => dragActiveWindow = null

	const windowStoreMap = (mapF) => $windowStore = $windowStore.map(oldWindow => mapF(oldWindow))
</script>

<!-- all the fancy windows -->
{#each $windowStore as oldWindow}
	{#key oldWindow.id}
		<OldWindow {...oldWindow} on:dragStart="{dragStartWindow}" on:dragMove="{dragMoveWindow}" on:dragEnd="{dragEndWindow}"></OldWindow>
	{/key}
{/each}


<!-- actual background -->
<div id="main-bg" style="{`--bg-pos-y:${bgPosY};--bg-pos-x:${bgPosX}`}" class="cursor-{cursor}" on:mousedown="{dragStart}" on:mousemove="{dragMove}" on:mouseleave="{dragEnd}" on:mouseup="{dragEnd}">
    <div class="absolute bg-red-400 top-1/2 left-1/2" style="width:2px; height:2px"></div>
</div>

<style>
	:global(body) {
		overflow: hidden;
	}

	#main-bg {
		width: 100%;
		height: 100%;
		background-color: #666699;
		background-size: 600px 600px;
		background-position-x: calc(var(--bg-pos-x, 0) * 1px);
		background-position-y: calc(var(--bg-pos-y, 0) * 1px);
		background-image:
			linear-gradient(to right, #72008f 1px, transparent 1px),
			linear-gradient(to bottom, #72008f 1px, transparent 1px);
	}

</style>
