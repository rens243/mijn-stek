<script>
	import { windowStore, activeWindow } from '../store'
	import OldWindow from './OldWindow.svelte'

	// export let name;
    export let list = []
    $windowStore = list

	let bgPosX = 0;
	let bgPosY = 0;

	// Helper function to move windows
    const moveWindows = (dX, dY) => {
        // Move windows
        $windowStore = windowStoreMap((oldWindow) => {
            oldWindow.x = oldWindow.x + dX
            oldWindow.y =  oldWindow.y + dY
            return oldWindow
        })
    }

    // Helper function to move background
    const moveBackground = (dX, dY) => {
        bgPosX = bgPosX + dX
        bgPosY = bgPosY + dY
    }

	// Dragging logic
	let cursor = 'grab'
    let dragActive = false

    // Delta x and y when grabbing
    let dX
    let dY

    const dragStart = (e) => {
		cursor = 'grabbing'
        dragActive = true
    }
    const dragMove = (e) => {
        if (!dragActive) return

        dX = e.movementX
        dY = e.movementY

		moveWindows(dX, dY)
        moveBackground(dX, dY)
    }
    const dragEnd = (e) => {
        if (dragActive) {
            // End drag
            dragActive = false
            cursor = 'grab'

            const inertiaDrag = () => {
                // Stop inertia if drag is enabled again
                if (dragActive) return

                // No delta, nothing to move
                if (Math.abs(dX) < 0.1 && Math.abs(dY) < 0.1 ) {
                    dX = null
                    dY = null
                    return
                }

                console.log(dX, dY);

                dX = dX * 0.95
                dY = dY * 0.95

                moveWindows(dX, dY)
                moveBackground(dX, dY)

                window.requestAnimationFrame(inertiaDrag);
            }

            window.requestAnimationFrame(inertiaDrag)
        }

	    // End drag
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
        <OldWindow {...oldWindow} on:dragStart="{dragStartWindow}" on:dragMove="{dragMoveWindow}"
                   on:dragEnd="{dragEndWindow}"/>
	{/key}
{/each}


<!-- actual background -->
<div id="main-bg" style="{`--bg-pos-y:${bgPosY};--bg-pos-x:${bgPosX}`}" class="cursor-{cursor}" on:mousedown="{dragStart}">
</div>
<svelte:body on:mousemove="{dragMove}" on:mouseleave="{dragEnd}" on:mouseup="{dragEnd}"/>

<style>
	:global(body) {
		overflow: hidden;
        background-image: linear-gradient(to top, #a18cd1 0%, #fbc2eb 100%);
	}

	#main-bg {
		width: 100%;
		height: 100%;
		background-size: 200px 200px;
		background-position-x: calc(var(--bg-pos-x, 0) * 1px);
		background-position-y: calc(var(--bg-pos-y, 0) * 1px);
		background-image: url("/media/star.png");
        filter: invert(54%) sepia(38%) saturate(6813%) hue-rotate(164deg) brightness(98%) contrast(103%);
	}

</style>
